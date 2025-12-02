<template>
  <!-- Wrapper utama dengan padding responsif dan margin vertikal -->
  <div class="min-h-screen bg-gray-50 py-12 sm:py-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Breadcrumb -->
      <nav class="text-sm text-gray-600 mb-6">
        <router-link
          to="/menu"
          class="text-red-600 hover:text-red-700 font-medium transition duration-150"
          >Menu</router-link
        >
        <span class="mx-2">/</span>
        <span class="font-bold text-gray-800">{{ menu?.name || "Memuat..." }}</span>
      </nav>

      <!-- Kontainer Detail Menu menggunakan UserAppCard besar -->
      <UserAppCard padding="lg" v-if="menu" class="shadow-2xl shadow-red-100/50">
        <div class="flex flex-col md:flex-row gap-8 lg:gap-12">
          <!-- Kiri: Gambar dan Galeri Mini -->
          <div class="w-full md:w-5/12 flex flex-col gap-4">
            <!-- Gambar Utama (Aspect Ratio 4:3 lebih baik untuk food) -->
            <div
              class="w-full aspect-[4/3] rounded-2xl overflow-hidden shadow-lg border border-gray-100"
            >
              <img
                :src="currentImage"
                class="w-full h-full object-cover transition-transform duration-500 hover:scale-105"
                :alt="'Gambar Utama ' + menu.name"
              />
            </div>
          </div>

          <!-- Kanan: Info Produk dan Interaksi -->
          <div class="w-full md:w-7/12 flex flex-col">
            <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-2">{{ menu.name }}</h1>

            <!-- Harga -->
            <p class="text-red-600 font-bold text-3xl mb-4 border-b border-gray-100 pb-4">
              Rp {{ menu.price }}
            </p>

            <!-- Deskripsi -->
            <h2 class="text-lg font-semibold text-gray-800 mb-2">Deskripsi Produk</h2>
            <p class="text-gray-600 leading-relaxed mb-6">{{ menu.descDetail }}</p>

            <!-- Kategori & Stok (Dalam grid kecil) -->
            <div class="grid grid-cols-2 gap-4 mb-8">
              <!-- Kategori -->
              <div
                class="flex items-center gap-3 bg-red-50/50 p-3 rounded-lg border border-red-100"
              >
                <Tag class="w-5 h-5 text-red-600" />
                <div>
                  <p class="text-xs font-medium text-gray-500">Kategori</p>
                  <strong class="text-base text-gray-800">{{ menu.category }}</strong>
                </div>
              </div>

              <!-- Stok -->
              <div
                :class="[
                  menu.stock > 0
                    ? 'bg-green-50/50 border-green-100'
                    : 'bg-red-50/50 border-red-100',
                  'flex items-center gap-3 p-3 rounded-lg border',
                ]"
              >
                <Box :class="[menu.stock > 0 ? 'text-green-600' : 'text-red-600', 'w-5 h-5']" />
                <div>
                  <p class="text-xs font-medium text-gray-500">Ketersediaan</p>
                  <strong class="text-base text-gray-800">
                    {{ menu.stock > 0 ? "Tersedia" : "Habis" }}
                    ({{ menu.stock }} item{{ menu.stock === 1 ? "" : menu.stock > 0 ? "" : "" }})
                  </strong>
                </div>
              </div>
            </div>

            <!-- Qty Counter dan Button Utama -->
            <div
              class="flex flex-col sm:flex-row sm:items-center gap-4 mt-auto pt-4 border-t border-gray-100"
            >
              <!-- Qty Input -->
              <div
                class="flex items-center border border-gray-300 rounded-lg overflow-hidden w-full sm:w-auto"
              >
                <button
                  @click="decrementQty"
                  :disabled="qty <= 1 || menu.stock <= 0"
                  class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 disabled:opacity-50 disabled:cursor-not-allowed transition duration-150"
                >
                  <Minus class="w-5 h-5" />
                </button>
                <input
                  v-model.number="qty"
                  type="number"
                  min="1"
                  :max="menu.stock"
                  :disabled="menu.stock <= 0"
                  class="w-16 text-center text-lg font-medium outline-none border-none focus:ring-0"
                  @change="validateQty"
                />
                <button
                  @click="incrementQty"
                  :disabled="qty >= menu.stock || menu.stock <= 0"
                  class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 disabled:opacity-50 disabled:cursor-not-allowed transition duration-150"
                >
                  <Plus class="w-5 h-5" />
                </button>
              </div>

              <!-- Button Tambah ke Keranjang -->
              <UserAppButton
                size="lg"
                class="shadow-red-300/50 w-full sm:w-auto flex-1"
                @click="addToCart"
                :disabled="menu.stock <= 0 || qty === 0"
              >
                <template #icon-left>
                  <ShoppingCart class="w-5 h-5" />
                </template>
                Tambah ke Keranjang
              </UserAppButton>
            </div>
          </div>
        </div>
      </UserAppCard>

      <div v-else class="text-center text-gray-500 mt-12 bg-white p-10 rounded-2xl shadow-xl">
        <AlertTriangle class="w-12 h-12 text-red-500 mx-auto mb-4" />
        <p class="text-xl font-semibold">Menu tidak ditemukan.</p>
        <router-link
          to="/menu"
          class="text-red-600 hover:text-red-700 mt-4 inline-block font-medium"
        >
          &larr; Kembali ke Daftar Menu
        </router-link>
      </div>
    </div>
  </div>

  <!-- 🔥 Pop-up Notifikasi Floating Tengah -->
  <transition name="popup">
    <div
      v-if="showNotif"
      class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-white shadow-2xl rounded-xl px-8 py-6 text-center z-50 border-4 border-red-600 ring-8 ring-red-50 w-[85%] max-w-sm"
    >
      <CheckCircle class="w-10 h-10 text-red-600 mx-auto mb-3" />
      <p class="text-gray-800 font-semibold text-lg">{{ notifMessage }}</p>
    </div>
  </transition>
