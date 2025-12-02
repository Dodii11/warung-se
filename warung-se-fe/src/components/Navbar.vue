<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <!-- Header container: Fixed di atas, menggunakan warna primary. Shadow-2xl untuk efek floating. -->
  <header class="fixed top-0 left-0 w-full bg-primary shadow-2xl z-50 h-[60px]">
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 h-full flex items-center justify-between">
      <!-- LEFT : LOGO & BRAND -->
      <router-link to="/" class="flex items-center gap-3 transition-opacity duration-200 hover:opacity-80" @click="isOpen = false">
        <!-- Logo -->
        <img :src="logo" class="h-10 w-auto" alt="Logo WarungSE" />
        <div class="flex flex-col leading-tight">
          <span class="text-warning text-sm font-semibold">Pelopor Geprek</span>
          <span class="text-white text-xs -mt-1">Surakarta</span>
        </div>
      </router-link>

      <!-- CENTER : MENU DESKTOP -->
      <ul class="hidden md:flex items-center gap-8">
        <li v-for="item in navItems" :key="item.path" class="relative group">
          <router-link
            :to="item.path"
            custom
          >
            <a
              :href="item.path"
              class="text-sm font-medium transition duration-200 block"
              :class="isLinkActive(item) ? 'text-warning font-bold' : 'text-white group-hover:text-warning'"
              @click.prevent="handleNavClick(item)"
            >
              {{ item.name }}
            </a>
          </router-link>
        </li>
      </ul>

      <!-- RIGHT : ICON CART + PROFILE DESKTOP -->
      <div class="hidden md:flex items-center gap-3">
        <!-- Cart Icon -->
        <router-link
          to="/cart"
          class="bg-primary/80 p-2 rounded-full hover:bg-primary-dark text-white transition duration-200 shadow-md relative"
          aria-label="Keranjang Belanja"
        >
          <ShoppingCartIcon class="w-5 h-5" />
          <!-- Dummy Badge Keranjang -->
          <span v-if="cartCount > 0" class="absolute top-0 right-0 block h-2.5 w-2.5 rounded-full ring-2 ring-primary bg-warning"></span>
        </router-link>

        <!-- User Profile CTA -->
        <router-link
          to="/akun-saya"
          class="flex items-center gap-2 group p-2 rounded-full transition duration-300 ease-in-out hover:bg-primary-dark/80 cursor-pointer border border-transparent hover:border-warning"
          aria-label="Akun Saya"
        >
          <!-- Text clickable -->
          <span class="text-white text-sm font-medium transition group-hover:text-warning">Halo, User</span>
          <!-- User Icon -->
          <UserIcon class="h-6 w-6 text-warning border-2 border-warning rounded-full p-0.5 bg-white/10" />
        </router-link>
      </div>

      <!-- HAMBURGER MENU MOBILE -->
      <div class="md:hidden flex items-center gap-3">
        <router-link to="/cart" class="text-white hover:text-warning transition duration-200 relative" aria-label="Keranjang Belanja">
          <ShoppingCartIcon class="w-6 h-6" />
          <span v-if="cartCount > 0" class="absolute top-0 right-0 block h-2.5 w-2.5 rounded-full ring-2 ring-primary bg-warning"></span>
        </router-link>

        <button @click="isOpen = !isOpen" class="text-white p-1 rounded-md hover:bg-primary-dark/50 transition focus:outline-none" aria-label="Toggle Menu">
          <MenuIcon v-if="!isOpen" class="w-6 h-6" />
          <XIcon v-else class="w-6 h-6" />
        </button>
      </div>
    </nav>

    <!-- MOBILE MENU DRAWER (Responsiveness sudah clean) -->
    <div
      v-if="isOpen"
      class="md:hidden absolute top-[60px] left-0 right-0 bg-primary-dark w-full shadow-lg transition-all duration-300 ease-in-out overflow-hidden"
    >
      <ul class="flex flex-col gap-2 p-4">
        <!-- Nav Items -->
        <li v-for="item in navItems" :key="item.path">
          <router-link
            :to="item.path"
            class="block py-2 px-3 text-white text-base font-semibold hover:bg-primary/80 rounded-lg transition"
            :class="{ 'bg-primary/80 text-warning': isLinkActive(item) }"
            @click="
              isOpen = false;
              handleNavClick(item);
            "
          >
            {{ item.name }}
          </router-link>
        </li>
        <!-- Profile Link Mobile -->
        <li class="pt-2 mt-2 border-t border-primary/50">
          <router-link
            to="/akun-saya"
            class="flex items-center gap-3 py-2 px-3 text-white text-base font-semibold hover:bg-primary/80 rounded-lg transition"
            @click="isOpen = false"
          >
            <!-- User Icon Mobile -->
            <UserIcon class="h-6 w-6 text-warning border border-warning rounded-full p-0.5 bg-white/10" />
            Halo, User (Akun Saya)
          </router-link>
        </li>
      </ul>
    </div>
  </header>
</template>

<script setup>
import { ref } from "vue";
import { useRouter, useRoute } from "vue-router";
import { MenuIcon, XIcon, ShoppingCartIcon, UserIcon } from "lucide-vue-next";
import logo from "@/assets/LogoDashboardAdmin.png"; // Memastikan logo yang benar diimpor

const router = useRouter();
const route = useRoute();
const isOpen = ref(false);
const cartCount = ref(3); // Dummy untuk badge keranjang

// Item navigasi, Kontrol hash link
const navItems = [
  { name: "Beranda", path: "/" },
  { name: "Menu", path: "/menu" },
  { name: "Kontak", path: "/#contact", hash: "#contact" },
];

/**
 * Logika custom untuk menentukan status aktif item navigasi (Desktop dan Mobile).
 * Mengatasi masalah path '/' yang selalu dianggap aktif (partial match) dan hash link.
 */
const isLinkActive = (item) => {
    if (item.path === '/') {
        return route.path === '/' && (route.hash === '' || route.hash === null || route.hash === undefined);
    }
    if (item.hash) {
        return route.path === '/' && route.hash === item.hash;
    }
    return route.path === item.path;
}

/**
 * Menangani klik navigasi.
 * Jika ada hash (#contact), gunakan router.push untuk memanfaatkan scrollBehavior.
 */
const handleNavClick = (item) => {
  if (item.hash) {
    router.push({ path: item.path });
  } else {
    router.push(item.path);
  }
};
</script>
