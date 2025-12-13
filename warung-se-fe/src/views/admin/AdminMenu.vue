<template>
  <section class="p-6 space-y-8">
    <!-- HEADER -->
    <header class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
      <div>
        <h1 class="heading-1">Manajemen Menu</h1>
        <p class="text-gray-600 text-sm">Kelola menu yang tersedia dalam sistem.</p>
      </div>
    </header>

    <!-- FILTERS -->
    <BaseCard class="flex flex-wrap items-center gap-4 justify-between p-4">
      <div class="flex items-center">
        <MenuFilter v-model="selectedCategory" :options="categoryOptions" />
      </div>
      <div class="flex items-center">
        <MenuSearch v-model="search" />
      </div>
    </BaseCard>

    <!-- TABLE -->
    <BaseCard>
      <div class="flex justify-between items-center mb-5">
        <h2 class="heading-2">Daftar Menu</h2>
        <div class="flex items-center">
          <!-- Tombol Tambah hanya muncul untuk Super Admin -->
          <MenuAddButton
            v-if="auth.user?.role === 'admin' || auth.user?.role === 'super admin'"
            @click="openModal('add')"
          />
        </div>
      </div>

      <!-- Skeleton Loader (Opsional, tampilkan saat loading) -->
      <div v-if="loading" class="p-4 space-y-4">
        <div class="animate-pulse flex space-x-4">
          <div class="rounded-full bg-gray-300 h-16 w-16"></div>
          <div class="flex-1 space-y-2">
            <div class="h-4 bg-gray-300 rounded w-3/4"></div>
            <div class="h-4 bg-gray-300 rounded"></div>
            <div class="h-4 bg-gray-300 rounded w-5/6"></div>
          </div>
        </div>
        <!-- Ulangi skeleton baris sesuai kebutuhan -->
      </div>

      <!-- BaseTable -->
      <BaseTable v-else-if="filtered.length > 0" :columns="columns" :rows="filtered">
        <!-- GAMBAR -->
        <template #image="{ row }">
          <!-- Gunakan accessor gambar_url dari model -->
          <img
            :src="row.gambar_url || 'https://via.placeholder.com/150x150?text=No+Image'"
            class="w-16 h-16 rounded-lg object-cover transition-opacity border border-gray-100"
            alt="menu-img"
          />
        </template>

        <!-- NAMA -->
        <template #name="{ row }">
          <div class="w-full">
            <p class="font-semibold transition-colors whitespace-normal max-w-40">
              {{ row.menu }}
            </p>
          </div>
        </template>

        <!-- DESKRIPSI -->
        <template #description="{ row }">
          <div class="max-w-60">
            <p class="text-gray-500 text-sm whitespace-normal truncate">
              {{ row.deskripsi || "-" }}
            </p>
          </div>
        </template>

        <!-- HARGA -->
        <template #price="{ row }"> Rp {{ Number(row.harga).toLocaleString("id-ID") }} </template>

        <!-- KATEGORI -->
        <template #category="{ row }">
          <span
            class="px-2 py-1 rounded-full text-xs font-medium bg-red-50 text-primary border border-red-100 inline-flex items-center gap-1"
          >
            <Utensils class="w-3 h-3" />
            {{ row.kategori }}
          </span>
        </template>

        <!-- STOK -->
        <template #stock="{ row }">
          <p class="font-bold" :class="row.stok > 0 ? 'text-gray-900' : 'text-red-600'">
            {{ row.stok }} Porsi
          </p>
        </template>

        <!-- STATUS -->
        <template #status="{ row }">
          <span
            class="px-2 py-1 rounded-full text-xs font-medium"
            :class="
              row.stok > 0 && row.status.toLowerCase() === 'tersedia'
                ? 'bg-green-100 text-green-700'
                : 'bg-red-100 text-red-700'
            "
          >
            {{
              row.stok > 0 && row.status.toLowerCase() === "tersedia"
                ? "Tersedia"
                : "Tidak Tersedia"
            }}
          </span>
        </template>

        <!-- ACTIONS -->
        <!-- Event dari MenuRowActions ditangkap di sini -->
        <template #action="{ row }">
          <MenuRowActions
            :item="row"
            @edit="openModal('edit', row)"
            @detail="openModal('detail', row)"
            @delete="handleDelete(row)"
          />
        </template>
      </BaseTable>

      <BaseEmptyState
        v-else-if="!loading"
        title="Belum ada Menu"
        description="Silahkan ubah filter pencarian Anda atau tambahkan Menu baru untuk memulai."
        :icon="UtensilsCrossed"
      >
        <div class="flex items-center justify-center">
          <MenuAddButton
            v-if="auth.user?.role === 'admin' || auth.user?.role === 'super admin'"
            @click="openModal('add')"
          />
        </div>
      </BaseEmptyState>

      <!-- Error State (Opsional) -->
      <div v-if="error" class="p-4 text-center text-red-500">
        <p>{{ error }}</p>
        <BaseButton variant="outline-gray" @click="fetchMenus" class="mt-2"> Coba Lagi </BaseButton>
      </div>
    </BaseCard>

    <!-- MODAL MENU TUNGGAL -->
    <MenuModal
      v-model="showModal"
      :mode="modalMode"
      :item-data="selectedItem"
      :category-options="categoryOptions.filter((c) => c !== 'Kategori')"
      @save="handleSaveMenu"
      :loading="isSaving"
    />
  </section>
</template>

<script setup>
import { ref, computed, onMounted, toRaw } from "vue";
import { useAuth } from "@/stores/auth"; // Import store auth untuk cek role

import BaseCard from "@/components/base/BaseCard.vue";
import BaseTable from "@/components/base/BaseTable.vue";
import BaseEmptyState from "@/components/base/BaseEmptyState.vue";
import BaseButton from "@/components/base/BaseButton.vue"; // Untuk tombol coba lagi

