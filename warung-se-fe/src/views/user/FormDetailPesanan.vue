<template>
  <div class="max-w-md sm:max-w-lg mx-auto p-4 sm:p-6 bg-white rounded-xl shadow-md mt-8">

    <!-- Judul -->
    <h1 class="text-xl sm:text-2xl font-bold text-gray-800 mb-1 text-center sm:text-left">Lengkapi Detail Pesanan</h1>
    <p class="text-xs sm:text-sm text-gray-600 mb-6 text-center sm:text-left">Pastikan data yang Anda masukkan sudah benar.</p>

    <!-- Form -->
    <form @submit.prevent="submitOrder" class="space-y-4">

      <!-- Nama Lengkap -->
      <div>
        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
        <input
          id="name"
          v-model="formData.name"
          type="text"
          placeholder="Contoh: Budi Santoso"
          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm sm:text-base"
          required
        />
      </div>

      <!-- Nomor Telepon -->
      <div>
        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
        <input
          id="phone"
          v-model="formData.phone"
          type="tel"
          placeholder="Contoh: 081234567890"
          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm sm:text-base"
          required
        />
      </div>

      <!-- Alamat Lengkap -->
      <div>
        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
        <textarea
          id="address"
          v-model="formData.address"
          rows="3"
          placeholder="Contoh: Jl. Raya Ngawi Selatan No. 123, RT 05/RW 02, Kec. Ngawi, Kab. Ngawi, Jawa Timur"
          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm sm:text-base"
          required
        ></textarea>
      </div>

      <!-- Catatan Tambahan (Opsional) -->
      <div>
        <label for="note" class="block text-sm font-medium text-gray-700 mb-1">Catatan Tambahan (Opsional)</label>
        <textarea
          id="note"
          v-model="formData.note"
          rows="2"
          placeholder="Contoh: Tolong kirim sebelum jam 18.00, atau tambahkan sambal extra."
          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm sm:text-base"
        ></textarea>
      </div>

      <!-- Tombol Kirim Pesanan -->
      <button
        type="submit"
        class="w-full bg-red-600 text-white py-3 rounded-full font-semibold hover:bg-red-700 transition disabled:opacity-70 disabled:cursor-not-allowed text-sm sm:text-base"
        :disabled="!isFormValid"
      >
        Kirim Pesanan
      </button>

    </form>

    <!-- Alert sukses -->
    <div v-if="showSuccess" class="mt-4 p-3 bg-green-100 text-green-800 rounded-md text-sm text-center sm:text-left">
      🎉 Pesanan Anda berhasil dikirim! Kami akan segera memprosesnya.
    </div>

  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

// State form
const formData = ref({
  name: '',
  phone: '',
  address: '',
  note: '',
})

// Validasi form
const isFormValid = computed(() =>
  formData.value.name.trim() !== '' &&
  formData.value.phone.trim() !== '' &&
  formData.value.address.trim() !== ''
)

// Alert sukses
const showSuccess = ref(false)

// Submit pesanan
function submitOrder() {
  if (!isFormValid.value) return

  showSuccess.value = true

  const orderData = {
    customer: {
      name: formData.value.name,
      phone: formData.value.phone,
      address: formData.value.address,
      note: formData.value.note,
    },
    items: [
      { name: "Ayam Geprek", qty: 1, total: 15000 },
      { name: "Es Teh", qty: 1, total: 3000 }
    ],
    subtotal: 18000,
    shippingFee: 5000,
    total: 23000
  }

  localStorage.setItem("latestOrder", JSON.stringify(orderData))

  setTimeout(() => {
    router.push({ name: "DetailPesanan" })
  }, 600)
}
</script>
