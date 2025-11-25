<template>
  <div class="max-w-6xl mx-auto p-4 sm:p-6">

    <!-- Judul -->
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Keranjang Anda</h1>

    <!-- Kontainer Utama -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

      <!-- Daftar Item -->
      <div class="md:col-span-2 space-y-4">
        <div
          v-for="(item, index) in cartItems"
          :key="index"
          class="flex flex-col sm:flex-row sm:items-center gap-4 p-4 bg-white rounded-lg shadow-sm"
        >
          <!-- Gambar -->
          <img
            :src="item.image"
            alt="Item Image"
            class="w-full sm:w-16 h-16 object-cover rounded-md"
          />

          <!-- Detail -->
          <div class="flex-1 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2 w-full">
            <div>
              <h3 class="font-semibold text-gray-900">{{ item.name }}</h3>
              <p class="text-gray-600">Rp {{ item.price }}</p>
            </div>

            <!-- Quantity + Hapus -->
            <div class="flex items-center gap-2 mt-2 sm:mt-0">
              <div class="flex items-center border border-gray-300 rounded-md overflow-hidden">
                <button
                  class="px-2 py-1 text-gray-600 hover:bg-gray-200 transition"
                  @click="decrementQty(index)"
                  :disabled="item.qty <= 1"
                >-</button>
                <input
                  type="number"
                  v-model.number="item.qty"
                  min="1"
                  max="99"
                  class="w-10 text-center outline-none"
                />
                <button
                  class="px-2 py-1 text-gray-600 hover:bg-gray-200 transition"
                  @click="incrementQty(index)"
                >+</button>
              </div>

              <button
                class="text-red-600 hover:text-red-800 text-sm font-medium"
                @click="removeItem(index)"
              >
                del
              </button>
            </div>

            <!-- Harga Total -->
            <p class="font-bold text-gray-900 mt-2 sm:mt-0">Rp {{ item.total }}</p>
          </div>
        </div>

        <!-- Jika keranjang kosong -->
        <div v-if="cartItems.length === 0" class="text-center py-10 text-gray-500">
          Keranjang Anda masih kosong.
        </div>
      </div>

      <!-- Ringkasan Pesanan -->
      <div class="bg-white rounded-lg shadow-sm p-6 w-full">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Ringkasan Pesanan</h2>

        <div class="space-y-3">
          <div class="flex justify-between">
            <span>Subtotal</span>
            <span>Rp {{ formatCurrency(subtotal) }}</span>
          </div>
          <div class="flex justify-between">
            <span>Biaya Pengiriman</span>
            <span>Rp {{ formatCurrency(shippingFee) }}</span>
          </div>
          <div class="flex justify-between">
            <span>PPN</span>
            <span>Rp {{ formatCurrency(ppn) }}</span>
          </div>
          <hr class="my-3 border-gray-200" />
          <div class="flex justify-between font-bold text-xl">
            <span>Total</span>
            <span>Rp {{ formatCurrency(total) }}</span>
          </div>
        </div>

        <!-- Tombol Checkout -->
        <button
          @click="proceedToCheckout"
          class="w-full mt-6 bg-red-600 text-white py-3 rounded-full font-semibold hover:bg-red-700 transition"
        >
          Lanjutkan ke Pembayaran
        </button>
      </div>
    </div>
  </div>
</template>


<script setup>
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

// Dummy data keranjang
const cartItems = ref([
  { name: "Ayam Geprek Original", price: 15000, qty: 2, image: "https://placehold.co/100x100/png?text=/ayam" },
  { name: "Es Teh", price: 3000, qty: 1, image: "https://placehold.co/100x100/png?text=es+teh" },
  { name: "Es Jeruk", price: 4000, qty: 1, image: "https://placehold.co/100x100/png?text=es+jeruk" },
])

// Hitung total per item
cartItems.value.forEach(item => {
  item.total = item.price * item.qty
})

// Hitung subtotal, biaya pengiriman, ppn, total
const subtotal = computed(() => cartItems.value.reduce((sum, item) => sum + item.price * item.qty, 0))
const shippingFee = computed(() => 5000)
const ppn = computed(() => 0)
const total = computed(() => subtotal.value + shippingFee.value + ppn.value)

// Format currency
const formatCurrency = (value) => {
  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0,
  }).format(value).replace('Rp', 'Rp ').replace(',00', '')
}

// Update quantity
function incrementQty(index) {
  cartItems.value[index].qty++
  cartItems.value[index].total = cartItems.value[index].price * cartItems.value[index].qty
}
function decrementQty(index) {
  if (cartItems.value[index].qty > 1) {
    cartItems.value[index].qty--
    cartItems.value[index].total = cartItems.value[index].price * cartItems.value[index].qty
  }
}

// Hapus item
function removeItem(index) {
  cartItems.value.splice(index, 1)
}

// **Navigasi ke FormDetailPesanan terlebih dahulu**
function proceedToCheckout() {
  router.push({ name: 'FormDetailPesanan' })
}

</script>
