<template>
  <div class="min-h-screen flex flex-col bg-bg">
    <Navbar />
    <main class="flex-1 max-w-7xl mx-auto p-6 pt-[72px] w-full">
      <RouterView />
    </main>

    <Footer />
  </div>
</template>

<script setup>
import { RouterView } from 'vue-router';
import Navbar from '@/components/Navbar.vue'
import Footer from '@/components/Footer.vue';
</script>
