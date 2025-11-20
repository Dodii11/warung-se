<!-- src/views/admin/AdminDriver.vue -->
<template>
  <section class="p-6 space-y-8">
    <!-- HEADER -->
    <header class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
      <div>
        <h1 class="heading-1">Pengantaran Driver</h1>
        <p class="text-gray-600 text-sm">Kelola driver pada halaman ini.</p>
      </div>

      <DriverAddButton />
    </header>

    <!-- FILTER BAR -->
    <BaseCard padding="p-4">
      <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex items-center gap-3 flex-wrap">
          <DriverFilter v-model="filterStatus" />
        </div>

        <div class="flex justify-end w-full md:w-auto">
          <DriverSearch @update:search="onSearch" class="w-full md:w-64" />
        </div>
      </div>
    </BaseCard>

    <!-- TABLE -->
    <BaseCard>
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
    .filter(d => {
      if (filterStatus.value !== "Status") {
        return d.status === filterStatus.value;
      }
      return true;
    })
    .filter(d => {
      const key = search.value.toLowerCase();
      return (
        d.id.toLowerCase().includes(key) ||
        d.name.toLowerCase().includes(key)
      );
    });
});

const onSearch = (v) => {
  search.value = v;
};

</script>
