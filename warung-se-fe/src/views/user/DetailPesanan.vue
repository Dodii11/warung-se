<template>
  <div class="max-w-md sm:max-w-lg mx-auto p-4 sm:p-6 bg-white rounded-xl shadow-md mt-8">

    <!-- Header -->
    <div class="flex justify-between items-center mb-4">
      <div>
        <h1 class="text-lg sm:text-xl font-bold text-gray-800">Detail Pesanan</h1>
        <p class="text-xs sm:text-sm text-gray-500">Pesanan #{{ orderId }}</p>
      </div>
      <div class="bg-green-100 rounded-full p-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
      </div>
    </div>

    <!-- Garis Pemisah -->
    <hr class="my-4 border-gray-200" />

    <!-- Detail Pelanggan -->
    <div class="mb-4">
      <h2 class="font-semibold text-gray-800 text-sm sm:text-base mb-2">Detail Pelanggan</h2>
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs sm:text-sm">
        <div>
          <span class="text-gray-600">Nama</span>
          <p class="font-medium">{{ order?.customer.name || 'Edi Jumping' }}</p>
        </div>
        <div>
          <span class="text-gray-600">Nomor Telepon</span>
          <p class="font-medium">{{ order?.customer.phone || '081234567890' }}</p>
        </div>
        <div class="col-span-1 sm:col-span-2">
          <span class="text-gray-600">Alamat</span>
          <p class="font-medium">{{ order?.customer.address || 'JL. Kartika No. 17, Jebres, Surakarta' }}</p>
        </div>
      </div>
    </div>

    <hr class="my-4 border-gray-200" />

    <!-- Ordered Items -->
    <div class="mb-4">
      <h2 class="font-semibold text-gray-800 text-sm sm:text-base mb-2">Ordered Items</h2>
      <div class="space-y-3">
        <div
          v-for="(item, index) in order?.items || defaultItems"
          :key="index"
          class="flex flex-col sm:flex-row items-start sm:items-center gap-3 py-2"
        >
          <img
            :src="item.image"
            :alt="item.name"
            class="w-12 h-12 sm:w-16 sm:h-16 object-cover rounded-md"
          />
          <div class="flex-1">
            <h3 class="font-medium text-gray-900 text-sm sm:text-base">{{ item.name }}</h3>
            <p class="text-xs sm:text-sm text-gray-600">Jumlah: {{ item.qty }}</p>
          </div>
          <p class="font-bold text-red-600 text-sm sm:text-base"> {{ formatCurrency(item.total) }}</p>
        </div>
      </div>
    </div>

    <hr class="my-4 border-gray-200" />

    <!-- Ringkasan Biaya -->
    <div class="mb-4 text-sm sm:text-base">
      <div class="flex justify-between mb-1">
        <span>Subtotal</span>
        <span> {{ formatCurrency(order?.subtotal || 37000) }}</span>
      </div>
      <div class="flex justify-between mb-1">
        <span class="text-gray-600">Biaya Pengiriman</span>
        <span> {{ formatCurrency(order?.shippingFee || 5000) }}</span>
      </div>
      <hr class="my-2 border-gray-300" />
      <div class="flex justify-between font-bold text-base sm:text-lg">
        <span>Total</span>
        <span class="text-red-600"> {{ formatCurrency(order?.total || 42000) }}</span>
      </div>
    </div>

    <!-- Tombol Aksi -->
    <div class="flex flex-col sm:flex-row gap-2 mt-6">
      <button
        class="flex-1 bg-red-600 text-white py-2 rounded-full font-semibold hover:bg-red-700 transition text-sm sm:text-base"
        @click="trackOrder"
      >
        Lacak Pesanan
      </button>
      <button
        class="flex-1 bg-pink-100 text-pink-800 py-2 rounded-full font-semibold hover:bg-pink-200 transition text-sm sm:text-base"
        @click="printReceipt"
      >
        Cetak Struk
      </button>
    </div>

  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

const defaultItems = [
  { name: 'Ayam Geprek Original', qty: 2, total: 30000, image: 'https://placehold.co/60x60/png?text=ayam' },
  { name: 'Mie Kuah Pedas', qty: 1, total: 3000, image: 'https://placehold.co/60x60/png?text=mie' },
  { name: 'Es Teh', qty: 1, total: 4000, image: 'https://placehold.co/60x60/png?text=es' }
]

const order = ref(null)
const orderId = Math.floor(Math.random() * 90000) + 10000

onMounted(() => {
  const saved = localStorage.getItem("latestOrder")
  if (saved) order.value = JSON.parse(saved)
})

const formatCurrency = (value) => {
  return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 })
    .format(value).replace('Rp', 'Rp ').replace(',00', '')
}

function trackOrder() {
  alert("Fitur Lacak Pesanan akan segera hadir!")
}

function printReceipt() {
  router.push('/struk')
}
</script>
