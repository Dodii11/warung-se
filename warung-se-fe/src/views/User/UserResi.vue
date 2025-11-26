<!-- src/views/User/UserResi.vue -->
<template>
  <div class="container mx-auto px-4 py-8">

    <!-- Resi Card -->
    <div class="max-w-md mx-auto bg-white rounded-xl shadow p-6">
      <!-- Logo & Nama Warung -->
      <div class="text-center mb-4">
        <img src="https://placehold.co/80x80?text=SE" alt="Warung SE" class="mx-auto w-16 h-16 rounded-full" />
        <h1 class="text-xl font-bold mt-2">Warung SE</h1>
        <p class="text-sm text-gray-600">Jl. Kartika 5 No.3, Jebres, Kec. Jebres, Kota Surakarta</p>
      </div>

      <!-- Garis Pemisah -->
      <div class="border-t border-gray-200 my-4"></div>

      <!-- Detail Pesanan -->
      <div class="text-sm space-y-1 mb-4">
        <div><span class="font-medium">Pesanan #</span> {{ order.id }}</div>
        <div><span class="font-medium">Pelanggan:</span> {{ order.customerName }}</div>
        <div><span class="font-medium">Nomor:</span> {{ order.phone }}</div>
      </div>

      <!-- Garis Pemisah -->
      <div class="border-t border-gray-200 my-4"></div>

      <!-- Daftar Barang -->
      <div class="space-y-2 mb-4">
        <div v-for="item in order.items" :key="item.name" class="flex justify-between">
          <span>{{ item.name }} x{{ item.quantity }}</span>
          <span>Rp {{ item.price.toLocaleString() }}</span>
        </div>
      </div>

      <!-- Garis Pemisah -->
      <div class="border-t border-gray-200 my-4"></div>

      <!-- Ringkasan Biaya -->
      <div class="space-y-1 mb-4">
        <div class="flex justify-between">
          <span>Subtotal</span>
          <span>Rp {{ order.subtotal.toLocaleString() }}</span>
        </div>
        <div class="flex justify-between">
          <span>Biaya Pengiriman</span>
          <span>Rp {{ order.shippingFee.toLocaleString() }}</span>
        </div>
        <div class="flex justify-between">
          <span>Tax (0%)</span>
          <span>Rp 0</span>
        </div>
        <div class="flex justify-between font-bold text-lg pt-2">
          <span>Total</span>
          <span>Rp {{ order.total.toLocaleString() }}</span>
        </div>
      </div>

      <!-- Garis Pemisah -->
      <div class="border-t border-gray-200 my-4"></div>

      <!-- Footer -->
      <div class="flex items-center justify-center text-sm text-gray-600">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2h-2v-4a2 2 0 00-2-2H9M17 17v2c0 2-2 4-4 4H9M9 19v-2c0-2 2-4 4-4h4" />
        </svg>
        Terima kasih sudah memesan di Warung SE!
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'

const route = useRoute()
const order = ref({
  id: '12345',
  customerName: 'Sasha',
  phone: '081234567890',
  items: [
    { name: 'Ayam Geprek Original', quantity: 2, price: 30000 },
    { name: 'Es Teh', quantity: 1, price: 3000 },
    { name: 'Es Jeruk', quantity: 1, price: 4000 }
  ],
  subtotal: 37000,
  shippingFee: 5000,
  total: 42000
})

// Simulasi ambil data berdasarkan orderId dari URL
onMounted(() => {
  const orderId = route.params.orderId
  // Di sini bisa fetch data dari API berdasarkan orderId
  console.log('Loading order:', orderId)
})
</script>