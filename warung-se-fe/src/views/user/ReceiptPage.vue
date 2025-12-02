<template>
  <div class="min-h-screen bg-gray-50 p-4 pt-28 flex justify-center relative">

    <!-- Tombol Kembali (Teks saja) -->
    <router-link
      to="/detail-pesanan"
      class="absolute top-20 left-4 text-gray-700 hover:text-black font-medium text-sm flex items-center gap-1"
    >
      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
      </svg>
      Kembali
    </router-link>

    <!-- Struk -->
    <div class="bg-white rounded-xl shadow-md p-6 w-full max-w-md">

      <!-- Logo & Header -->
      <div class="text-center mb-3">
        <img
          src="https://placehold.co/80x80/red/white?text=SE"
          alt="Logo Warung SE"
          class="w-12 h-12 sm:w-16 sm:h-16 mx-auto"
        />
        <h1 class="font-bold text-base sm:text-lg mt-1">Warung SE</h1>
        <p class="text-xs sm:text-sm text-gray-600 text-center">
          Jl. Kartika 5 No.3, Jebres, Kec. Jebres, Kota Surakarta
        </p>
      </div>

      <hr class="my-3 border-dashed border-gray-300" />

      <!-- Detail Pesanan -->
      <div class="text-center text-xs sm:text-sm mb-3">
        <p><span class="font-semibold">Pesanan #{{ orderId }}</span></p>
        <p><span class="font-semibold">Pelanggan:</span> {{ order?.customer.name || 'Edi Geyming' }}</p>
        <p><span class="font-semibold">Nomor:</span> {{ order?.customer.phone || '081234567890' }}</p>
      </div>

      <hr class="my-3 border-dashed border-gray-300" />

      <!-- Daftar Item -->
      <div class="space-y-2 mb-3 text-xs sm:text-sm">
        <div
          v-for="(item, index) in order?.items || defaultItems"
          :key="index"
          class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-1 sm:gap-3"
        >
          <div class="flex items-center gap-2">
            <img
              v-if="item.image"
              :src="item.image"
              :alt="item.name"
              class="w-10 h-10 sm:w-12 sm:h-12 object-cover rounded-md"
            />
            <span class="font-medium">{{ item.name }} x{{ item.qty }}</span>
          </div>
          <span class="font-bold text-red-600">Rp {{ formatCurrency(item.total) }}</span>
        </div>
      </div>

      <hr class="my-3 border-dashed border-gray-300" />

      <!-- Ringkasan -->
      <div class="space-y-1 text-xs sm:text-sm">
        <div class="flex justify-between">
          <span>Subtotal</span>
          <span>Rp {{ formatCurrency(order?.subtotal || 37000) }}</span>
        </div>
        <div class="flex justify-between">
          <span class="text-gray-600">Biaya Pengiriman</span>
          <span>Rp {{ formatCurrency(order?.shippingFee || 5000) }}</span>
        </div>
        <div class="flex justify-between">
          <span>Tax (0%)</span>
          <span>Rp 0</span>
        </div>
        <hr class="my-2 border-gray-300" />
        <div class="flex justify-between font-bold text-sm sm:text-base">
          <span>Total</span>
          <span class="text-red-600">Rp {{ formatCurrency(order?.total || 42000) }}</span>
        </div>
      </div>

      <!-- Footer -->
      <div class="mt-4 flex flex-col sm:flex-row items-center sm:justify-between gap-2 text-xs sm:text-sm text-gray-600">
        <div class="flex items-center gap-1">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4l6-6m2 2l-6-6" />
          </svg>
          <span>Terima kasih sudah memesan di Warung SE!</span>
        </div>
      </div>

    </div>

  </div>
</template>


<script setup>
import { ref, onMounted } from 'vue'

// Dummy data jika tidak ada order
const defaultItems = [
  { name: 'Ayam Geprek Original', qty: 2, total: 30000 },
  { name: 'Es Teh', qty: 1, total: 3000 },
  { name: 'Es Jeruk', qty: 1, total: 4000 }
]

// Ambil data order dari localStorage
const order = ref(null)
const orderId = Math.floor(Math.random() * 90000) + 10000

onMounted(() => {
  const saved = localStorage.getItem("latestOrder")
  if (saved) {
    order.value = JSON.parse(saved)
  }
})

// Format currency
const formatCurrency = (value) => {
  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0,
  }).format(value).replace('Rp', 'Rp ').replace(',00', '')
}
</script>
