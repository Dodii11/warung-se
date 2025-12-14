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

import { ref, computed, onMounted } from "vue";
import { Motorbike } from "lucide-vue-next";
import { driverColumns } from "@/data/driverData";
import driverApi from "@/api/driver";

// ================= STATE =================
const search = ref("");
const filterStatus = ref("Status");

// ⬅️ tetap pakai driverList seperti sebelumnya
const driverList = ref([]);

const isModalOpen = ref(false);
const modalMode = ref("add");
const selectedDriver = ref(null);

// ================= MAPPER (PENTING) =================
const mapDriverApiToRow = (driver) => ({
  // field lama (WAJIB ADA)
  id: driver.id_driver,
  name: driver.nama_driver,
  phone: driver.no_telp,
  vehicleName: driver.plat_kendaraan,
  vehicleType: driver.tipe_kendaraan === "motor"
    ? "Sepeda Motor"
    : "Truk Pick Up",
  status: driver.status === "aktif" ? "Tersedia" : "Tidak Aktif",
  image: driver.gambar_url,
  lastUpdate: driver.updated_at
    ? new Date(driver.updated_at).toLocaleDateString("id-ID")
    : "-",

  // simpan raw data kalau dibutuhkan
  _raw: driver,
});

// ================= API =================
const fetchDrivers = async () => {
  try {
    const res = await driverApi.getAll();
    driverList.value = res.data.map(mapDriverApiToRow);
  } catch (e) {
    console.error("Gagal ambil driver:", e);
  }
};

onMounted(fetchDrivers);

// ================= MODAL =================
const openModal = (mode, item = null) => {
  modalMode.value = mode;
  selectedDriver.value = item?._raw || null;
  isModalOpen.value = true;
};

const handleSave = async (formData) => {
  try {
    if (modalMode.value === "add") {
      await driverApi.create(formData);
    } else {
      await driverApi.update(selectedDriver.value.id_driver, formData);
    }

    isModalOpen.value = false;
    await fetchDrivers();
  } catch (e) {
    console.error("Gagal simpan driver:", e);
  }
};

const handleDelete = async (item) => {
  if (!confirm(`Hapus driver ${item.name} (${item.id})?`)) return;

  try {
    await driverApi.remove(item.id);
    await fetchDrivers();
  } catch (e) {
    console.error("Gagal hapus driver:", e);
  }
};

// ================= FILTER + SEARCH (TIDAK DIUBAH) =================
const filteredRows = computed(() => {
  return driverList.value
    .filter((d) => {
      if (filterStatus.value !== "Status") {
        return d.status === filterStatus.value;
      }
      return true;
    })
    .filter((d) => {
      const key = search.value.toLowerCase();
      return (
        d.id.toLowerCase().includes(key) ||
        d.name.toLowerCase().includes(key) ||
        d.vehicleName.toLowerCase().includes(key)
      );
    });
});
</script>

