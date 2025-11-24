<template>
  <section class="p-6 space-y-8">
    <!-- HEADER -->
    <header class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
      <div>
        <h1 class="text-3xl font-bold text-gray-800">Manajemen Admin</h1>
        <p class="text-gray-600 text-sm">Hanya SuperAdmin yang dapat mengelola halaman ini.</p>
      </div>
    </header>

    <!-- FILTER & SEARCH BAR -->
    <BaseCard class="p-4">
      <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <!-- Filter Status -->
        <div class="flex items-center gap-4">
          <AdminFilterStatus v-model="filterStatus" />
        </div>

        <!-- Search -->
        <div class="flex items-center">
          <AdminSearch v-model="search" />
        </div>
      </div>
    </BaseCard>

    <!-- TABLE -->
    <BaseCard class="p-4 overflow-hidden">
      <div class="flex justify-between items-center mb-5">
        <h2 class="text-xl font-semibold text-gray-700">Daftar Admin</h2>
        <div class="flex items-center">
          <AdminAddButton @click="openAddAdminModal" />
        </div>
      </div>

      <!-- Tabel Admin -->
      <BaseTable :columns="adminColumns" :rows="filteredUsers">
        <!-- SLOT: Peran (Role) -->
        <template #role="{ row }">
          <AdminStatusBadge :status="row.role" />
        </template>

        <!-- SLOT: Status Akun -->
        <template #status="{ row }">
          <AdminStatusBadge :status="row.status" />
        </template>

        <!-- SLOT: Aksi -->
        <template #action="{ row }">
          <AdminRowActions :user="row" @edit="handleEdit" @toggle-status="handleToggleStatus" />
        </template>
      </BaseTable>
    </BaseCard>
  </section>
</template>

<script setup>
import { ref, computed } from "vue";
import BaseCard from "@/components/base/BaseCard.vue";
import BaseTable from "@/components/base/BaseTable.vue";

// Komponen Manajemen Admin
import AdminStatusBadge from "@/components/admin/adminn/AdminStatusBadge.vue";
import AdminRowActions from "@/components/admin/adminn/AdminRowActions.vue";
import AdminSearch from "@/components/admin/adminn/AdminSearch.vue";
import AdminAddButton from "@/components/admin/adminn/AdminAddButton.vue";

// Komponen Filter Baru (Hanya Status)
import AdminFilterStatus from "@/components/admin/adminn/AdminFilter.vue";

// Impor data
import { adminColumns, adminRows } from "@/data/adminData";

const users = ref([...adminRows]);
const search = ref("");
const filterStatus = ref("Semua"); // Default ke 'Semua'
// const filterRole = ref("Semua"); // Dihapus

// LOGIKA FILTER DAN PENCARIAN
const filteredUsers = computed(() => {
  return users.value.filter((user) => {
    // 1. Filter berdasarkan Status
    const matchStatus = filterStatus.value === "Semua" || user.status === filterStatus.value;

    // 2. Filter berdasarkan Pencarian (ID atau Nama)
    const key = search.value.toLowerCase();
    const matchSearch =
      user.id.toLowerCase().includes(key) || user.name.toLowerCase().includes(key);

    // Filter Peran (Role) dihapus, hanya Status dan Search
    return matchStatus && matchSearch;
  });
});

// HANDLER Aksi
const openAddAdminModal = () => {
  console.log("Aksi Tambah Admin: Membuka modal");
  // Di sini nanti akan memanggil modal untuk menambah admin
};

const handleEdit = (user) => {
  console.log("Aksi Edit Admin: Mengedit pengguna:", user.name);
};

const handleToggleStatus = (user) => {
  // Logic untuk mengubah status secara lokal
  const newStatus = user.status === "Aktif" ? "Nonaktif" : "Aktif";
  // Memastikan reaktivitas dengan mencari indeks dan memperbarui array
  const index = users.value.findIndex((u) => u.id === user.id);
  if (index !== -1) {
    users.value[index].status = newStatus;
  }
  console.log(`Aksi Toggle Status: Status ${user.name} diubah menjadi ${newStatus}`);
};
</script>
