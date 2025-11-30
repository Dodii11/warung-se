<template>
  <section class="p-6 space-y-8">
    <!-- HEADER -->
    <header class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
      <div>
        <h1 class="heading-1">Manajemen Pesanan</h1>
        <p class="text-gray-600 text-sm">Kelola pesanan terbaru, status, dan detail pelanggan.</p>
      </div>
    </header>

    <!-- FILTERS -->
    <BaseCard class="p-4">
      <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex items-center gap-3 flex-wrap">
          <OrdersFilter @update:filter="updateFilter" />
        </div>
        <div class="flex justify-end w-full md:w-auto">
          <OrdersSearch v-model="search" class="w-full md:w-64" />
        </div>
      </div>
    </BaseCard>

    <!-- TABLE -->
    <BaseCard>
      <div class="flex justify-between items-center mb-5">
        <h2 class="heading-2">Daftar Pesanan</h2>
      </div>

      <BaseTable v-if="filteredRows.length > 0" :columns="columns" :rows="filteredRows">
        <!-- Status Badge -->
        <template #status="{ row }">
          <BaseStatusBadge :status="row.status" />
        </template>

        <!-- Actions -->
        <template #action="{ row }">
          <OrdersRowActions
            :item="row"
            @detail="openModal('detail', row)"
            @edit="openModal('edit', row)"
          />
        </template>
      </BaseTable>

      <!-- Empty State -->
      <BaseEmptyState
      v-else
      title="Tidak ada Pesanan Ditemukan"
      description="Silahkan ubah filter pencarian Anda."
      :icon="Receipt"
      />
    </BaseCard>

    <!-- MODAL ORDERS -->
    <OrdersModal
      v-model="showModal"
      :mode="modalMode"
      :item-data="selectedItem"
      :status-options="statusOptions.filter(s => s !== 'Status')"
      :driver-options="driverOptions"
      @save="handleSaveOrder"
    />

  </section>
</template>

<script setup>
import { ref, computed } from "vue";
import BaseCard from "@/components/base/BaseCard.vue";
import BaseTable from "@/components/base/BaseTable.vue";
import BaseStatusBadge from "@/components/base/BaseStatusBadge.vue";
import OrdersSearch from "@/components/admin/orders/OrdersSearch.vue";
import OrdersFilter from "@/components/admin/orders/OrdersFilter.vue";
import OrdersRowActions from "@/components/admin/orders/OrdersRowActions.vue";
import OrdersModal from "@/components/admin/orders/OrdersModal.vue"; // Modal Baru

// Import Data
import { columns, rows, statusOptions } from "@/data/ordersData";
import BaseEmptyState from "@/components/base/BaseEmptyState.vue";
import { Receipt } from "lucide-vue-next";

// Dummy Driver Options (Nanti bisa diambil dari data driver)
const driverOptions = ["Belum ditetapkan", "Dodii", "Bagas", "Nopal", "Udin", "Supri"];

// State
const search = ref("");
const filters = ref({ status: "", date: "" });
const items = ref([...rows]);

// Modal State
const showModal = ref(false);
const modalMode = ref('detail');
const selectedItem = ref(null);

// Logic Modal
const openModal = (mode, item) => {
  modalMode.value = mode;
  selectedItem.value = item;
  showModal.value = true;
}

const handleSaveOrder = (formData) => {
  console.log("Update Order:", formData);
  // Update data lokal
  const index = items.value.findIndex(i => i.id === formData.id);
  if (index !== -1) {
    items.value[index] = { ...items.value[index], ...formData };
  }
}

const updateFilter = (payload) => {
  filters.value = { ...filters.value, ...payload };
};

const filteredRows = computed(() => {
  return items.value.filter((item) => {
    const q = search.value.toLowerCase();
    const matchSearch = item.id.toLowerCase().includes(q) || item.customer.toLowerCase().includes(q);
    const matchStatus = !filters.value.status || filters.value.status === "Status" || item.status === filters.value.status;
    const matchDate = !filters.value.date || item.date === filters.value.date;
    return matchSearch && matchStatus && matchDate;
  });
});
</script>