</template>

<script setup>
import { ref, watch } from "vue";
import { useRoute } from "vue-router";
import { menus } from "@/data/UserAppData";

// Mengimpor komponen base
import UserAppCard from "@/components/baseUser/UserAppCard.vue";
import UserAppButton from "@/components/baseUser/UserAppButton.vue";

// Mengimpor ikon Lucide
import { ShoppingCart, Plus, Minus, Tag, Box, CheckCircle, AlertTriangle } from "lucide-vue-next";

// Data Dummy Gambar (untuk galeri mini)
const dummyImages = [
  "https://placehold.co/800x600/EE7D7D/ffffff?text=Ayam+Geprek+Utama",
  "https://placehold.co/800x600/C83C3C/ffffff?text=Sambal+Matah+Detail",
  "https://placehold.co/800x600/A00000/ffffff?text=Tampak+Samping",
];

const route = useRoute();
const menu = ref(null);
const qty = ref(1);
const currentImage = ref(dummyImages[0]);

// Notifikasi
const showNotif = ref(false);
const notifMessage = ref("");

function incrementQty() {
  if (menu.value && qty.value < menu.value.stock) qty.value++;
}
function decrementQty() {
  if (qty.value > 1) qty.value--;
}

function validateQty() {
  // Pastikan qty adalah angka
  let newQty = parseInt(qty.value, 10);
  if (isNaN(newQty) || newQty < 1) {
    newQty = 1;
  }
  // Batasi max berdasarkan stock
  if (menu.value && newQty > menu.value.stock) {
    newQty = menu.value.stock;
  }
  qty.value = newQty;
}

function addToCart() {
  if (menu.value && menu.value.stock > 0 && qty.value > 0) {
    notifMessage.value = `${qty.value} x ${menu.value.name} berhasil ditambahkan ke keranjang!`;
    showNotif.value = true;

    // Logika penambahan ke keranjang (simulasi)
    console.log(`Menambahkan ${qty.value} x ${menu.value.name} ke keranjang.`);

    // Auto-hide notifikasi setelah 2 detik
    setTimeout(() => {
      showNotif.value = false;
    }, 2000);
  }
}

function loadMenu() {
  const decodedName = decodeURIComponent(route.params.name);
  menu.value = menus.find((m) => m.name === decodedName) ?? null;

  // Reset kuantitas dan gambar saat menu dimuat
  qty.value = menu.value && menu.value.stock > 0 ? 1 : 0; // Set 0 jika stok habis
  currentImage.value = menu.value?.img || dummyImages[0]; // Menggunakan gambar dari data menu jika tersedia

  // Jika stok habis, pastikan tombol Qty dinonaktifkan
  if (menu.value && menu.value.stock <= 0) {
    qty.value = 0;
  }
}

watch(() => route.params.name, loadMenu, { immediate: true });
</script>

<style scoped>
/* 🎬 Animasi notifikasi yang lebih elegan */
.popup-enter-active,
.popup-leave-active {
  transition: all 0.4s cubic-bezier(0.68, -0.55, 0.27, 1.55); /* Springy animation */
}
.popup-enter-from,
.popup-leave-to {
  opacity: 0;
  transform: translate(-50%, -50%) scale(0.7);
}

/* Custom styling for QTY input number */
input[type="number"]::-webkit-inner-spin-button,
input[type="number"]::-webkit-outer-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
input[type="number"] {
  -moz-appearance: textfield;
}
</style>
