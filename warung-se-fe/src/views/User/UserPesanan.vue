<!-- src/views/User/UserPesanan.vue -->
<template>
  <div class="container mx-auto px-4 py-8">
    <!-- Judul Halaman -->
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Akun Saya</h1>

    <!-- Tab Navigation -->
    <UserTabNavigation />

    <!-- Status Pesanan Saat Ini -->
    <div class="bg-white rounded-xl shadow p-6 mb-8">
      <h2 class="text-xl font-semibold text-gray-900 mb-4">Status Pesanan Saat Ini</h2>

      <!-- Header Pesanan -->
      <div class="flex justify-between items-center mb-4">
        <span class="text-sm text-gray-600">Pesanan #12346</span>
        <span class="text-sm text-gray-600">Status: Preparing Food</span>
      </div>

      <!-- Progress Bar -->
      <div class="flex items-center gap-4">
        <div class="flex-1 bg-gray-200 rounded-full h-2">
          <div class="bg-red-500 h-2 rounded-full" style="width: 60%"></div>
        </div>
        <div class="flex gap-4 text-xs text-gray-600 whitespace-nowrap">
          <span>Pesanan Dikonfirmasi</span>
          <span>Preparing Food</span>
          <span>Dalam Perjalanan</span>
          <span>Terkirim</span>
        </div>
      </div>
    </div>

    <!-- Pesanan Sebelumnya -->
    <div class="bg-white rounded-xl shadow p-6">
      <h2 class="text-xl font-semibold text-gray-900 mb-4">Pesanan Sebelumnya</h2>

      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PESANAN #</th>
              <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">TANGGAL</th>
              <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">BARANG</th>
              <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">TOTAL</th>
              <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">STATUS</th>
              <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">AKSI</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="item in pesanan" :key="item.id" class="hover:bg-gray-50">
              <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ item.nomor }}</td>
              <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">{{ item.tanggal }}</td>
              <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">{{ item.barang }} Barang</td>
              <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">Rp {{ item.total }}</td>
              <td class="px-4 py-4 whitespace-nowrap">
                <span 
                  class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                  :class="{
                    'bg-red-100 text-red-800': item.status === 'Terkirim',
                    'bg-yellow-100 text-yellow-800': item.status === 'Dalam Perjalanan',
                    'bg-blue-100 text-blue-800': item.status === 'Preparing Food',
                    'bg-gray-100 text-gray-800': item.status === 'Dibatalkan'
                  }"
                >
                  {{ item.status }}
                </span>
              </td>
              <td class="px-4 py-4 whitespace-nowrap text-sm">
                <router-link 
                  :to="{ name: 'UserResi', params: { pesananId: item.id } }"
                  class="text-red-600 hover:text-red-900 font-medium"
                >
                  Cetak Resi
                </router-link>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import UserTabNavigation from '@/components/user/UserProfileTabs.vue'

const pesanan = ref([
  { id: 1, nomor: '#12345', tanggal: '15 Juli 2024', barang: 2, total: '25.000', status: 'Terkirim' },
  { id: 2, nomor: '#12344', tanggal: '10 Juli 2024', barang: 3, total: '50.000', status: 'Terkirim' },
  { id: 3, nomor: '#12343', tanggal: '5 Juli 2024',  barang: 1, total: '15.000', status: 'Dalam Perjalanan' },
  { id: 4, nomor: '#12342', tanggal: '1 Juli 2024',   barang: 4, total: '60.000', status: 'Preparing Food' }
])
</script>