<script setup>
import { onMounted, ref } from 'vue';
import apiClient from '@/api/axios'; // Sesuaikan path jika perlu

const message = ref('Sedang memuat...');

onMounted(async () => {
  try {
    // Kita panggil rute /api/test yang tadi dibuat
    const response = await apiClient.get('/test');
    message.value = response.data.message; // "API Warung Ayam Berhasil Terhubung!"
  } catch (error) {
    console.error('Error fetching data:', error);
    message.value = 'Gagal terhubung ke API. Cek CORS.';
  }
});
</script>

<template>
  <main>
    <h1>Tes Koneksi API</h1>
    <p>{{ message }}</p>
  </main>
</template>
