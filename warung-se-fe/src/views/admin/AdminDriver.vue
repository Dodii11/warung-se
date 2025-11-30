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
          <DriverAddButton @click="openModal('add')" />
        </div>
      </div>
      <BaseTable v-if="filteredRows.length > 0" :columns="driverColumns" :rows="filteredRows">
        <!-- STATUS -->
        <template #status="{ row }">
          <DriverStatusBadge :status="row.status" />
        </template>

        <!-- ACTION -->
        <template #action="{ row }">
          <DriverRowActions
            :item="row"
            @edit="openModal('edit', row)"
            @detail="openModal('detail', row)"
            @delete="handleDelete(row)"
          />
        </template>
      </BaseTable>

      <!-- Empty State ketika filteredRows.length === 0 -->
      <BaseEmptyState
        v-else
        title="Tidak ada Driver Ditemukan"
        description="Silahkan ubah filter pencarian Anda atau tambahkan driver baru untuk memulai."
        :icon="Motorbike"
      >
        <!-- Tombol Tambah Driver di dalam slot -->
        <div class="flex items-center justify-center">
          <DriverAddButton @click="openModal('add')" />
        </div>
      </BaseEmptyState>
    </BaseCard>

    <!-- Modal Tambah Driver (Terpisah dari Row Actions) -->
    <DriverModal
      v-model="isModalOpen"
      :mode="modalMode"
      :item-data="selectedDriver"
      @save="handleSave"
    />

    <!-- Catatan: DriverFilter dan DriverSearch tidak disertakan karena tidak berubah. -->
  </section>
</template>

<script setup>
import BaseCard from "@/components/base/BaseCard.vue";
import BaseTable from "@/components/base/BaseTable.vue";
import BaseEmptyState from "@/components/base/BaseEmptyState.vue";
import DriverStatusBadge from "@/components/admin/driver/DriverStatusBadge.vue";
import DriverRowActions from "@/components/admin/driver/DriverRowActions.vue";

import DriverFilter from "@/components/admin/driver/DriverFilter.vue";
import DriverSearch from "@/components/admin/driver/DriverSearch.vue";
import DriverModal from "@/components/admin/driver/DriverModal.vue";
import DriverAddButton from "@/components/admin/driver/DriverAddButton.vue";

import { ref, computed } from "vue";
import { Motorbike } from "lucide-vue-next";
import { driverColumns, driverRows } from "@/data/driverData";

// --- STATE MANAGEMENT ---
const search = ref("");
const filterStatus = ref("Status");

// Gunakan state reaktif untuk daftar driver agar bisa di-edit/tambah/hapus
const driverList = ref(driverRows);

const isModalOpen = ref(false);
const modalMode = ref("add");
const selectedDriver = ref(null); // Driver yang dipilih untuk edit/detail

// --- MODAL HANDLERS ---
const openModal = (mode, item = null) => {
  modalMode.value = mode;
  selectedDriver.value = item;
  isModalOpen.value = true;
};

// --- CRUD DUMMY LOGIC ---
const handleSave = (formData) => {
  const { id, name, phone, vehicleName, vehicleType, status, image } = formData;

  // Temukan Index
  const index = driverList.value.findIndex((d) => d.id === id);

  if (index !== -1) {
    // Logika EDIT
    Object.assign(driverList.value[index], {
      name,
      phone,
      vehicleName,
      vehicleType,
      status,
      image,
      lastUpdate: new Date().toLocaleDateString("id-ID"),
    });
    console.log(`[CRUD DUMMY] Driver ${id} diperbarui.`);
  } else {
    // Logika ADD (asumsi ID sudah digenerate di DriverModal jika mode add)
    driverList.value.push({
      id,
      name,
      phone,
      vehicleName,
      vehicleType,
      status,
      image,
      lastUpdate: new Date().toLocaleDateString("id-ID"),
    });
    console.log(`[CRUD DUMMY] Driver ${id} ditambahkan.`);
  }
};

// --- DELETE LOGIC (Menggunakan window.confirm) ---
const handleDelete = (item) => {
  if (confirm(`Hapus driver ${item.name} (${item.id})?`)) {
    driverList.value = driverList.value.filter((d) => d.id !== item.id);
    console.log(`[CRUD DUMMY] Driver ID: ${item.id} berhasil dihapus.`);
  }
};

// --- FILTER + SEARCH LOGIC ---
const filteredRows = computed(() => {
  return driverList.value
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
      // Melakukan pencarian berdasarkan ID, Nama driver, atau Kendaraan
      return (
        d.id.toLowerCase().includes(key) ||
        d.name.toLowerCase().includes(key) ||
        d.vehicleName.toLowerCase().includes(key)
      );
    });
});
</script>
