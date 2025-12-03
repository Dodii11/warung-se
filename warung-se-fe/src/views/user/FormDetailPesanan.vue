<template>
  <div class="max-w-4xl mx-auto p-4 sm:p-6 lg:p-8 bg-gray-50 min-h-screen">
    <h1 class="text-3xl font-extrabold text-gray-900 mb-8 flex items-center gap-3">
      <CreditCard class="w-7 h-7 text-red-600" />
      Langkah Terakhir: Detail Pesanan
    </h1>

    <div class="grid grid-cols-1 md:grid-cols-5 gap-8">
      <!-- Kolom Kiri: Formulir Detail Pelanggan (3/5) -->
      <div class="md:col-span-3">
        <UserAppCard padding="lg">
          <h2 class="text-xl font-bold text-gray-800 mb-6 border-b pb-3 flex items-center gap-2">
            <User class="w-5 h-5" />
            Detail Pengiriman
          </h2>
          <form @submit.prevent="submitOrder" class="space-y-5">
            <UserAppInput
              label="Nama Lengkap"
              placeholder="Contoh: Budi Santoso"
              v-model="formData.name"
              type="text"
              :error="validationErrors.name"
            />

            <UserAppInput
              label="Nomor Telepon (Aktif)"
              placeholder="Contoh: 081234567890"
              v-model="formData.phone"
              type="tel"
              :error="validationErrors.phone"
            />

            <div>
              <label for="address" class="block text-sm font-medium text-gray-700 tracking-wide mb-1.5">
                Alamat Lengkap
              </label>
              <textarea
                id="address"
                v-model="formData.address"
                rows="3"
                placeholder="Jl. Raya Ngawi Selatan No. 123, RT/RW, Kecamatan, Kota"
                class="w-full px-4 py-2.5 rounded-lg text-sm transition-all border border-gray-300 outline-none focus:ring-2 focus:ring-offset-1 focus:ring-red-500 focus:border-transparent"
                :class="{ 'border-red-500 focus:ring-red-500': validationErrors.address }"
              ></textarea>
              <p v-if="validationErrors.address" class="text-xs text-red-500 mt-0.5 font-medium">
                {{ validationErrors.address }}
              </p>
            </div>

            <div>
              <label for="note" class="block text-sm font-medium text-gray-700 tracking-wide mb-1.5">
                Catatan Tambahan (Opsional)
              </label>
              <textarea
                id="note"
                v-model="formData.note"
                rows="2"
                placeholder="Contoh: Tolong kirim sebelum jam 18.00, atau tambahkan sambal extra."
                class="w-full px-4 py-2.5 rounded-lg text-sm transition-all border border-gray-300 outline-none focus:ring-2 focus:ring-offset-1 focus:ring-red-500 focus:border-transparent"
              ></textarea>
            </div>

            <UserAppButton
              type="submit"
              size="lg"
              class="w-full mt-6"
              :disabled="!isFormValid || loading"
              :loading="loading"
            >
              Kirim Pesanan & Bayar {{ formatCurrency(total) }}
              <template #icon-right>
                <Send class="w-5 h-5" />
              </template>
            </UserAppButton>
          </form>
        </UserAppCard>
      </div>

      <!-- Kolom Kanan: Ringkasan Pesanan (2/5) -->
      <div class="md:col-span-2 space-y-5">
        <UserAppCard>
          <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-3 flex items-center gap-2">
            <Receipt class="w-5 h-5" />
            Ringkasan Pesanan
          </h2>

          <!-- Detail Perhitungan Harga (dalam space-y-3) -->
          <div class="space-y-3 text-sm text-gray-700">
            <!-- Rincian Item -->
            <div v-for="item in cartItems" :key="item.id" class="flex justify-between items-start">
              <span class="text-gray-600 pr-2 flex-grow min-w-0">{{ item.name }} ({{ item.qty }}x)</span>
              <span class="font-medium text-gray-800 flex-shrink-0 whitespace-nowrap">{{ formatCurrency(item.total) }}</span>
            </div>

            <hr class="my-3 border-gray-200" />

            <!-- Subtotal -->
            <div class="flex justify-between font-semibold">
              <span class="flex-grow min-w-0">Subtotal Produk</span>
              <span class="flex-shrink-0 whitespace-nowrap">{{ formatCurrency(subtotal) }}</span>
            </div>

            <!-- Biaya Pengiriman -->
            <div class="flex justify-between">
              <span class="flex-grow min-w-0">Biaya Pengiriman <Truck class="w-4 h-4 inline ml-1 text-red-500" /></span>
              <span class="font-semibold flex-shrink-0 whitespace-nowrap">{{ formatCurrency(shippingFee) }}</span>
            </div>

            <!-- PPN (Jika ada) -->
            <div class="flex justify-between">
              <span class="flex-grow min-w-0">Pajak (PPN 0%)</span>
              <span class="font-semibold flex-shrink-0 whitespace-nowrap">{{ formatCurrency(ppn) }}</span>
            </div>
          </div>

          <!-- Total Akhir (Paling Kritis) - Dibuat terpisah dan menonjol -->
          <div class="mt-6 pt-4 border-t-2 border-red-500/20">
            <div class="flex justify-between items-center p-4 rounded-xl bg-red-50 border border-red-200 shadow-lg">
              <span class="text-xl font-extrabold text-red-800">TOTAL PEMBAYARAN</span>
              <span class="text-3xl font-black text-red-700 flex-shrink-0 whitespace-nowrap">
                {{ formatCurrency(total) }}
              </span>
            </div>
          </div>
        </UserAppCard>

        <div class="text-center p-3 text-xs text-gray-500">
          Pastikan Anda telah memeriksa detail keranjang <span class="text-red-500 cursor-pointer hover:underline" @click="goBackToCart">(Ubah Keranjang)</span> sebelum mengirim pesanan.
        </div>
      </div>
    </div>

    <!-- MODAL DETAIL PESANAN -->
    <UserAppModal :show="showOrderModal" @close="showOrderModal = false" size="lg">
        <DetailPesanan
            :order-data="latestOrderData"
            :order-id="latestOrderId"
            @close="showOrderModal = false"
        />
    </UserAppModal>

  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { User, Truck, Receipt, CreditCard, Send } from 'lucide-vue-next'
