<template>
  <div class="space-y-8">
    <!-- Status Pesanan Saat Ini (Progress Bar - Status Aktif) -->
    <UserAppCard padding="sm" class="border-red-200 shadow-lg">
      <div class="flex justify-between items-center mb-4">
        <div class="flex items-center gap-2">
          <Truck class="w-5 h-5 text-red-600" />
          <h2 class="text-lg font-bold text-gray-800">Status Pesanan Aktif</h2>
        </div>
        <span v-if="activeOrder" class="text-sm font-semibold text-gray-600">
          Pesanan {{ activeOrder.orderNumber }}
        </span>
        <span v-else class="text-sm text-gray-400"> Tidak ada pesanan aktif </span>
      </div>

      <!-- Progress Bar Visual -->
      <div class="w-full bg-gray-200 rounded-full h-2.5 mb-3">
        <div
          class="bg-red-600 h-2.5 rounded-full transition-all duration-700"
          :style="{ width: currentOrderProgress + '%' }"
        ></div>
      </div>

      <!-- Status Labels: Tertunda -> Diproses -> Dikirim -> Selesai -->
      <div class="flex justify-between text-xs font-medium">
        <div :class="progressClass(0)">Tertunda</div>
        <div :class="progressClass(33)">Diproses</div>
        <div :class="progressClass(66)">Dikirim</div>
        <div :class="progressClass(100)">Selesai</div>
      </div>
    </UserAppCard>

    <!-- Riwayat Pesanan (Menggunakan BaseTable) -->
    <UserAppCard padding="sm">
      <div class="flex items-center gap-2 mb-6">
        <History class="w-5 h-5 text-red-600" />
        <h2 class="text-lg font-bold text-gray-800">Riwayat Pesanan</h2>
      </div>

      <div class="rounded-xl border border-gray-100 overflow-hidden">
        <BaseTable :columns="orderColumns" :rows="props.orders">
          <!-- Slot untuk Kolom TOTAL (untuk format mata uang) -->
          <template #total="{ row }">
            <span class="font-semibold text-gray-800">{{ row.total }}</span>
          </template>

          <!-- Slot untuk Kolom STATUS (Menggunakan BaseStatusBadge) -->
          <template #status="{ row }">
            <BaseStatusBadge :status="row.status" />
          </template>

          <!-- Slot untuk Kolom AKSI (Menggunakan DetailButton) -->
          <template #action="{ row }">
            <DetailButton @click="goToDetailPesanan(row)" />
          </template>
        </BaseTable>
      </div>

      <!-- Kondisi jika tidak ada pesanan -->
      <div v-if="props.orders.length === 0" class="py-12 text-center text-gray-500 text-sm">
        Anda belum memiliki riwayat pesanan.
      </div>
    </UserAppCard>
  </div>
</template>

<script setup>
import { computed } from "vue";
import { History, Truck } from "lucide-vue-next";
import UserAppCard from "@/components/baseUser/UserAppCard.vue";
import BaseTable from "@/components/base/BaseTable.vue";
import BaseStatusBadge from "@/components/base/BaseStatusBadge.vue";
import DetailButton from "@/components/admin/RowButton/DetailButton.vue";

const props = defineProps({
  orders: {
    type: Array,
    default: () => [],
  },
  loading: {
    type: Boolean,
    default: false,
  },
});

defineEmits(["printReceipt"]);

// ======================
// ACTIVE ORDER (progress bar)
// ======================
const activeOrder = computed(() =>
  props.orders.find(o =>
    ["Tertunda", "Diproses", "Dikirim"].includes(o.status)
  )
);

const currentOrderProgress = computed(() => {
  if (!activeOrder.value) return 0;
  return {
    Tertunda: 0,
    Diproses: 33,
    Dikirim: 66,
    Selesai: 100,
  }[activeOrder.value.status] || 0;
});

const progressClass = threshold =>
  currentOrderProgress.value >= threshold
    ? "text-red-600 font-bold"
    : "text-gray-500";

// ======================
// TABLE CONFIG
// ======================
const orderColumns = [
  { key: "orderNumber", label: "ID Pesanan" },
  { key: "date", label: "Tanggal" },
  { key: "items", label: "Item" },
  { key: "total", label: "Total" },
  { key: "status", label: "Status" },
  { key: "action", label: "Aksi" },
];

// ======================
// ACTION
// ======================
const goToDetailPesanan = (row) => {
  console.log("DETAIL PESANAN USER:", row.raw);
};
</script>