import MenuFilter from "@/components/admin/menu/MenuFilter.vue";
import MenuSearch from "@/components/admin/menu/MenuSearch.vue";
import MenuRowActions from "@/components/admin/menu/MenuRowActions.vue";
import MenuAddButton from "@/components/admin/menu/MenuAddButton.vue";
import MenuModal from "@/components/admin/menu/MenuModal.vue";

import { Utensils, UtensilsCrossed } from "lucide-vue-next";
import { menuApi } from "@/api/menu"; // Import API (Asumsi menuApi memiliki method create, update, delete, getAll)

const auth = useAuth(); // Gunakan store auth

// State
const search = ref("");
const selectedCategory = ref("Kategori");
const items = ref([]); // Ganti dari dummy
const loading = ref(false); // Tambah state loading
const error = ref(null); // Tambah state error

// State Modal
const showModal = ref(false);
const modalMode = ref("add");
const selectedItem = ref(null);
const isSaving = ref(false); // Tambah state saving untuk modal

// Definisikan opsi kategori sesuai BE
const categoryOptions = ref(["Kategori", "makanan", "minuman", "paket"]);

// --- Fetch Data dari API ---
const fetchMenus = async () => {
  loading.value = true;
  error.value = null;
  try {
    const res = await menuApi.getAll();
    items.value = res.data.map((item) => ({
      ...item,
      // Pastikan status di-lowercase agar konsisten saat pengecekan di computed
      status: item.status ? item.status.toLowerCase() : "tersedia",
      stok: Number(item.stok), // Pastikan stok adalah angka
    }));
  } catch (err) {
    console.error("Gagal mengambil data menu:", err);
    error.value = err.response?.data?.message || "Gagal mengambil data menu.";
  } finally {
    loading.value = false;
  }
};

onMounted(() => {
  fetchMenus();
});

// --- Logic Modal ---
const openModal = (mode, item = null) => {
  modalMode.value = mode;

  selectedItem.value = item ? JSON.parse(JSON.stringify(toRaw(item))) : null;

  showModal.value = true;
};

// --- API Logic: Save (Create/Update) ---
const handleSaveMenu = async (formData) => {
  isSaving.value = true;
  try {
    const payload = new FormData();

    // Sesuaikan key dengan field BE
    payload.append("menu", formData.name);
    payload.append("deskripsi", formData.description);
    payload.append("harga", formData.price);
    payload.append("kategori", formData.category);
    payload.append("stok", formData.stock);

    // Status dikirim lowercase sesuai format BE
    payload.append("status", formData.status.toLowerCase());

    // Hanya tambahkan gambar jika ada file yang dipilih
    if (formData.imageFile) {
      payload.append("gambar_menu", formData.imageFile);
    }

    // Jika tidak ada file, tapi di mode edit dan pengguna ingin menghapus gambar
    else if (
      modalMode.value === "edit" &&
      formData.imagePreview === "https://via.placeholder.com/150x150?text=No+Image"
    ) {
      // Kirim null sebagai instruksi hapus gambar lama di BE
      payload.append("gambar_menu", "");
    }

    console.log(
      "AdminMenu: Processing save. Mode:",
      modalMode.value,
      "FormData ID:",
      formData.id,
      "Has ID?",
      !!formData.id
    );

    if (modalMode.value === "edit" && formData.id) {
      // PENTING: Untuk PUT/PATCH request dengan FormData (karena ada file),
      // kita harus menyertakan field _method: 'PUT'
      payload.append("_method", "PUT");

      await menuApi.update(formData.id, payload);
      await fetchMenus(); // Refresh data setelah update
    } else {
      // Logic Create (POST)
      await menuApi.create(payload);
      await fetchMenus(); // Refresh data setelah create
    }

    showModal.value = false;
  } catch (err) {
    console.error("Gagal menyimpan menu:", err);
    // Tampilkan pesan error dari BE
    const errorMessage = err.response?.data?.message || "Gagal menyimpan menu.";
    alert(errorMessage);
  } finally {
    isSaving.value = false;
  }
};

// --- API Logic: Delete ---
const handleDelete = async (item) => {
  // Ganti alert bawaan dengan konfirmasi kustom jika ada di proyek nyata
  if (!confirm(`Hapus menu ${item.menu}?`)) return;

  try {
    await menuApi.delete(item.id_menu);
    // Hapus item dari list lokal
    items.value = items.value.filter((i) => i.id_menu !== item.id_menu);
  } catch (err) {
    console.error("Gagal menghapus menu:", err);
    alert(err.response?.data?.message || "Gagal menghapus menu.");
  }
};

// Table Config (TAMBAH KOLOM STATUS dan sesuaikan key dengan field BE)
const columns = [
  { label: "Gambar", key: "image" },
  { label: "Nama", key: "name" }, // Mapping ke field BE: `menu`
  { label: "Deskripsi", key: "description" }, // Mapping ke field BE: `deskripsi`
  { label: "Harga", key: "price" }, // Mapping ke field BE: `harga`
  { label: "Kategori", key: "category" }, // Mapping ke field BE: `kategori`
  { label: "Stok", key: "stock" }, // Mapping ke field BE: `stok`
  { label: "Status", key: "status" }, // <-- KOLOM BARU
];

// Gunakan field BE untuk filtering
const filtered = computed(() => {
  return items.value.filter((item) => {
    const matchCategory =
      selectedCategory.value === "Kategori" || item.kategori === selectedCategory.value;

    const matchSearch = item.menu.toLowerCase().includes(search.value.toLowerCase()); // Gunakan field BE

    return matchCategory && matchSearch;
  });
});
</script>
