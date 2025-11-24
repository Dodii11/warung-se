<template>
  <section class="p-6 space-y-8">
    <!-- HEADER -->
    <header class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
      <div>
        <h1 class="heading-1">Manajemen Driver</h1>
        <p class="text-gray-600 text-sm">Kelola driver pada halaman ini.</p>
      </div>
    </header>

    <!-- FILTER BAR -->
    <BaseCard class="flex flex-wrap items-center gap-4 justify-between">
      <div class="flex items-center">
        <DriverFilter v-model="filterStatus" />
      </div>

      <div class="flex items-center">
        <DriverSearch v-model="search" />
      </div>
    </BaseCard>

    <!-- TABLE -->
    <BaseCard>
      <div class="flex justify-between items-center mb-5">
        <h2 class="heading-2">Daftar Driver</h2>
        <div class="flex items-center">
          <DriverAddButton />
        </div>
      </div>
      <BaseTable :columns="driverColumns" :rows="filteredRows">
        <!-- STATUS -->
        <template #status="{ row }">
          <DriverStatusBadge :status="row.status" />
        </template>

        <!-- ACTION -->
        <template #action="{ row }">
          <DriverRowActions :row="row" />
        </template>
      </BaseTable>
    </BaseCard>
  </section>
</template>

<script setup>
import BaseCard from "@/components/base/BaseCard.vue";
import BaseTable from "@/components/base/BaseTable.vue";

import DriverStatusBadge from "@/components/admin/driver/DriverStatusBadge.vue";
import DriverRowActions from "@/components/admin/driver/DriverRowActions.vue";
import DriverAddButton from "@/components/admin/driver/DriverAddButton.vue";
import DriverFilter from "@/components/admin/driver/DriverFilter.vue";
import DriverSearch from "@/components/admin/driver/DriverSearch.vue";

import { ref, computed } from "vue";
import { driverColumns, driverRows } from "@/data/driverData";

const search = ref("");
const filterStatus = ref("Status");

// FILTER + SEARCH
const filteredRows = computed(() => {
  return driverRows
    .filter((d) => {
      // Filter Status
      if (filterStatus.value !== "Status") {
        return d.status === filterStatus.value;
      }
      return true;
    })
    .filter((d) => {
      // Filter Search
      const key = search.value.toLowerCase();
      // Melakukan pencarian berdasarkan ID atau Nama driver
      return d.id.toLowerCase().includes(key) || d.name.toLowerCase().includes(key);
    });
});
</script>
