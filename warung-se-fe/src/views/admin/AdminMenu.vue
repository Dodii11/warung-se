<template>
  <section class="p-6 space-y-8">
    <!-- HEADER -->
    <header class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
      <div>
        <h1 class="heading-1">Manajemen Menu</h1>
        <p class="text-gray-600 text-sm">Kelola menu yang tersedia dalam sistem</p>
      </div>

      <BaseButton size="sm"> Tambah Menu </BaseButton>
    </header>

    <!-- FILTERS -->
    <BaseCard class="flex flex-wrap items-center gap-4 justify-between">
      <div class="flex items-center gap-4">
        <MenuFilter v-model="selectedCategory" :options="categoryOptions" />
      </div>

      <div class="flex items-center">
        <MenuSearch v-model="search" />
      </div>
    </BaseCard>

    <!-- TABLE -->
    <BaseCard>
      <BaseTable :columns="columns" :rows="filtered">
        <!-- GAMBAR -->
        <template #image="{ row }">
          <img :src="row.image" class="w-12 h-12 rounded-lg object-cover" alt="menu-img" />
        </template>

        <!-- NAMA -->
        <template #name="{ row }">
          <p class="font-semibold">{{ row.name }}</p>
        </template>

        <!-- DESKRIPSI -->
        <template #description="{ row }">
          <p class="text-gray-500 text-sm">{{ row.description }}</p>
        </template>

        <!-- HARGA -->
        <template #price="{ row }"> Rp {{ row.price.toLocaleString("id-ID") }} </template>

        <!-- ACTIONS -->
        <template #action="{ row }">
          <MenuRowActions
            :item="row"
            @edit="editItem"
            @delete="deleteItem"
            @toggle-status="toggleStatus"
          />
        </template>
      </BaseTable>
    </BaseCard>
  </section>
</template>

<script setup>
import { ref, computed } from "vue";

import BaseCard from "@/components/base/BaseCard.vue";
import BaseTable from "@/components/base/BaseTable.vue";
import BaseButton from "@/components/base/BaseButton.vue";

import MenuFilter from "@/components/admin/menu/MenuFilter.vue";
import MenuSearch from "@/components/admin/menu/MenuSearch.vue";
import MenuRowActions from "@/components/admin/menu/MenuRowActions.vue";

import { categoryOptions, menuItems } from "@/data/menuData";

const search = ref("");
const selectedCategory = ref("Kategori");

const items = ref([...menuItems]);

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

// ACTIONS
const editItem = (item) => console.log("EDIT", item);

const deleteItem = (item) => {
  items.value = items.value.filter((i) => i.id !== item.id);
};

</script>
