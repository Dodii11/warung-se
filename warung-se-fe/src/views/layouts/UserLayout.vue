<template>
  <div class="min-h-screen bg-bg-base"> <!-- (atau bg-white) -->
    
    <!-- 1. PASANG NAVBAR DI SINI -->
    <Navbar />

    <!-- 2. BUAT "LUBANG" UNTUK KONTEN CUSTOMER -->
    <main class="max-w-7xl mx-auto p-6">
      <RouterView />
    </main>
    
    <!-- (Nanti Anda bisa tambahkan <Footer /> di sini) -->
  </div>
</template>

<script setup>
import { RouterView } from 'vue-router'
// Ganti path ini jika Navbar Anda ada di tempat lain
import Navbar from '@/components/Navbar.vue' 
</script>