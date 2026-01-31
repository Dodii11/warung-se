<template>
  <section class="p-6 space-y-8">
    <!-- HEADER -->
    <header class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
      <div>
        <h1 class="heading-1">Manajemen Admin</h1>
        <p class="text-gray-600 text-sm">Kelola akun Admin pada halaman ini.</p>
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
        <h2 class="heading-2">Daftar Admin</h2>
        <div class="flex items-center">
          <AdminAddButton @click="openModal('add')" />
        </div>
      </div>

      <!-- Tabel Admin -->
      <BaseTable v-if="filteredUsers.length > 0" :columns="adminColumns" :rows="filteredUsers">
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
          <!-- MEMPERBAIKI: Menambahkan listener @detail yang hilang -->
          <AdminRowActions
            :item="row"
            @detail="openModal('detail', row)"
            @edit="openModal('edit', row)"
            @delete="handleDelete(row)"
          />
        </template>
      </BaseTable>
      <BaseEmptyState
        v-else
        title="Tidak ada Admin Ditemukan"
        description="Silahkan ubah filter pencarian Anda atau tambahkan Admin baru untuk memulai."
        :icon="UserRoundCog"
      >
        <div class="flex items-center justify-center">
          <AdminAddButton @click="openModal('add')" />
        </div>
      </BaseEmptyState>
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
import { ref, computed, onMounted } from "vue";
import BaseCard from "@/components/base/BaseCard.vue";
import BaseTable from "@/components/base/BaseTable.vue";
import BaseEmptyState from "@/components/base/BaseEmptyState.vue";
import { UserRoundCog } from "lucide-vue-next";

// UI Components
import AdminStatusBadge from "@/components/admin/adminn/AdminStatusBadge.vue";
import AdminRowActions from "@/components/admin/adminn/AdminRowActions.vue";
import AdminModal from "@/components/admin/adminn/AdminModal.vue";
import AdminAddButton from "@/components/admin/adminn/AdminAddButton.vue";
import AdminSearch from "@/components/admin/adminn/AdminSearch.vue";
import AdminFilterStatus from "@/components/admin/adminn/AdminFilter.vue";

// API STORE
import { adminApi } from "@/api/admin";

// TABLE COLUMNS (tetap pakai yang lama)
import { adminColumns } from "@/data/adminData";

// STATE
const adminStore = adminApi();

const search = ref("");
const filterStatus = ref("Semua");

const isModalOpen = ref(false);
const modalMode = ref("add");
const selectedUser = ref(null);

// FETCH
onMounted(() => {
  adminStore.fetchAdmins();
});

// MAPPING API → UI
const admins = computed(() =>
  adminStore.admins.map((a) => ({
    id: a.id_user,
    name: a.nama_user,
    email: a.email_user,
    role: "Admin",
    status: a.status === "aktif" ? "Aktif" : "Nonaktif",
  }))
);

// FILTER
const filteredUsers = computed(() => {
  return admins.value.filter((u) => {
    const matchStatus = filterStatus.value === "Semua" || u.status === filterStatus.value;

    const key = search.value.toLowerCase();
    const matchSearch =
      u.id.toString().includes(key) ||
      u.name.toLowerCase().includes(key) ||
      u.email.toLowerCase().includes(key);

    return matchStatus && matchSearch;
  });
});

// MODAL
const openModal = (mode, item = null) => {
  modalMode.value = mode;
  selectedUser.value = item ? { ...item } : null;
  isModalOpen.value = true;
};

// SAVE
const handleSave = async (form) => {
  if (modalMode.value === "add") {
    await adminStore.createAdmin({
      nama_user: form.name,
      email_user: form.email,
      password: form.password,
    });
  }

  if (modalMode.value === "edit") {
    await adminStore.updateAdmin(form.id, {
      nama_user: form.name,
      email_user: form.email,
      status: form.status === "Aktif" ? "aktif" : "tidak aktif",
      password: form.password || null,
    });
  }

  isModalOpen.value = false;
};

// DELETE
const handleDelete = async (item) => {
  if (!confirm(`Hapus admin ${item.name}?`)) return;
  await adminStore.deleteAdmin(item.id);
};
</script>
