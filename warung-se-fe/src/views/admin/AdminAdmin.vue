<template>
  <section class="p-6 space-y-8">
    <!-- HEADER -->
    <header class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
      <div>
        <h1 class="heading-1">Manajemen Admin</h1>
        <p class="text-gray-600 text-sm">Kelola akun Admin pada halaman ini (SuperAdmin Only).</p>
      </div>
    </header>

    <!-- FILTER & SEARCH BAR -->
    <BaseCard class="p-4">
      <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <!-- Filter Status -->
        <div class="flex items-center gap-4">
          <!-- Asumsi AdminFilterStatus ada, jika tidak, ganti dengan BaseDropdown -->
          <AdminFilterStatus v-model="filterStatus" />
        </div>

        <!-- Search -->
        <div class="flex items-center">
          <!-- Asumsi AdminSearch ada, jika tidak, ganti dengan BaseInput -->
          <AdminSearch v-model="search" />
        </div>
      </div>
    </BaseCard>

    <!-- TABLE -->
    <BaseCard class="p-4 overflow-hidden">
      <div class="flex justify-between items-center mb-5">
        <h2 class="text-xl font-semibold text-gray-700">Daftar Admin (Total: {{ users.length }})</h2>
        <div class="flex items-center">
          <!-- Mengganti AdminAddButton dengan BaseButton dan memanggil openModal -->
          <BaseButton
            variant="primary"
            @click="openModal('add')"
            class="flex items-center gap-2"
          >
             <PlusIcon class="w-4 h-4" /> Tambah Admin
          </BaseButton>
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
          <!-- Melewatkan item data ke row actions -->
          <AdminRowActions :item="row" @edit="openModal('edit', row)" @delete="handleDelete" />
        </template>
      </BaseTable>
    </BaseCard>

    <!-- Modal Admin (Untuk Add, Edit, Detail) -->
    <AdminModal
        v-model="isModalOpen"
        :mode="modalMode"
        :item-data="selectedUser"
        @save="handleSave"
    />

  </section>
</template>

<script setup>
import { ref, computed } from "vue";
import BaseCard from "@/components/base/BaseCard.vue";
import BaseTable from "@/components/base/BaseTable.vue";
import BaseButton from "@/components/base/BaseButton.vue";
import { PlusIcon } from "lucide-vue-next";

// Komponen Manajemen Admin
import AdminStatusBadge from "@/components/admin/adminn/AdminStatusBadge.vue";
import AdminRowActions from "@/components/admin/adminn/AdminRowActions.vue";
import AdminModal from "@/components/admin/adminn/AdminModal.vue";

// Asumsi komponen ini ada (tidak perlu dibuat karena fokusnya di modal)
import AdminSearch from "@/components/admin/adminn/AdminSearch.vue";
import AdminFilterStatus from "@/components/admin/adminn/AdminFilter.vue";

// Impor data
import { adminColumns, adminRows } from "@/data/adminData";

// --- STATE MANAGEMENT ---
const users = ref([...adminRows]);
const search = ref("");
const filterStatus = ref("Semua");

const isModalOpen = ref(false);
const modalMode = ref('add');
const selectedUser = ref(null);

// --- MODAL HANDLERS ---
const openModal = (mode, item = null) => {
    modalMode.value = mode;
    selectedUser.value = item;
    isModalOpen.value = true;
};

// --- CRUD DUMMY LOGIC ---
const handleSave = (formData) => {
    const { id, name, email, role, status, profileImage } = formData;

    // Cari Index
    const index = users.value.findIndex(u => u.id === id);

    if (index !== -1) {
        // Logika EDIT
        Object.assign(users.value[index], {
            name, email, role, status, profileImage
        });
        console.log(`[CRUD DUMMY] Admin ${id} diperbarui.`);
    } else {
        // Logika ADD
        users.value.push({
            id, name, email, role, status, profileImage
        });
        console.log(`[CRUD DUMMY] Admin ${id} ditambahkan.`);
    }
};

const handleDelete = (adminId) => {
    // Logika HAPUS
    const initialLength = users.value.length;
    users.value = users.value.filter(u => u.id !== adminId);
    if (users.value.length < initialLength) {
        console.log(`[CRUD DUMMY] Admin ID: ${adminId} berhasil dihapus.`);
    } else {
         console.error(`[CRUD DUMMY] Admin ID: ${adminId} tidak ditemukan.`);
    }
};

// --- FILTER DAN PENCARIAN ---
const filteredUsers = computed(() => {
  return users.value.filter((user) => {
    // 1. Filter berdasarkan Status
    const matchStatus = filterStatus.value === "Semua" || user.status === filterStatus.value;

    // 2. Filter berdasarkan Pencarian (ID atau Nama)
    const key = search.value.toLowerCase();
    const matchSearch =
      user.id.toLowerCase().includes(key) || user.name.toLowerCase().includes(key) || user.email.toLowerCase().includes(key);

    return matchStatus && matchSearch;
  });
});
</script>
