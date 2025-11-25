<template>
  <section class="p-6 space-y-8">
    <!-- HEADER -->
    <header class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
      <div>
        <h1 class="heading-1">Manajemen Pengguna</h1>
        <p class="text-gray-600 text-sm">Lihat dan kelola akun Pengguna disini.</p>
      </div>
    </header>

    <!-- FILTER BAR -->
    <BaseCard padding="p-4">
      <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <!-- FILTER (kiri) -->
        <div class="flex items-center gap-3 flex-wrap">
          <UserFilter v-model="sortOrder" />
        </div>

        <!-- SEARCH (kanan) -->
        <div class="flex justify-end w-full md:w-auto">
          <UserSearch @update:search="onSearch" class="w-full md:w-64" />
        </div>
      </div>
    </BaseCard>

    <!-- TABLE -->
    <BaseCard>
      <div class="flex justify-between items-center mb-5">
        <h2 class="heading-2">Daftar Pengguna</h2>
      </div>
      <BaseTable :columns="userColumns" :rows="sortedAndFilteredRows">
        <!-- ACTION -->
        <template #action="{ row }">
          <UserRowActions :row="row" />
        </template>
      </BaseTable>
    </BaseCard>
  </section>
</template>

<script setup>
import { ref, computed } from "vue";

import BaseCard from "@/components/base/BaseCard.vue";
import BaseTable from "@/components/base/BaseTable.vue";

import UserSearch from "@/components/admin/user/UserSearch.vue";
import UserRowActions from "@/components/admin/user/UserRowActions.vue";
import UserFilter from "@/components/admin/user/UserFilter.vue";

import { userColumns, userRows } from "@/data/userData";

const search = ref("");
const sortOrder = ref("asc");

// FILTER + SEARCH
const filteredRows = computed(() => {
  if (!search.value) return userRows;

  const key = search.value.toLowerCase();

  return userRows.filter(
    (u) =>
      u.id.toLowerCase().includes(key) ||
      u.name.toLowerCase().includes(key) ||
      u.email.toLowerCase().includes(key)
  );
});

const sortedAndFilteredRows = computed(() => {
  return [...filteredRows.value].sort((a, b) => {
    const aId = Number(a.id.replace(/\D/g, ""));
    const bId = Number(b.id.replace(/\D/g, ""));

    return sortOrder.value === "asc" ? aId - bId : bId - aId;
  });
});

const onSearch = (value) => {
  search.value = value;
};
</script>
