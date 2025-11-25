<template>
  <div class="min-h-screen bg-gray-100">
    <!-- Header -->
    <header class="bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center">
      <div class="flex items-center space-x-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
        </svg>
        <span class="text-gray-800 font-medium">Kembali</span>
      </div>

      <div class="flex items-center space-x-6">
        <button 
          @click="logout"
          class="bg-red-100 text-red-700 px-4 py-2 rounded-full text-sm font-medium hover:bg-red-200 transition-colors">
          Logout
        </button>
        <div class="flex items-center space-x-2"></div>
      </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-6 py-8">
      <h1 class="text-2xl font-bold text-gray-800 mb-6">Akun Saya</h1>

      <!-- Tab Navigation -->
      <div class="border-b border-gray-300 mb-6">
        <div class="flex space-x-6">
          <button 
            @click="activeTab = 'profile'" 
            :class="['pb-2 px-1 font-medium text-sm', activeTab === 'profile' ? 'text-red-600 border-b-2 border-red-600' : 'text-gray-600']">
            Profil
          </button>
          <button 
            @click="activeTab = 'messages'" 
            :class="['pb-2 px-1 font-medium text-sm', activeTab === 'messages' ? 'text-red-600 border-b-2 border-red-600' : 'text-gray-600']">
            Pesanan
          </button>
        </div>
      </div>

      <!-- Profile Tab Content -->
      <div v-if="activeTab === 'profile'" class="space-y-8">
        <!-- Personal Information Section -->
        <div class="grid md:grid-cols-2 gap-8">
          <div>
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Informasi Pribadi</h2>
            
            <div class="space-y-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                <input 
                  type="text" 
                  v-model="profile.name"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                  placeholder="Edi Geyming"
                >
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input 
                  type="email" 
                  v-model="profile.email"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                  placeholder="EdiGeyming@Gmail.com"
                >
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor telepon</label>
                <input 
                  type="tel" 
                  v-model="profile.phone"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                  placeholder="+6281-2345-67890"
                >
              </div>

              <button 
                @click="saveProfileChanges"
                class="mt-4 px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors font-medium">
                Simpan Perubahan
              </button>
            </div>
          </div>

          <div>
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Alamat Rumah</h2>
            
            <div class="space-y-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Jalan</label>
                <input 
                  type="text" 
                  v-model="address.street"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                  placeholder="Jepara, RT18 RW05 JI.Pandawa"
                >
              </div>

              <div class="grid grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Kecamatan/Kota</label>
                  <input 
                    type="text" 
                    v-model="address.district"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                    placeholder="Jepara"
                  >
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Kabupaten</label>
                  <input 
                    type="text" 
                    v-model="address.regency"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                    placeholder="Jepara"
                  >
                </div>
              </div>

              <div class="grid grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Provinsi</label>
                  <input 
                    type="text" 
                    v-model="address.province"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                    placeholder="Jawa Tengah"
                  >
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Kode Pos</label>
                  <input 
                    type="text" 
                    v-model="address.postalCode"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                    placeholder="12345"
                  >
                </div>
              </div>

              <button 
                @click="saveAddressChanges"
                class="mt-4 px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors font-medium">
                Simpan Perubahan
              </button>
            </div>
          </div>
        </div>

        <!-- Change Password Section -->
        <div class="pt-8 border-t border-gray-300">
          <h2 class="text-xl font-semibold text-gray-800 mb-4">Ubah Kata Sandi</h2>
          
          <div class="max-w-md space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi Saat Ini</label>
              <input 
                type="password" 
                v-model="password.current"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                placeholder="Masukkan kata sandi Anda saat ini"
              >
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi Baru</label>
              <input 
                type="password" 
                v-model="password.new"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                placeholder="Masukkan kata sandi baru Anda"
              >
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Kata Sandi Baru</label>
              <input 
                type="password" 
                v-model="password.confirm"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                placeholder="Konfirmasikan kata sandi baru Anda"
              >
            </div>

            <div class="flex space-x-2 pt-2">
              <button 
                @click="savePasswordChanges"
                class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors font-medium">
                Simpan Perubahan
              </button>
              <button 
                @click="saveAllChanges"
                class="px-4 py-2 bg-red-100 text-red-700 rounded-md hover:bg-red-200 transition-colors font-medium">
                Simpan Semua Perubahan
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Messages Tab -->
      <div v-if="activeTab === 'messages'" class="py-8">
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
          <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-800">Status Pesanan Saat Ini</h2>
            <span class="text-gray-600 font-medium">Pesanan #12346</span>
          </div>

          <div class="w-full bg-gray-200 rounded-full h-2 mb-4">
            <div class="bg-red-600 h-2 rounded-full" style="width: 50%"></div>
          </div>

          <div class="flex justify-between text-xs font-medium">
            <div class="text-red-600">Pesanan Dikonfirmasi</div>
            <div class="text-red-600">Preparing Food</div>
            <div class="text-gray-500">Dalam perjalanan</div>
            <div class="text-gray-500">Terkirim</div>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">PESANAN #</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">TANGGAL</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">BARANG</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">TOTAL</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">STATUS</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">AKSI</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="order in orders" :key="order.id" class="hover:bg-gray-50">
                  <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ order.orderNumber }}</td>
                  <td class="px-6 py-4 text-sm text-gray-500">{{ order.date }}</td>
                  <td class="px-6 py-4 text-sm text-gray-500">{{ order.items }} Barang</td>
                  <td class="px-6 py-4 text-sm text-gray-500">{{ order.total }}</td>
                  <td class="px-6 py-4">
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">{{ order.status }}</span>
                  </td>
                  <td class="px-6 py-4 text-sm font-medium">
                    <button @click="printReceipt(order.id)" class="text-red-600 hover:text-red-900">Cetak Resi</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </main>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/authStore'

const router = useRouter()
const auth = useAuthStore()

// 🟩 LOGOUT FIX
const logout = async () => {
  await auth.logout()
  router.push({ name: 'Login' })
}

// State for tabs
const activeTab = ref('profile')

// Profile data
const profile = ref({
  name: 'Edi Geyming',
  email: 'EdiGeyming@Gmail.com',
  phone: '+6281-2345-67890'
})

// Address data
const address = ref({
  street: 'Jepara, RT18 RW05 JI.Pandawa',
  district: 'Jepara',
  regency: 'Jepara',
  province: 'Jawa Tengah',
  postalCode: '12345'
})

// Password data
const password = ref({
  current: '',
  new: '',
  confirm: ''
})

// Orders data
const orders = ref([
  { id: 1, orderNumber: '#12345', date: 'July 15, 2024', items: 2, total: 'Rp 25.000', status: 'Terkirim' },
  { id: 2, orderNumber: '#12344', date: 'July 10, 2024', items: 3, total: 'Rp 50.000', status: 'Terkirim' },
  { id: 3, orderNumber: '#12343', date: 'July 5, 2024', items: 1, total: '15.000', status: 'Terkirim' }
])

// Save functions (tetap original)
const saveProfileChanges = () => console.log('Saving profile changes:', profile.value)
const saveAddressChanges = () => console.log('Saving address changes:', address.value)
const savePasswordChanges = () => console.log('Saving password changes:', password.value)

const saveAllChanges = () => {
  saveProfileChanges()
  saveAddressChanges()
  savePasswordChanges()
  alert('Semua perubahan telah disimpan!')
}

const printReceipt = (orderId) => {
  alert(`Resi untuk pesanan ${orderId} akan dicetak!`)
}
</script>


<style scoped>
</style>
