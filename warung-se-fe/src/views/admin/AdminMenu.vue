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
          <MenuAddButton @click="openModal('add')" />
        </div>
      </div>

      <!-- BaseTable -->
      <BaseTable v-if="filtered.length > 0" :columns="columns" :rows="filtered">
        <!-- GAMBAR -->
        <template #image="{ row }">
          <img
            :src="row.image"
            class="w-16 h-16 rounded-lg object-cover transition-opacity border border-gray-100"
            alt="menu-img"
          />
        </template>

        <!-- NAMA -->
        <template #name="{ row }">
          <div class="w-full">
            <p class="font-semibold transition-colors whitespace-normal max-w-40">
              {{ row.name }}
            </p>
          </div>
        </template>

        <!-- DESKRIPSI -->
        <template #description="{ row }">
          <div class="max-w-60">
            <p class="text-gray-500 text-sm whitespace-normal">
              {{ row.description }}
            </p>
          </div>
        </template>

        <!-- HARGA -->
        <template #price="{ row }"> Rp {{ row.price.toLocaleString("id-ID") }} </template>

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
        v-else
        title="Belum ada Menu"
        description="Silahkan ubah filter pencarian Anda atau tambahkan Menu baru untuk memulai."
        :icon="UtensilsCrossed"
        >
      <div class="flex items-center justify-center">
        <MenuAddButton @click="openModal('add')" />
      </div>
      </BaseEmptyState>
    </BaseCard>

    <!-- MODAL MENU TUNGGAL -->
    <MenuModal
      v-model="showModal"
      :mode="modalMode"
      :item-data="selectedItem"
      :category-options="categoryOptions.filter((c) => c !== 'Kategori')"
      @save="handleSaveMenu"
    />
  </section>
</template>

<script setup>
import { ref, computed } from "vue";

import BaseCard from "@/components/base/BaseCard.vue";
import BaseTable from "@/components/base/BaseTable.vue";
import BaseEmptyState from "@/components/base/BaseEmptyState.vue";

import MenuFilter from "@/components/admin/menu/MenuFilter.vue";
import MenuSearch from "@/components/admin/menu/MenuSearch.vue";
import MenuRowActions from "@/components/admin/menu/MenuRowActions.vue";
import MenuAddButton from "@/components/admin/menu/MenuAddButton.vue";
import MenuModal from "@/components/admin/menu/MenuModal.vue";

import { categoryOptions, menuItems } from "@/data/menuData";
import { UtensilsCrossed } from "lucide-vue-next";

// State
const search = ref("");
const selectedCategory = ref("Kategori");
const items = ref([...menuItems]);

// State Modal
const showModal = ref(false);
const modalMode = ref("add");
const selectedItem = ref(null);

// --- Logic Modal ---
const openModal = (mode, item = null) => {
  modalMode.value = mode;
  selectedItem.value = item;
  showModal.value = true;
};

const handleSaveMenu = (formData) => {
  if (modalMode.value === "edit" && selectedItem.value) {
    // UPDATE LOGIC (Dummy)
    const index = items.value.findIndex((i) => i.id === selectedItem.value.id);
    if (index !== -1) {
      items.value[index] = {
        ...items.value[index],
        ...formData,
        image: formData.imagePreview,
      };
    }
  } else {
    // CREATE LOGIC (Dummy)
    items.value.unshift({
      ...formData,
      id: Date.now(),
      image: formData.imagePreview || "https://via.placeholder.com/150",
      status: "Tersedia",
    });
  }
};

const handleDelete = (item) => {
  if (confirm(`Hapus menu ${item.name}?`)) {
    items.value = items.value.filter((i) => i.id !== item.id);
  }
};

// Table Config
const columns = [
  { label: "Gambar", key: "image" },
  { label: "Nama", key: "name" },
  { label: "Deskripsi", key: "description" },
  { label: "Harga", key: "price" },
  { label: "Kategori", key: "category" },
  { label: "Stok", key: "stock" },
];

const filtered = computed(() => {
  return items.value.filter((item) => {
    const matchCategory =
      selectedCategory.value === "Kategori" || item.category === selectedCategory.value;

    const matchSearch = item.name.toLowerCase().includes(search.value.toLowerCase());

    return matchCategory && matchSearch;
  });
});
</script>
