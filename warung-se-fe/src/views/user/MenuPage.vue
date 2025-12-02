<template>
  <!-- Wrapper utama dengan background abu-abu muda, Padding Vertikal Responsif -->
  <div class="min-h-screen bg-gray-50 py-12 sm:py-16">
    <!-- Padding Horizontal Responsif (px-4/sm:px-6/lg:px-8) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Kontainer Konten Utama (Floating Card) -->
      <div class="bg-white rounded-3xl shadow-2xl shadow-gray-200/50 p-6 sm:p-10 lg:p-12 pb-16">
        <header class="text-center mb-10">
          <!-- Ukuran font header yang responsif -->
          <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-gray-900 mb-3">
            Katalog <span class="text-red-600">Menu</span>
          </h1>
          <p class="text-center text-gray-600 text-base sm:text-lg max-w-2xl mx-auto">
            Temukan kelezatan renyah di setiap gigitan. Dibuat dengan bahan-bahan segar dan resep
            rahasia kami.
          </p>
        </header>

        <!-- Filter Kategori: Menggunakan flex-wrap untuk tata letak rapi di mobile -->
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

        <!-- Menu Grid -->
        <section>
          <!-- Grid Responsif: Skala dari 2 kolom (mobile) hingga 4 kolom (desktop) dengan gap konsisten -->
          <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 gap-6 sm:gap-8">
            <UserAppCard
              v-for="(item, idx) in filteredMenus"
              :key="idx"
              padding="sm"
              class="flex flex-col justify-between hover:shadow-red-200/50 transform hover:scale-[1.02] transition-all duration-300"
            >
              <!-- Konten Card (menggunakan grow untuk tinggi seragam dan konsisten) -->
              <div class="grow">
                <!-- Gambar: Tinggi tetap (h-36) dan lebar penuh (w-full) agar proporsi card terjaga -->
                <img
                  :src="item.img"
                  class="rounded-xl w-full h-36 object-cover mb-4 shadow-sm border border-gray-100"
                  :alt="'Gambar ' + item.name"
                />

                <!-- Detail -->
                <div class="text-gray-900">
                  <h3 class="font-bold text-lg mb-1 line-clamp-2">{{ item.name }}</h3>
                  <!-- Harga Menonjol -->
                  <p class="text-red-600 font-extrabold text-xl">Rp {{ item.price }}</p>
                </div>
              </div>

              <!-- Button Pesan Sekarang: Selalu lebar penuh di dalam card -->
              <UserAppButton
                size="sm"
                class="mt-3 w-full shadow-sm"
                @click="goToDetail(item.name)"
              >
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
import { ref, computed } from "vue";
import { useRouter } from "vue-router";
import { menus, categories } from "@/data/UserAppData";

import UserAppCard from "@/components/baseUser/UserAppCard.vue";
import UserAppButton from "@/components/baseUser/UserAppButton.vue";
import UserAppCategoryButton from "@/components/baseUser/UserAppCategoryButton.vue";
import { ChefHat } from "lucide-vue-next";

const router = useRouter();

// --- STATE & LOGIC ---
// Kategori default diatur ke 'Ayam'
const selectedCategory = ref("Ayam");

// Filter menu berdasarkan kategori yang dipilih
const filteredMenus = computed(() =>
  menus.filter((item) => item.category === selectedCategory.value)
);

// --- NAVIGATION ---
function goToDetail(name) {
  router.push({ name: "DetailMenu", params: { name: encodeURIComponent(name) } });
}
</script>
