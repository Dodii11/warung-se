<template>
  <div class="max-w-4xl mx-auto p-4 sm:p-6 lg:p-8 bg-gray-50 min-h-screen">
    <h1 class="text-3xl font-extrabold text-gray-900 mb-8 flex items-center gap-3">
      <ShoppingCart class="w-7 h-7 text-red-600" />
      Keranjang Anda
    </h1>

    <!-- Daftar Item -->
    <div v-if="cartItems.length > 0" class="space-y-4">
<UserAppCard padding="sm" v-for="(item, index) in cartItems" :key="index">
  <!-- Flex Utama -->
  <div class="flex flex-col sm:flex-row sm:flex-nowrap flex-wrap gap-4 w-full">

    <!-- ===== KOLOM 1 — Gambar + Nama Produk ===== -->
    <div class="flex items-start gap-3 sm:gap-4 flex-1 min-w-0 sm:w-1/2">
      <img
        :src="item.image"
        alt="Item Image"
        class="w-16 sm:w-20 h-16 sm:h-20 object-cover rounded-xl border border-gray-100 shrink-0"
      />

      <!-- Nama Produk & Harga -->
      <div class="flex-1 min-w-0">
        <!-- Nama Produk -->
        <h3
          class="font-bold text-base sm:text-lg text-gray-900 leading-tight line-clamp-2 break-words"
        >
          {{ item.name }}
        </h3>

        <!-- Harga satuan (now fully visible at small screens) -->
        <p class="text-red-600 font-semibold mt-1 text-sm break-words min-w-0 w-full leading-snug">
          Harga Satuan: {{ formatCurrency(item.price) }}
        </p>
      </div>
    </div>

    <!-- ===== KOLOM 2 — Quantity Control ===== -->
    <div
      class="flex items-center gap-2 shrink sm:shrink-0 mt-2 sm:mt-0 sm:justify-center sm:w-1/4"
    >
      <button
        class="p-1.5 sm:p-2 text-gray-600 hover:bg-red-100 hover:text-red-600 rounded-lg transition disabled:opacity-50"
        @click="decrementQty(index)"
        :disabled="item.qty <= 1"
      >
        <Minus class="w-3.5 sm:w-4 h-3.5 sm:h-4" />
      </button>

      <input
        type="number"
        v-model.number="item.qty"
        min="1"
        max="99"
        class="w-10 sm:w-12 text-center text-sm sm:text-base font-semibold border-b border-gray-300 outline-none p-1 focus:border-red-600 bg-transparent"
        @change="updateItemTotal(index)"
      />

      <button
        class="p-1.5 sm:p-2 text-gray-600 hover:bg-red-100 hover:text-red-600 rounded-lg transition"
        @click="incrementQty(index)"
      >
        <Plus class="w-3.5 sm:w-4 h-3.5 sm:h-4" />
      </button>
    </div>

    <!-- ===== KOLOM 3 — Total & Delete (Desktop) ===== -->
    <div
      class="hidden sm:flex sm:w-1/4 justify-end items-center mt-3 sm:mt-0 shrink"
    >
      <div class="text-right shrink min-w-0 mr-4">
        <p class="text-sm text-gray-500 whitespace-nowrap">Total Item:</p>
        <p class="font-extrabold text-xl text-red-700 break-words">
          {{ formatCurrency(item.total) }}
        </p>
      </div>

      <button
        class="p-2 text-gray-400 hover:text-red-600 rounded-full bg-white transition hover:bg-red-50 shadow-sm hover:shadow-md shrink-0"
        @click="removeItem(index)"
      >
        <Trash2 class="w-5 h-5" />
      </button>
    </div>

    <!-- ===== KOLOM 3 — Total & Delete (Mobile) ===== -->
    <div
      class="sm:hidden w-full flex justify-between items-center pt-3 border-t border-gray-100 mt-2"
    >
      <div class="text-left min-w-0">
        <p class="text-sm text-gray-500">Total Item:</p>
        <p class="font-extrabold text-lg text-red-700 break-words">
          {{ formatCurrency(item.total) }}
        </p>
      </div>

      <button
        class="p-2 text-gray-400 hover:text-red-600 rounded-full bg-white transition hover:bg-red-50 shadow-sm hover:shadow-md shrink-0"
        @click="removeItem(index)"
      >
        <Trash2 class="w-5 h-5" />
      </button>
    </div>

  </div>
