<template>
  <div>
    <header class="fixed top-0 left-0 w-screen bg-red-600 shadow-md z-50 h-[60px]">
      <nav class="max-w-7xl mx-auto px-6 py-3 flex items-center justify-between">
        <!-- LEFT : LOGO -->
        <div class="flex items-center gap-3">
          <img :src="logo" class="h-10 w-auto" alt="Logo" />
          <div class="flex flex-col leading-tight">
            <span class="text-yellow-300 text-sm font-semibold">Pelopor Geprek</span>
            <span class="text-white text-xs -mt-1">Surakarta</span>
          </div>
        </div>

        <!-- CENTER : MENU DESKTOP -->
        <ul class="hidden md:flex items-center gap-8">
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

          <li
            class="cursor-pointer relative pb-1 transition"
            :class="isContactActive ? 'text-yellow-300 font-semibold' : 'text-white hover:text-yellow-300'"
          >
            <a href="#" class="block pb-1 text-white" @click.prevent="goToContact">
              Kontak
            </a>
            <span
              v-if="isContactActive"
              class="absolute left-0 -bottom-1 w-full h-[2px] bg-yellow-300 rounded-full"
            ></span>
          </li>
        </ul>

        <!-- RIGHT : ICON CART + PROFILE DESKTOP -->
        <div class="hidden md:flex items-center gap-5">
          <router-link to="/cart" class="bg-red-700 p-2 rounded-full hover:bg-red-800 text-white">
            🛒
          </router-link>

          <div class="flex items-center gap-2">
            <span class="text-white text-sm">Halo, User</span>
            <router-link to="/akun-saya">  
            <img
              :src="profile"
              class="h-8 w-8 rounded-full border-2 border-white object-cover"
              alt="User"
            />
            </router-link>
          </div>
        </div>

        <!-- HAMBURGER MENU MOBILE -->
        <div class="md:hidden flex items-center">
          <button @click="isOpen = !isOpen" class="text-white focus:outline-none">
            <span v-if="!isOpen">☰</span>
            <span v-else>✕</span>
          </button>
        </div>
      </nav>

      <!-- MOBILE MENU -->
      <div v-if="isOpen" class="md:hidden bg-red-600 w-full shadow-md">
        <ul class="flex flex-col items-center gap-4 py-4">
          <li>
            <router-link
              to="/"
              class="text-white text-base font-semibold"
              @click="activeMenu='Beranda'; isOpen=false"
            >
              Beranda
            </router-link>
          </li>
          <li>
            <router-link
              to="/menu"
              class="text-white text-base font-semibold"
              @click="activeMenu='Menu'; isOpen=false"
            >
              Menu
            </router-link>
          </li>
          <li>
            <a href="#" class="text-white text-base font-semibold" @click.prevent="goToContact(); isOpen=false">
              Kontak
            </a>
          </li>
          <li class="flex items-center gap-3 mt-2">
            <router-link to="/cart" class="bg-red-700 p-2 rounded-full hover:bg-red-800 text-white">
              🛒
            </router-link>
            <img
              :src="profile"
              class="h-8 w-8 rounded-full border-2 border-white object-cover"
              alt="User"
            />
            <span class="text-white text-sm">Halo, User</span>
          </li>
        </ul>
      </div>
    </header>

    <!-- Isi konten halaman -->
    <main class="pt-[60px]">
      <router-view />
    </main>
  </div>
</template>

<script setup>
import { ref, computed, watch, nextTick } from "vue";
import { useRoute, useRouter } from "vue-router";
import logo from "@/assets/LogoDashboardAdmin.png";

// Placeholder profil
const profile = "https://placehold.co/32/cccccc/666666?text=👤";

const route = useRoute();
const router = useRouter();
const activeMenu = ref("Beranda");
const isOpen = ref(false);

const isContactActive = computed(() => {
  return route.name === "LandingPage" && route.hash === "#contact";
});

const goToContact = async () => {
  activeMenu.value = "Kontak";

  if (route.name !== "LandingPage") {
    await router.push({ name: "LandingPage" });
    await nextTick();
  }

  const el = document.getElementById("contact");
  if (el) el.scrollIntoView({ behavior: "smooth", block: "start" });
};

watch(
  () => route,
  () => {
    if (route.name === "LandingPage") {
      activeMenu.value = route.hash === "#contact" ? "Kontak" : "Beranda";
    } else if (route.name === "MenuPage") {
      activeMenu.value = "Menu";
    }
    isOpen.value = false; // close mobile menu on route change
  },
  { immediate: true, deep: true }
);
</script>

<style scoped>
/* Navbar fixed tetap di atas */
</style>
