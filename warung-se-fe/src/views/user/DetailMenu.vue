<template>
  <div class="max-w-5xl mx-auto p-4 sm:p-6">

    <!-- 🔥 Pop-up Notifikasi Floating Tengah -->
<!-- Floating Notification -->
<transition name="popup">
  <div
    v-if="showNotif"
    class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 
           bg-white shadow-xl rounded-xl px-6 py-4 text-center z-50 
           border border-gray-200 w-[85%] max-w-xs sm:max-w-sm">
    
    <p class="text-green-600 text-xl font-bold mb-1">✓</p>
    <p class="text-gray-800 font-medium text-sm sm:text-base">{{ notifMessage }}</p>
  </div>
</transition>



    <!-- Breadcrumb -->
    <nav class="text-sm text-gray-600 mb-4">
      <router-link to="/menu" class="hover:text-red-600">Menu</router-link>
      <span class="mx-2">/</span>
      <span class="font-medium">{{ menu?.name || 'Loading...' }}</span>
    </nav>

    <!-- Kontainer -->
    <div
      v-if="menu"
      class="bg-gray-50 rounded-lg shadow-md flex flex-col md:flex-row gap-6 p-4 sm:p-6">

      <!-- Gambar -->
      <div class="flex flex-col gap-4 w-full md:w-96">
        <img :src="currentImage" class="w-full h-64 sm:h-80 object-cover rounded-lg shadow-md" />

        <div class="flex gap-2 overflow-x-auto">
          <img v-for="(img,i) in dummyImages.slice(0,3)"
            :key="i"
            :src="img"
            @click="currentImage = img"
            class="w-20 h-20 rounded-md cursor-pointer border-2 transition object-cover"
            :class="currentImage === img ? 'border-red-600' : 'border-transparent'" />
        </div>
      </div>

      <!-- Info -->
      <div class="flex-1 flex flex-col mt-4 md:mt-0">
        <h1 class="text-2xl font-extrabold text-gray-900 mb-1">{{ menu.name }}</h1>
        <p class="text-red-600 font-bold text-xl mb-3">Rp {{ menu.price }}</p>
        <p class="text-gray-700 mb-6">{{ menu.descDetail }}</p>

        <!-- Kategori -->
        <div class="mb-4">
          <p class="font-semibold text-gray-900 mb-1">Kategori</p>
          <div class="flex items-center gap-2 text-gray-700">
            <span class="w-4 h-4 rounded-full bg-red-600"></span>
            {{ menu.category }}
          </div>
        </div>

        <!-- Stok -->
        <div class="mb-6">
          <p class="font-semibold text-gray-900 mb-1">Stok</p>
          <p class="text-gray-700">{{ menu.stock }}</p>
        </div>

        <!-- Qty + Button -->
        <div class="flex flex-col sm:flex-row sm:items-center gap-3 mt-auto">
          <div class="flex items-center border border-gray-300 rounded-md overflow-hidden">
            <button @click="decrementQty" :disabled="qty<=1" class="px-3 py-1 hover:bg-gray-200">-</button>
            <input v-model.number="qty" type="number" min="1" class="w-12 text-center outline-none" />
            <button @click="incrementQty" :disabled="qty>=menu.stock" class="px-3 py-1 hover:bg-gray-200">+</button>
          </div>

          <button @click="addToCart" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-full w-full sm:w-auto">
            Tambahkan ke Keranjang
          </button>
        </div>
      </div>
    </div>

    <div v-else class="text-center text-gray-500 mt-12">Menu tidak ditemukan.</div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import { useRoute } from 'vue-router'

const menus = [
  { name: 'Ayam Geprek Original', price: '15.000', descDetail: 'Ayam Geprek Original...', category: 'Ayam', stock: 15 },
  { name: 'Ayam Geprek Sambal Matah', price: '20.000', descDetail: 'Ayam Geprek Sambal Matah...', category: 'Ayam', stock: 10 },
  { name: 'Ayam Geprek Keju', price: '24.000', descDetail: 'Ayam Geprek Keju...', category: 'Ayam', stock: 8 }
]

const dummyImages = [
  'https://placehold.co/300x200/png?text=Image+1',
  'https://placehold.co/300x200/png?text=Image+2',
  'https://placehold.co/300x200/png?text=Image+3'
]

const route = useRoute()
const menu = ref(null)
const qty = ref(1)
const currentImage = ref(dummyImages[0])

// Notifikasi
const showNotif = ref(false)
const notifMessage = ref("")

function incrementQty() {
  if (qty.value < menu.value.stock) qty.value++
}
function decrementQty() {
  if (qty.value > 1) qty.value--
}

function addToCart() {
  notifMessage.value = `${qty.value} x ${menu.value.name} berhasil ditambahkan!`
  showNotif.value = true
  
  setTimeout(() => {
    showNotif.value = false
  }, 1000)
}


function loadMenu() {
  menu.value = menus.find(m => m.name === decodeURIComponent(route.params.name)) ?? null
}

watch(() => route.params.name, loadMenu, { immediate: true })
</script>

<style>
/* 🎬 Animasi notifikasi */
.popup-enter-active, .popup-leave-active {
  transition: all 0.35s ease;
}
.popup-enter-from, .popup-leave-to {
  opacity: 0;
  transform: scale(0.85);
}
.popup-enter-active, .popup-leave-active {
  transition: all 0.3s ease;
}
.popup-enter-from, .popup-leave-to {
  opacity: 0;
  transform: translate(-50%, -50%) scale(0.85);
}

</style>
