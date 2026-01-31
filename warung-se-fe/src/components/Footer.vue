<!-- eslint-disable vue/multi-word-component-names -->
<template>
  <footer class="w-full bg-gray-900 text-white pt-10 pb-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- GRID SECTION -->
      <div class="grid grid-cols-2 md:grid-cols-4 gap-8 pb-10 border-b border-gray-700">
        <!-- Kolom 1: Brand & Lokasi -->
        <div class="space-y-3">
          <h3 class="text-2xl font-extrabold text-warning">WarungSE</h3>
          <p class="text-sm text-gray-400">
            Pelopor Geprek Surakarta. Rasa Pedas Otentik yang Tak Tertandingi.
          </p>
          <p class="text-sm text-gray-400 flex items-center gap-2">
            <MapPinIcon class="w-4 h-4 text-primary" /> Surakarta, Indonesia
          </p>
        </div>

        <!-- Kolom 2: Menu Cepat -->
        <div class="space-y-4">
          <h4 class="text-base font-semibold text-white">Menu Cepat</h4>
          <ul class="space-y-2 text-sm">
            <li>
              <router-link to="/" class="text-gray-400 hover:text-warning transition"
                >Beranda</router-link
              >
            </li>
            <li>
              <router-link to="/menu" class="text-gray-400 hover:text-warning transition"
                >Daftar Menu</router-link
              >
            </li>
            <li>
              <!-- Menggunakan router-link untuk #contact agar memanfaatkan scrollBehavior -->
              <router-link to="/#contact" class="text-gray-400 hover:text-warning transition"
                >Kontak Kami</router-link
              >
            </li>
          </ul>
        </div>

        <!-- Kolom 3: Layanan & Akun -->
        <div class="space-y-4">
          <h4 class="text-base font-semibold text-white">Akun</h4>
          <ul class="space-y-2 text-sm">
            <li>
              <router-link to="/cart" class="text-gray-400 hover:text-warning transition"
                >Keranjang</router-link
              >
            </li>
            <li>
              <router-link to="/akun-saya" class="text-gray-400 hover:text-warning transition"
                >Akun Saya</router-link
              >
            </li>
            <li>
              <a href="#" class="text-gray-400 hover:text-warning transition">Syarat & Ketentuan</a>
            </li>
          </ul>
        </div>

        <!-- Kolom 4: Media Sosial & Like -->
        <div class="space-y-4">
          <h4 class="text-base font-semibold text-white">Ikuti Kami</h4>
          <div class="flex items-center gap-4">
            <!-- Social Icons: hover effect menggunakan warna primary -->
            <a href="#" class="text-gray-400 hover:text-primary transition" aria-label="Instagram">
              <InstagramIcon class="w-6 h-6" />
            </a>
            <a href="#" class="text-gray-400 hover:text-primary transition" aria-label="Facebook">
              <FacebookIcon class="w-6 h-6" />
            </a>
            <!-- Heart Icon: Menggunakan warna primary untuk tampilan default -->
            <a href="#" class="text-primary hover:text-primary-dark transition" aria-label="Like">
              <HeartIcon class="w-6 h-6 fill-primary" />
            </a>
          </div>
        </div>
      </div>

      <!-- Copyright -->
      <div class="mt-4 pt-4">
        <p class="text-center text-sm text-gray-500">
          © {{ new Date().getFullYear() }} WarungSE. Semua hak dilindungi undang-undang.
        </p>
      </div>
    </div>
  </footer>
</template>

<script setup>
import { HeartIcon, InstagramIcon, FacebookIcon, MapPinIcon } from "lucide-vue-next";
</script>
