<template>
  <section class="p-6 space-y-8">
    <!-- HEADER -->
    <header class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
      <div>
        <h1 class="heading-1">Dashboard</h1>
        <p class="text-gray-600 text-sm">Ringkasan aktivitas dan statistik sistem.</p>
      </div>
    </header>

    <!-- STAT CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">
      <BaseCard
        v-for="(stat, index) in stats"
        :key="index"
        class="flex flex-col justify-between p-5 transition duration-150 hover:shadow-lg"
      >
        <!-- HEADER (Label, Value, & Icon) -->
        <div class="flex items-start justify-between">
          <div>
            <!-- Label -->
            <h3 class="text-sm font-medium text-gray-500">{{ stat.label }}</h3>
            <!-- Value (Menggunakan valueDisplay yang sudah diformat) -->
            <p class="text-3xl font-bold text-gray-900 mt-1">
              {{ stat.valueDisplay || stat.value }}
            </p>
          </div>

          <!-- Icon Container (Clean, Estetik, Berwarna, dan Bulat) -->
          <div :class="[stat.color.bg, stat.color.text]" class="p-3 rounded-full shadow-md">
            <!-- Komponen Ikon Dinamis -->
            <!-- Kami menggunakan `stat.icon` yang sudah ditambahkan di dashboardData.js -->
            <component :is="stat.icon" class="w-6 h-6" />
          </div>
        </div>

        <!-- CHANGE (Persentase) -->
        <p
          class="text-sm mt-3 font-medium flex items-center gap-1"
          :class="stat.change > 0 ? 'text-green-600' : 'text-red-600'"
        >
          <!-- Ikon Panah untuk Estetika Konsisten -->
          <ArrowUpRightIcon v-if="stat.change > 0" class="w-4 h-4" />
          <ArrowDownRightIcon v-else class="w-4 h-4" />

          <span>{{ stat.change > 0 ? "+" : "" }}{{ stat.change }}% dari bulan lalu</span>
        </p>
      </BaseCard>
    </div>

    <!-- RECENT ORDERS TABLE -->
    <BaseCard>
      <div class="flex justify-between items-center mb-5">
        <h2 class="heading-2">Pesanan Terbaru</h2>

        <BaseButton variant="primary" size="sm" @click="handleNavigation('AdminOrders')">
          Semua Pesanan
          <ArrowRight class="w-4 h-4 ml-1" />
        </BaseButton>
      </div>

      <BaseTable
        v-if="recentOrders.length > 0"
        :columns="dashboardOrderColumns"
        :rows="recentOrders"
      >
        <!-- STATUS -->
        <template #status="{ row }">
          <BaseStatusBadge :status="row.status" />
        </template>

        <!-- ACTIONS -->
        <template #action="{ row }">
          <RowActions :item="row" @detail="openModal" />
        </template>
      </BaseTable>
      <BaseEmptyState
        v-else
        title="Tidak ada Pesanan Ditemukan"
        description="Belum ada Pesanan masuk."
        :icon="Receipt"
      />
    </BaseCard>

    <!-- Meneruskan driverOptions ke modal -->
    <OrdersModal
      v-model="isModalOpen"
      :order="selectedOrder"
      mode="detail"
      :status-options="statusOptions.filter((s) => s !== 'Status')"
      :driver-options="dashboardDriverOptions"
    />
  </section>
</template>

<script setup>
import BaseButton from "@/components/base/BaseButton.vue";
import BaseCard from "@/components/base/BaseCard.vue";
import BaseTable from "@/components/base/BaseTable.vue";
import BaseStatusBadge from "@/components/base/BaseStatusBadge.vue";
import BaseEmptyState from "@/components/base/BaseEmptyState.vue";
import RowActions from "@/components/admin/dashboard/RowActions.vue";
import OrdersModal from "@/components/admin/orders/OrdersModal.vue";

import { ref, computed } from "vue";
// Memuat data stat yang kini berisi ikon dan warna
import { stats } from "@/data/dashboardData";

import { columns, rows, statusOptions } from "@/data/ordersData";
import {
  ArrowRight,
  // Ikon tambahan untuk estetika persentase
  ArrowUpRightIcon,
  ArrowDownRightIcon,
  Receipt,
} from "lucide-vue-next";
import { useRouter } from "vue-router";

// --- PENGATURAN DATA KONSISTENSI ---
const dashboardOrderColumns = [...columns];

// Ambil baris lengkap dari ordersData dan potong 10 pesanan terbaru
const recentOrders = computed(() => {
  return rows.slice(0, 10);
});
// ----------------------------------------

// Dummy Driver Options
const dashboardDriverOptions = ["Belum ditetapkan", "Dodii", "Bagas", "Nopal", "Udin", "Supri"];

const isModalOpen = ref(false);
const selectedOrder = ref(null);

const openModal = (order) => {
  selectedOrder.value = order;
  isModalOpen.value = true;
};

const router = useRouter();
// Fungsi untuk menangani navigasi "Semua Pesanan"
const handleNavigation = (routeName) => {
  router.push({ name: routeName });
};
</script>
