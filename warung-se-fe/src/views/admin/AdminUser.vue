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

      <BaseTable
        v-if="sortedAndFilteredRows.length > 0"
        :columns="userColumns"
        :rows="sortedAndFilteredRows"
      >
        <template #action="{ row }">
          <UserRowActions :item="row" @detail="openUserDetail" />
        </template>
      </BaseTable>
      <BaseEmptyState
        v-else
        title="Tidak ada Pengguna Ditemukan"
        description="Silahkan ubah filter pencarian Anda."
        :icon="Users"
      />
    </BaseCard>

    <!-- USER DETAIL MODAL -->
    <UserModal v-model="showUserModal" :itemData="selectedUser" :key="selectedUser?.id" />
  </section>
</template>

<script setup>
import { ref, computed } from "vue";

import BaseCard from "@/components/base/BaseCard.vue";
import BaseTable from "@/components/base/BaseTable.vue";
import BaseEmptyState from "@/components/base/BaseEmptyState.vue";

import UserSearch from "@/components/admin/user/UserSearch.vue";
import UserRowActions from "@/components/admin/user/UserRowActions.vue";
import UserFilter from "@/components/admin/user/UserFilter.vue";
import UserModal from "@/components/admin/user/UserModal.vue";

import { userColumns, userRows } from "@/data/userData";
import { Users } from "lucide-vue-next";

// MODAL STATE
const showUserModal = ref(false);
const selectedUser = ref(null);

// Open User Detail Modal
const openUserDetail = (row) => {
  selectedUser.value = { ...row };
  showUserModal.value = true;
};

// SEARCH + FILTER
const search = ref("");
const sortOrder = ref("asc");

// Filter by search
const filteredRows = computed(() => {
  if (!search.value) return userRows;

  const text = search.value.toLowerCase();

  return userRows.filter((u) =>
    [u.id, u.name, u.email].some((f) => String(f).toLowerCase().includes(text))
  );
});

// Final sorted + filtered rows
const sortedAndFilteredRows = computed(() => {
  return [...filteredRows.value].sort((a, b) => {
    const aNum = Number(a.id.replace(/\D/g, ""));
    const bNum = Number(b.id.replace(/\D/g, ""));
    return sortOrder.value === "asc" ? aNum - bNum : bNum - aNum;
  });
});

// Search Handler
const onSearch = (value) => {
  search.value = value;
};
</script>
