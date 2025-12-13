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
    <UserModal v-model="showUserModal" :itemData="selectedUser" :key="selectedUser?.id_user" />
  </section>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import { userApi } from "@/api/user";

import BaseCard from "@/components/base/BaseCard.vue";
import BaseTable from "@/components/base/BaseTable.vue";
import BaseEmptyState from "@/components/base/BaseEmptyState.vue";

import UserSearch from "@/components/admin/user/UserSearch.vue";
import UserRowActions from "@/components/admin/user/UserRowActions.vue";
import UserFilter from "@/components/admin/user/UserFilter.vue";
import UserModal from "@/components/admin/user/UserModal.vue";

import { Users } from "lucide-vue-next";

const userStore = userApi();

onMounted(() => {
  userStore.fetchUsers();
});

const userColumns = [
  { key: "id_user", label: "ID" },
  { key: "nama_user", label: "Nama" },
  { key: "email_user", label: "Email" },
  { key: "no_telp", label: "No. Telepon" },
];

// MODAL
const showUserModal = ref(false);
const selectedUser = ref(null);

const openUserDetail = (row) => {
  selectedUser.value = {
    id_user: row.id_user,
    nama_user: row.nama_user,
    email_user: row.email_user,
    no_telp: row.no_telp,
    status: row.status,
  };

  showUserModal.value = true;
};

// SEARCH & FILTER
const search = ref("");
const sortOrder = ref("asc");

const filteredRows = computed(() => {
  if (!search.value) return userStore.users;

  const text = search.value.toLowerCase();

  return userStore.users.filter((u) =>
    [u.id_user, u.nama_user, u.email_user].some((f) => String(f).toLowerCase().includes(text))
  );
});

const sortedAndFilteredRows = computed(() => {
  return [...filteredRows.value].sort((a, b) => {
    return sortOrder.value === "asc" ? a.id_user - b.id_user : b.id_user - a.id_user;
  });
});

const onSearch = (value) => {
  search.value = value;
};
</script>
