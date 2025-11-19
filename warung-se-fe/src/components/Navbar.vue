<template>
  <div>
    <header class="fixed top-0 left-0 w-full bg-red-600 shadow-md z-50 h-15">
      <nav class="max-w-7xl mx-auto px-6 py-3 flex items-center justify-between">
        
        <!-- LEFT : LOGO -->
        <div class="flex items-center gap-3">
          <img
            :src="logo"
            class="h-10 w-auto"
            alt="Logo"
          />
          <div class="flex flex-col leading-tight">
            <span class="text-yellow-300 text-sm font-semibold">Geprek Bokong</span>
            <span class="text-white text-xs -mt-1">Ngawi Selatan</span>
          </div>
        </div>

        <!-- CENTER : MENU -->
        <ul class="flex items-center gap-8">
          <!-- Beranda -->
          <li
            class="cursor-pointer relative pb-1 transition"
            :class="$route.name === 'LandingPage' && !$route.hash ? 'text-yellow-300 font-semibold' : 'text-white hover:text-yellow-300'"
          >
            <router-link to="/" class="block pb-1 text-white" @click="activeMenu = 'Beranda'">
              Beranda
            </router-link>
            <span
              v-if="$route.name === 'LandingPage' && !$route.hash"
              class="absolute left-0 -bottom-1 w-full h-[2px] bg-yellow-300 rounded-full"
            ></span>
          </li>

          <!-- Menu -->
          <li
            class="cursor-pointer relative pb-1 transition"
            :class="$route.name === 'MenuPage' ? 'text-yellow-300 font-semibold' : 'text-white hover:text-yellow-300'"
          >
            <router-link to="/menu" class="block pb-1 text-white" @click="activeMenu = 'Menu'">
              Menu
            </router-link>
            <span
              v-if="$route.name === 'MenuPage'"
              class="absolute left-0 -bottom-1 w-full h-[2px] bg-yellow-300 rounded-full"
            ></span>
          </li>

          <!-- Kontak -->
          <!-- Kita gunakan <a> tag untuk link internal ke #contact di halaman saat ini -->
          <li
            class="cursor-pointer relative pb-1 transition"
            :class="$route.hash === '#contact' ? 'text-yellow-300 font-semibold' : 'text-white hover:text-yellow-300'"
          >
            <!-- Tambahkan class hover:underline agar hanya "Kontak" yang bergaris bawah saat hover -->
            <a href="#contact" class="block pb-1 text-white hover:underline" @click="activeMenu = 'Kontak'">
              Kontak
            </a>
            <span
              v-if="$route.hash === '#contact'"
              class="absolute left-0 -bottom-1 w-full h-[2px] bg-yellow-300 rounded-full"
            ></span>
          </li>
        </ul>

        <!-- RIGHT : ICON CART + PROFILE -->
        <div class="flex items-center gap-5">
          <!-- Keranjang -->
          <div class="relative">
            <button class="bg-red-700 p-2 rounded-full hover:bg-red-800">
              🛒
            </button>
          </div>

          <!-- Profile -->
          <div class="flex items-center gap-2">
            <span class="text-white text-sm">Halo, User</span>
            <img
              :src="profile"
              class="h-8 w-8 rounded-full border-2 border-white object-cover"
              alt="User"
            />
          </div>
        </div>

      </nav>
    </header>

    <!-- Tempatkan konten anak (LandingPage, MenuPage, dll) -->
    <main class="pt-15">
      <router-view />
    </main>
  </div>
</template>

<script setup>
import { ref, watch } from "vue";
import { useRoute } from "vue-router";
import logo from "@/assets/LogoDashboardAdmin.png";

const activeMenu = ref("Beranda");
const route = useRoute();

// Update activeMenu berdasarkan route saat ini
watch(
  () => route.name,
  (newRouteName) => {
    if (newRouteName === "LandingPage") {
      // Jika hash bukan #contact, maka aktifkan Beranda
      if (route.hash !== "#contact") {
        activeMenu.value = "Beranda";
      }
    } else if (newRouteName === "MenuPage") {
      activeMenu.value = "Menu";
    }
  },
  { immediate: true }
);

// Watch hash untuk "Kontak"
watch(
  () => route.hash,
  (newHash) => {
    if (newHash === "#contact") {
      activeMenu.value = "Kontak";
    } else if (route.name === "LandingPage") {
      // Jika kembali ke atas landing page (tanpa hash), aktifkan Beranda
      activeMenu.value = "Beranda";
    }
  }
);
</script>

<style scoped>
/* Pastikan h-15 dan pt-15 didefinisikan di Tailwind Anda */
/* Contoh: h-[60px] dan pt-[60px] jika h-15 tidak didefinisikan */
</style>