import UserAppCard from '@/components/baseUser/UserAppCard.vue'
import UserAppInput from '@/components/baseUser/UserAppInput.vue'
import UserAppButton from '@/components/baseUser/UserAppButton.vue'

// Import komponen baru
import UserAppModal from '@/components/baseUser/UserAppModal.vue'
import DetailPesanan from '@/views/user/DetailPesanan.vue'



// --- State Formulir ---
const formData = ref({
  name: '',
  phone: '',
  address: '',
  note: '',
})
const loading = ref(false)
const validationErrors = ref({})

// --- State Modal & Data Pesanan Terbaru ---
const showOrderModal = ref(false)
const latestOrderData = ref(null)
const latestOrderId = ref(null)

// --- State Data Pesanan dari CartPage (localStorage) ---
const cartItems = ref([])
const subtotal = ref(0)
const shippingFee = ref(5000) // Contoh biaya pengiriman tetap
const ppnRate = 0 // 0% PPN
const ppn = computed(() => subtotal.value * ppnRate)
const total = computed(() => subtotal.value + shippingFee.value + ppn.value)


// --- Lifecycle Hooks ---
onMounted(() => {
  loadCartData()
})

// --- Methods ---

function loadCartData() {
  const data = localStorage.getItem("checkoutCartData")
  if (data) {
    try {
      const parsedData = JSON.parse(data)
      cartItems.value = parsedData.items || []
      subtotal.value = parsedData.subtotal || 0

      if (cartItems.value.length === 0) {
        console.error("Cart data is empty. Redirecting to cart.")
        // router.replace({ name: 'CartPage' }) // Gunakan replace agar tidak kembali ke form kosong
      }

    } catch (e) {
      console.error("Failed to parse cart data from localStorage:", e)
      // router.replace({ name: 'CartPage' })
    }
  } else {
    console.error("No cart data found in localStorage. Redirecting to cart.")
    // router.replace({ name: 'CartPage' })
  }
}

function validateForm() {
  validationErrors.value = {}
  let isValid = true

  if (!formData.value.name.trim()) {
    validationErrors.value.name = 'Nama lengkap wajib diisi.'
    isValid = false
  }
  if (!formData.value.phone.trim()) {
    validationErrors.value.phone = 'Nomor telepon wajib diisi.'
    isValid = false
  }
  if (!formData.value.address.trim()) {
    validationErrors.value.address = 'Alamat lengkap wajib diisi.'
    isValid = false
  }
  return isValid
}

function goBackToCart() {
    // router.push({ name: 'CartPage' })
    console.log("Navigasi ke halaman Keranjang.")
}

function submitOrder() {
  if (!validateForm() || loading.value) return

  loading.value = true

  const newOrderId = Math.floor(Math.random() * 90000) + 10000;

  const orderData = {
    customer: {
      name: formData.value.name,
      phone: formData.value.phone,
      address: formData.value.address,
      note: formData.value.note,
    },
    items: cartItems.value,
    subtotal: subtotal.value,
    shippingFee: shippingFee.value,
    total: total.value,
    date: new Date().toISOString(),
    id: newOrderId // Tambahkan ID ke data
  }

  // Simpan data order final (untuk simulasi)
  localStorage.setItem("latestOrder", JSON.stringify(orderData))

  // Simulasikan proses pengiriman/pembayaran
  setTimeout(() => {
    loading.value = false

    // 1. Simpan data ke state lokal
    latestOrderData.value = orderData
    latestOrderId.value = newOrderId

    // 2. Tampilkan modal detail pesanan
    showOrderModal.value = true

    // Opsional: Hapus data keranjang dari localStorage setelah sukses
    localStorage.removeItem("checkoutCartData")

  }, 1500)
}

// Format currency
const formatCurrency = (value) => {
  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0,
  }).format(value).replace('Rp', 'Rp ').replace(',00', '')
}

// --- Computed Properties ---
const isFormValid = computed(() => {
  return formData.value.name.trim() !== '' &&
    formData.value.phone.trim() !== '' &&
    formData.value.address.trim() !== ''
})
</script>
