<template>
  <section class="p-6 space-y-8">
    <!-- HEADER -->
    <header class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
      <div>
        <h1 class="heading-1">Manajemen Pesanan</h1>
        <p class="text-gray-600 text-sm">Kelola pesanan terbaru, status, dan detail pelanggan</p>
      </div>
    </header>

    <!-- FILTERS -->
    <BaseCard padding="p-4">
      <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <!-- FILTER (kiri) -->
        <div class="flex items-center gap-3 flex-wrap">
          <OrdersFilter @update:filter="updateFilter" />
        </div>

        <!-- SEARCH (kanan) -->
        <div class="flex justify-end w-full md:w-auto">
          <OrdersSearch @update:search="search = $event" class="w-full md:w-64" />
        </div>
      </div>
    </BaseCard>

    <!-- TABLE -->
    <BaseCard padding="md">
      <div class="flex justify-between items-center mb-5">
        <h2 class="heading-2">Daftar Pesanan</h2>
      </div>

      <BaseTable :columns="columns" :rows="filteredRows">
        <!-- Status dengan badge -->
        <template #status="{ row }">
          <BaseStatusBadge :status="row.status" />
        </template>

        <!-- Custom Action -->
        <template #action="{ row }">
          <OrdersRowActions :item="row" />
        </template>
      </BaseTable>

      <!-- No Data -->
      <div v-if="filteredRows.length === 0" class="text-center py-10 text-gray-500">
        Tidak ada pesanan ditemukan.
      </div>
    </BaseCard>
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

import { columns, rows } from "@/data/ordersData";

// Local filters
const search = ref("");
const filters = ref({ status: "", date: "" });

const updateFilter = (payload) => {
  filters.value = { ...filters.value, ...payload };
};

const filteredRows = computed(() => {
  return rows.filter((item) => {
    const q = search.value.toLowerCase();

    const matchSearch =
      item.id.toLowerCase().includes(q) || item.customer.toLowerCase().includes(q);

    const matchStatus =
      !filters.value.status ||
      filters.value.status === "Status" ||
      item.status === filters.value.status;

    const matchDate = !filters.value.date || item.date === filters.value.date;

    return matchSearch && matchStatus && matchDate;
  });
});
</script>