</UserAppCard>



      <!-- Subtotal dan Tombol Checkout -->
      <div class="pt-6 mt-6 flex flex-col-reverse sm:flex-row sm:justify-end sm:items-center gap-4 sm:gap-6 bg-white p-5 sm:p-6 rounded-2xl shadow-lg border border-gray-100">
        <div class="text-right w-full sm:w-auto">
          <p class="text-lg sm:text-xl font-semibold text-gray-700">Subtotal Belanja:</p>
          <p class="font-extrabold text-2xl sm:text-3xl text-red-600">{{ formatCurrency(subtotal) }}</p>
        </div>

        <UserAppButton
          @click="proceedToCheckout"
          size="lg"
          :disabled="cartItems.length === 0"
          class="w-full sm:w-auto"
        >
          Lanjutkan ke Pembayaran
          <template #icon-right>
            <ArrowRight class="w-5 h-5" />
          </template>
        </UserAppButton>
      </div>
    </div>

    <!-- Jika keranjang kosong -->
    <div v-else class="text-center py-12 sm:py-16 bg-white rounded-2xl shadow-lg border border-gray-100 px-4">
      <ShoppingBag class="w-12 h-12 mx-auto text-red-400 mb-4" />
      <p class="text-lg sm:text-xl font-semibold text-gray-700 mb-2">Keranjang Anda masih kosong.</p>
      <p class="text-gray-500">Ayo mulai belanja dan tambahkan produk favorit Anda!</p>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'
import { Trash2, Minus, Plus, ShoppingCart, ArrowRight, ShoppingBag } from 'lucide-vue-next'
// Menggunakan impor relatif agar komponen dapat berjalan di lingkungan ini.
// Catatan: Karena saya tidak memiliki definisi UserAppCard dan UserAppButton, saya asumsikan ia ada di path ini.
import UserAppCard from '@/components/baseUser/UserAppCard.vue'
import UserAppButton from '@/components/baseUser/UserAppButton.vue'

const router = useRouter()

// --- Data & State ---
// Dummy data keranjang. Gunakan ref() agar reaktif.
const cartItems = ref([
  { id: 1, name: "Ayam Geprek Original Sambal Matah", price: 18000, qty: 2, image: "https://placehold.co/100x100/fecaca/991b1b?text=Ayam" },
  { id: 2, name: "Es Teh Manis Jumbo", price: 3000, qty: 1, image: "https://placehold.co/100x100/fecaca/991b1b?text=Es+Teh" },
  { id: 3, name: "Nasi Putih Extra", price: 5000, qty: 3, image: "https://placehold.co/100x100/fecaca/991b1b?text=Nasi" },
])

// Hitung total awal per item
cartItems.value.forEach(item => {
  item.total = item.price * item.qty
})

// --- Computed Properties ---
const subtotal = computed(() => {
  return cartItems.value.reduce((sum, item) => sum + item.price * item.qty, 0)
})

// Format currency
const formatCurrency = (value) => {
  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0,
  }).format(value).replace('Rp', 'Rp ').replace(',00', '')
}

// --- Methods ---

function updateItemTotal(index) {
  const item = cartItems.value[index]
  // Pastikan kuantitas adalah angka positif
  if (item.qty < 1 || isNaN(item.qty)) {
    item.qty = 1
  } else if (item.qty > 99) {
    item.qty = 99
  }
  item.total = item.price * item.qty
}

function incrementQty(index) {
  if (cartItems.value[index].qty < 99) {
    cartItems.value[index].qty++
    updateItemTotal(index)
  }
}

function decrementQty(index) {
  if (cartItems.value[index].qty > 1) {
    cartItems.value[index].qty--
    updateItemTotal(index)
  }
}

function removeItem(index) {
  cartItems.value.splice(index, 1)
}

// Navigasi ke FormDetailPesanan dan Simpan Data Keranjang
function proceedToCheckout() {
  if (cartItems.value.length === 0) return

  // Simpan data penting ke localStorage sebelum navigasi
  const cartData = {
    items: cartItems.value.map(item => ({
      id: item.id,
      name: item.name,
      price: item.price,
      qty: item.qty,
      total: item.total
    })),
    subtotal: subtotal.value,
  }

  localStorage.setItem("checkoutCartData", JSON.stringify(cartData))

  // Navigasi ke halaman detail pesanan
  // Catatan: Asumsi rute 'FormDetailPesanan' sudah terdaftar di router Anda
  router.push({ name: 'FormDetailPesanan' })
}
</script>
<style scoped>
/* Menghilangkan panah spinner pada input number */
input[type="number"]::-webkit-outer-spin-button,
input[type="number"]::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
input[type="number"] {
    -moz-appearance: textfield;
}
</style>
