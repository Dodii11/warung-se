<template>
  <div class="p-6 sm:p-8 md:p-10 bg-white rounded-2xl">

    <!-- Header & Status -->
    <div class="text-center mb-8">
      <div class="mx-auto w-16 h-16 rounded-full bg-green-100 flex items-center justify-center mb-4">
        <CheckCircle class="w-8 h-8 text-green-600" />
      </div>
      <h1 class="text-2xl font-extrabold text-gray-900">Pesanan Berhasil Dibuat!</h1>
      <p class="text-sm text-gray-500 mt-1">Pesanan #{{ orderId }} siap diproses.</p>
    </div>

    <!-- Detail Pelanggan & Pengiriman -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4 mb-8 p-4 border border-gray-100 bg-gray-50 rounded-lg">
        <div class="flex items-center gap-3">
            <User class="w-5 h-5 text-red-500 flex-shrink-0" />
            <div>
                <span class="text-xs text-gray-500 block">Nama Penerima</span>
                <p class="font-semibold text-sm text-gray-800">{{ order?.customer.name || 'N/A' }}</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <Phone class="w-5 h-5 text-red-500 flex-shrink-0" />
            <div>
                <span class="text-xs text-gray-500 block">Nomor Kontak</span>
                <p class="font-semibold text-sm text-gray-800">{{ order?.customer.phone || 'N/A' }}</p>
            </div>
        </div>
        <div class="sm:col-span-2 flex items-start gap-3 mt-2">
            <MapPin class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" />
            <div>
                <span class="text-xs text-gray-500 block">Alamat Pengiriman</span>
                <p class="font-medium text-sm text-gray-800 leading-snug">{{ order?.customer.address || 'N/A' }}</p>
            </div>
        </div>
    </div>

    <!-- Ringkasan Item -->
    <div class="mb-8">
      <h2 class="font-bold text-gray-800 mb-4 border-b pb-2 flex items-center gap-2">
        <Package class="w-5 h-5 text-gray-600" /> Rincian Produk
      </h2>
      <div class="space-y-3 max-h-48 overflow-y-auto pr-2">
        <div
          v-for="(item, index) in order?.items || defaultItems"
          :key="index"
          class="flex justify-between items-center text-sm"
        >
          <!-- Menggunakan placeholder image URL yang lebih baik -->
          <div class="flex items-center gap-3 flex-1 min-w-0">
            <img
              :src="`https://placehold.co/40x40/fef2f2/ef4444?text=${item.name.charAt(0)}`"
              :alt="item.name"
              class="w-10 h-10 object-cover rounded-md flex-shrink-0 border border-gray-100"
              onerror="this.onerror=null;this.src='https://placehold.co/40x40/fef2f2/ef4444?text=Item';"
            />
            <div class="min-w-0 flex-1">
                <p class="font-medium text-gray-900 truncate">{{ item.name }}</p>
                <p class="text-xs text-gray-500">x{{ item.qty }}</p>
            </div>
          </div>
          <p class="font-semibold text-gray-800 flex-shrink-0 whitespace-nowrap"> {{ formatCurrency(item.total) }}</p>
        </div>
      </div>
    </div>

    <!-- Total Biaya (Footer) -->
    <div class="bg-red-50 p-4 rounded-xl border-t border-red-200">
        <div class="flex justify-between text-sm text-gray-700 mb-2">
            <span>Subtotal</span>
            <span> {{ formatCurrency(order?.subtotal || 37000) }}</span>
        </div>
        <div class="flex justify-between text-sm text-gray-700 mb-2">
            <span>Biaya Pengiriman</span>
            <span> {{ formatCurrency(order?.shippingFee || 5000) }}</span>
        </div>
        <div class="flex justify-between text-sm font-semibold text-gray-700 pt-2 border-t border-red-200">
            <span class="text-lg text-red-700">Total Pembayaran</span>
            <span class="text-xl font-black text-red-700"> {{ formatCurrency(order?.total || 42000) }}</span>
        </div>
    </div>

    <!-- Tombol Aksi -->
    <div class="flex gap-3 mt-8">
      <UserAppButton
        variant="secondary"
        size="md"
        class="flex-1"
        @click="printReceipt"
      >
        <Printer class="w-5 h-5" />
        Cetak Struk
      </UserAppButton>
      <UserAppButton
        size="md"
        class="flex-1"
        @click="trackOrder"
      >
        <MapPin class="w-5 h-5" />
        Lacak Pesanan
      </UserAppButton>
    </div>

  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { CheckCircle, User, Phone, MapPin, Package, Printer } from 'lucide-vue-next'
// Asumsi UserAppButton sudah ter-import secara global atau di-resolve dari file yang ada

// Properti yang diterima dari FormDetailPesanan
const props = defineProps({
    orderData: Object, // Menerima data pesanan langsung dari parent
    orderId: { type: [String, Number], default: () => Math.floor(Math.random() * 90000) + 10000 }
})

const defaultItems = [
  { name: 'Ayam Geprek Original', qty: 2, total: 30000 },
  { name: 'Mie Kuah Pedas', qty: 1, total: 3000 },
  { name: 'Es Teh', qty: 1, total: 4000 }
]

const order = ref(props.orderData)

onMounted(() => {
    // Jika data order tidak dikirim melalui props, coba ambil dari localStorage
    if (!order.value) {
        const saved = localStorage.getItem("latestOrder")
        if (saved) {
            order.value = JSON.parse(saved)
        }
    }
})

const formatCurrency = (value) => {
  return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 })
    .format(value).replace('Rp', 'Rp ').replace(',00', '')
}

function trackOrder() {
  // Mengganti alert() dengan console.log/custom modal message sesuai instruksi
  console.log(`Lacak pesanan #${props.orderId}: Sedang diproses...`);
  // Simulasi aksi: router.push({ name: 'TrackOrder', params: { id: props.orderId } })
}

function printReceipt() {
    console.log(`Cetak struk pesanan #${props.orderId}`);
    // Simulasi aksi: router.push('/struk')
}
</script>
