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
      <UserAppButton v-if="!isStatusFinal" size="md" class="flex-1" @click="trackOrder">
        <MapPin class="w-5 h-5" />
        Lacak Pesanan
      </UserAppButton>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import { OrdersAPI } from "@/api/orders";
import { CheckCircle, XCircle, User, Phone, MapPin, Package, Printer } from "lucide-vue-next";
import UserAppButton from "@/components/baseUser/UserAppButton.vue";
import { useRouter } from "vue-router";

const router = useRouter();

const props = defineProps({
  orderData: { type: Object, default: null },
  orderId: { type: [String, Number], default: null },
});

const order = ref(null);

onMounted(async () => {
  if (props.orderData) {
    order.value = props.orderData;
  } else if (props.orderId) {
    order.value = await OrdersAPI.getOrder(props.orderId);
  }
});

const isStatusFinal = computed(() => ["Selesai", "Gagal"].includes(order.value?.status));

const statusClass = computed(() => {
  switch (order.value?.status) {
    case "Selesai":
      return { bg: "bg-green-100", text: "text-green-600", icon: CheckCircle };
    case "Gagal":
      return { bg: "bg-red-100", text: "text-red-600", icon: XCircle };
    default:
      return { bg: "bg-yellow-100", text: "text-yellow-600", icon: CheckCircle };
  }
});

const resolveImage = (img) => {
  if (!img) return null;
  if (img.startsWith("http")) return img;

  const normalized = img.startsWith("/") ? img : `/storage/${img}`;

  return `${import.meta.env.VITE_API_BASE_URL}${normalized}`;
};

const fallbackImage = (name = "Item") =>
  `https://placehold.co/40x40/fef2f2/ef4444?text=${name.charAt(0)}`;


const formatCurrency = (v) =>
  new Intl.NumberFormat("id-ID", {
    style: "currency",
    currency: "IDR",
    minimumFractionDigits: 0,
  }).format(v || 0);

function trackOrder() {
  router.push("/profile");
}
</script>
