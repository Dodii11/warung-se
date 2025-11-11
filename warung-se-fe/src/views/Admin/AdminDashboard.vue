<template>
  <div class="min-h-screen flex flex-col items-center justify-center bg-gray-50">
    <h1 class="text-3xl font-bold text-[#E53935] mb-2">Selamat datang, {{ auth.user.name }}</h1>
    <p class="text-gray-600 mb-6">Role: {{ auth.user.role }}</p>
    <button
      @click="auth.logout(); $router.push('/login')"
      class="px-6 py-3 bg-[#E53935] text-white rounded-lg hover:bg-[#D32F2F] transition"
    >
      Logout
    </button>
  </div>
</template>

<script setup>
import { useAuthStore } from '@/stores/authStore'
const auth = useAuthStore()
</script>
