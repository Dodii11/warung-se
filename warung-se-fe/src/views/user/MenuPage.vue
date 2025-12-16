<template>
  <!-- Wrapper utama -->
  <div class="min-h-screen bg-gray-50 py-12 sm:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Kontainer kartu utama -->
      <div class="bg-white rounded-3xl shadow-2xl shadow-gray-200/50 p-6 sm:p-10 lg:p-12 pb-16">
        <!-- Header -->
        <header class="text-center mb-10">
          <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-gray-900 mb-3">
            Katalog <span class="text-red-600">Menu</span>
          </h1>
          <p class="text-center text-gray-600 text-base sm:text-lg max-w-2xl mx-auto">
            Temukan kelezatan renyah di setiap gigitan. Dibuat dengan bahan-bahan segar dan resep
            rahasia kami.
          </p>
        </header>

        <!-- Filter Kategori -->
        <div class="flex flex-wrap justify-center gap-x-4 sm:gap-x-6 gap-y-3 mb-12">
          <UserAppCategoryButton
            v-for="cat in categories"
            :key="cat"
            :is-active="selectedCategory === cat"
            @click="selectedCategory = cat"
          >
            {{ cat }}
          </UserAppCategoryButton>
        </div>

        <!-- GRID MENU -->
        <section>
          <div
            class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5 sm:gap-7 max-w-7xl mx-auto"
          >
            <UserAppCard
              v-for="item in filteredMenus"
              :key="item.id_menu"
              padding="sm"
              class="flex flex-col justify-between"
            >
              <div>
                <img
                  :src="item.gambar_url"
                  class="rounded-xl w-full aspect-4/3 object-cover mb-4"
                  :alt="item.menu"
                />

                <div>
                  <h3 class="font-bold text-lg">{{ item.menu }}</h3>
                  <p class="text-red-600 font-extrabold text-xl">
                    Rp {{ item.harga.toLocaleString() }}
                  </p>
                </div>
              </div>

              <UserAppButton size="sm" class="mt-4 w-full" @click="goToDetail(item)">
                <template #icon-left>
                  <ChefHat class="w-4 h-4" />
                </template>
                Pesan Sekarang
              </UserAppButton>
            </UserAppCard>
          </div>
        </section>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import { useRouter } from "vue-router";
import { menuApi } from "@/api/menu";

import UserAppCard from "@/components/baseUser/UserAppCard.vue";
import UserAppButton from "@/components/baseUser/UserAppButton.vue";
import UserAppCategoryButton from "@/components/baseUser/UserAppCategoryButton.vue";
import { ChefHat } from "lucide-vue-next";

const router = useRouter();

const menus = ref([]);
const selectedCategory = ref("Semua");

// ambil menu dari API
const fetchMenus = async () => {
  const res = await menuApi.getAll();
  menus.value = res.data.data ?? res.data;
};

onMounted(fetchMenus);

// kategori unik dari API
const categories = computed(() => {
  const cats = menus.value.map((m) => m.kategori);
  return ["Semua", ...new Set(cats)];
});

// filter menu
const filteredMenus = computed(() => {
  if (selectedCategory.value === "Semua") return menus.value;
  return menus.value.filter((item) => item.kategori === selectedCategory.value);
});

function goToDetail(menu) {
  router.push({
    name: "DetailMenu",
    params: { name: encodeURIComponent(menu.menu) },
  });
}
</script>
