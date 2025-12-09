<template>
  <div class="p-6 sm:p-8 md:p-10 bg-white rounded-2xl">
    <!-- Header & Status (Dinamis) -->
    <div class="text-center mb-8">
      <div
        :class="[
          statusClass.bg,
          'mx-auto w-16 h-16 rounded-full flex items-center justify-center mb-4',
        ]"
      >
        <!-- Ikon berubah berdasarkan status: Ceklis (Selesai/Aktif) atau Silang (Gagal) -->
        <component :is="statusClass.icon" class="w-8 h-8" :class="statusClass.text" />
      </div>

      <h1 class="text-2xl font-extrabold text-gray-900">
        Detail Pesanan #{{ order?.orderNumber || orderId }}
      </h1>
      <p class="text-sm text-gray-500 mt-1 font-semibold">
        Status: <span :class="statusClass.text">{{ order?.status || "Memuat..." }}</span>
      </p>
    </div>

    <!-- Detail Pelanggan & Pengiriman -->
    <div
      class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4 mb-8 p-4 border border-gray-100 bg-gray-50 rounded-lg"
    >
      <div class="flex items-center gap-3">
        <User class="w-5 h-5 text-red-500 shrink-0" />
        <div>
          <span class="text-xs text-gray-500 block">Nama Penerima</span>
          <p class="font-semibold text-sm text-gray-800">{{ order?.customer?.name || "N/A" }}</p>
        </div>
      </div>
      <div class="flex items-center gap-3">
        <Phone class="w-5 h-5 text-red-500 shrink-0" />
        <div>
          <span class="text-xs text-gray-500 block">Nomor Kontak</span>
          <p class="font-semibold text-sm text-gray-800">{{ order?.customer?.phone || "N/A" }}</p>
        </div>
      </div>
      <div class="sm:col-span-2 flex items-start gap-3 mt-2">
        <MapPin class="w-5 h-5 text-red-500 shrink-0 mt-0.5" />
        <div>
          <span class="text-xs text-gray-500 block">Alamat Pengiriman</span>
          <p class="font-medium text-sm text-gray-800 leading-snug">
            {{ order?.customer?.address || "N/A" }}
          </p>
        </div>
      </div>
    </div>

    <!-- Ringkasan Item (Dinamis) -->
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
          <div class="flex items-center gap-3 flex-1 min-w-0">
            <img
              :src="`https://placehold.co/40x40/fef2f2/ef4444?text=${item.name.charAt(0)}`"
              :alt="item.name"
              class="w-10 h-10 object-cover rounded-md shrink-0 border border-gray-100"
              onerror="this.onerror=null;this.src='https://placehold.co/40x40/fef2f2/ef4444?text=Item';"
            />
            <div class="min-w-0 flex-1">
              <p class="font-medium text-gray-900 truncate">{{ item.name }}</p>
              <p class="text-xs text-gray-500">x{{ item.qty }}</p>
            </div>
          </div>
          <p class="font-semibold text-gray-800 shrink-0 whitespace-nowrap">
            {{ formatCurrency(item.total) }}
          </p>
        </div>
      </div>
    </div>

    <!-- Total Biaya (Dinamis) -->
    <div class="bg-red-50 p-4 rounded-xl border-t border-red-200">
      <div class="space-y-2 mb-3">
        <div class="flex justify-between text-sm text-gray-700">
          <span>Subtotal</span>
          <span> {{ formatCurrency(order?.subtotal || 0) }}</span>
        </div>
        <div class="flex justify-between text-sm text-gray-700">
          <span>Biaya Pengiriman</span>
          <span> {{ formatCurrency(order?.shippingFee || 0) }}</span>
        </div>
      </div>
      <div class="flex justify-between pt-3 border-t border-red-200 items-baseline">
        <span class="text-base sm:text-lg font-bold text-red-700">Total Pembayaran:</span>
        <span class="text-base sm:text-lg font-bold text-red-700">
          {{ formatCurrency(order?.total || 0) }}
        </span>
      </div>
    </div>

    <!-- Tombol Aksi - Menyembunyikan "Lacak Pesanan" jika status final -->
    <div class="flex flex-col sm:flex-row gap-3 mt-8">
      <UserAppButton variant="secondary" size="md" class="flex-1" @click="printReceipt">
        <Printer class="w-5 h-5" />
        Cetak Struk
      </UserAppButton>
      <!-- Tampilkan Lacak hanya jika status BUKAN Selesai atau Gagal -->
      <UserAppButton v-if="!isStatusFinal" size="md" class="flex-1" @click="trackOrder">
        <MapPin class="w-5 h-5" />
        Lacak Pesanan
      </UserAppButton>
    </div>
  </div>
</template>

<script setup>
import { computed } from "vue"; // Hapus import 'ref'
import { CheckCircle, XCircle, User, Phone, MapPin, Package, Printer } from "lucide-vue-next";
import UserAppButton from "@/components/baseUser/UserAppButton.vue";

const props = defineProps({
  // Menerima data pesanan lengkap dari komponen UserOrdersPage
  orderData: { type: Object, default: () => ({ customer: {}, items: [], status: "Memuat..." }) },
  // Fallback untuk orderId (jika data belum dimuat)
  orderId: { type: [String, Number], default: () => "N/A" },
});

// Menggunakan computed untuk kemudahan akses data, reaktif terhadap perubahan props
const order = computed(() => props.orderData);

const defaultItems = [
  { name: "Ayam Geprek Original", qty: 2, total: 30000 },
  { name: "Mie Kuah Pedas", qty: 1, total: 3000 },
  { name: "Es Teh", qty: 1, total: 4000 },
];

const isStatusFinal = computed(() => ["Selesai", "Gagal"].includes(order.value.status));

const statusClass = computed(() => {
  switch (order.value.status) {
    case "Selesai":
      return { bg: "bg-green-100", text: "text-green-600", icon: CheckCircle };
    case "Gagal":
      return { bg: "bg-red-100", text: "text-red-600", icon: XCircle };
    // Default untuk status aktif (Tertunda, Diproses, Dikirim)
    default:
      return { bg: "bg-yellow-100", text: "text-yellow-600", icon: CheckCircle };
  }
});

const formatCurrency = (value) => {
  if (typeof value === "undefined" || value === null) return "Rp 0";
  const numericValue =
    typeof value === "string"
      ? parseFloat(value.replace(/[^0-9,-]+/g, "").replace(",", "."))
      : value;

  return new Intl.NumberFormat("id-ID", {
    style: "currency",
    currency: "IDR",
    minimumFractionDigits: 0,
  })
    .format(numericValue)
    .replace("Rp", "Rp ")
    .replace(",00", "");
};

function trackOrder() {
  console.log(`Lacak pesanan #${order.value.orderNumber}: Dipicu dari Modal Detail`);
}

function printReceipt() {
  console.log(`Cetak struk pesanan #${order.value.orderNumber}: Dipicu dari Modal Detail`);
}
</script>
