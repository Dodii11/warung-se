<template>
  <!-- WRAPPER UTAMA -->
  <div class="min-h-screen flex flex-col bg-white">
    <!-- 🔴 Navbar -->
    <Navbar />

    <!-- MAIN CONTENT -->
    <main class="flex-1">
      <!-- HERO SECTION - Menggunakan latar belakang putih bersih (Default) -->
      <section
        id="hero"
        class="relative bg-white w-full min-h-screen flex items-center pt-24 pb-16"
      >
        <div
          class="max-w-7xl mx-auto px-6 w-full grid md:grid-cols-2 gap-10 items-center transition-all duration-300 translate-y-[-100px] lg:translate-y-[-50px]"
        >
          <!-- Text -->
          <div class="flex flex-col justify-center space-y-5 text-center md:text-left">
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold leading-tight text-gray-900">
              Nikmati Kelezatan <br />
              <span class="text-red-600">Ayam Geprek</span> <br />
              Tercihuyy
            </h1>

            <p class="text-gray-600 text-base sm:text-lg leading-relaxed max-w-lg mx-auto md:mx-0">
              Kombinasi sempurna antara ayam krispi, sambal pedas yang menggugah selera, dan nasi
              hangat.
            </p>

            <div class="pt-2">
              <UserAppButton
                size="lg"
                class="shadow-lg shadow-red-300/50 w-fit mx-auto md:mx-0"
                @click="goToMenu"
              >
                <template #icon-left>
                  <ShoppingCart class="w-5 h-5" />
                </template>
                Pesan Sekarang
              </UserAppButton>
            </div>
          </div>

          <!-- Gambar (menggunakan aset lokal yang dipertahankan) -->
          <div class="flex justify-center items-center">
            <img
              :src="heroImg"
              class="rounded-3xl shadow-xl shadow-red-200/50 w-full max-w-md h-auto object-contain transform hover:scale-[1.01] transition-transform duration-500"
              alt="Hero Image Ayam Geprek"
            />
          </div>
        </div>
      </section>

      <!-- MENU TERBARU SECTION  -->
      <section id="menu" class="py-16 sm:py-24 bg-gray-50 w-full">
        <div
          class="max-w-7xl mx-auto px-6 py-12 bg-white rounded-3xl shadow-2xl shadow-gray-200/50"
        >
          <h2 class="text-center text-3xl sm:text-4xl font-extrabold mb-3 text-gray-900">
            Menu Terbaru
          </h2>
          <p class="text-center text-gray-600 text-lg mb-10 max-w-2xl mx-auto">
            Temukan pilihan menu baru yang paling diminati oleh pelanggan kami!
          </p>

          <!-- Loading -->
          <div v-if="isLoadingMenus" class="text-center py-10 text-gray-500">
            Memuat menu terbaru...
          </div>

          <!-- Error -->
          <div v-else-if="menuError" class="text-center py-10 text-red-500">
            {{ menuError }}
          </div>

          <!-- Data -->
          <div
            v-else
            class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-8"
          >
            <UserAppCard
              v-for="item in latestMenus"
              :key="item.id_menu"
              padding="sm"
              class="flex flex-col justify-between hover:shadow-red-200/50 transform hover:scale-[1.02] transition-all duration-300"
            >
              <div class="grow">
                <img
                  :src="item.gambar_url"
                  class="rounded-xl w-full h-36 object-cover mb-4 shadow-sm border border-gray-100"
                  :alt="item.menu"
                />

                <h3 class="font-bold text-gray-900 text-lg mb-1 line-clamp-2">
                  {{ item.menu }}
                </h3>

                <p class="text-red-600 font-extrabold text-xl">
                  Rp {{ item.harga.toLocaleString("id-ID") }}
                </p>
              </div>

              <UserAppButton
                size="sm"
                class="mt-3 w-full shadow-sm"
                @click="goToDetail(item)"
              >
                <template #icon-left>
                  <ChefHat class="w-4 h-4" />
                </template>
                Pesan Sekarang
              </UserAppButton>
            </UserAppCard>
          </div>

          <!-- Tombol untuk melihat semua menu -->
          <div class="text-center pt-10">
            <UserAppButton
              size="md"
              variant="secondary"
              @click="goToMenu"
              class="shadow-md shadow-gray-200/50"
            >
              Lihat Semua Menu
            </UserAppButton>
          </div>
        </div>
      </section>

      <!-- TENTANG KAMI SECTION - Latar Belakang Putih Bersih (Kontras dengan Menu) -->
      <section id="about" class="bg-white py-16 sm:py-24">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
          <!-- Text Content (menggunakan data contactInfo dari dataUser.js) -->
          <div class="text-center md:text-left space-y-4">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900">
              Sensasi Rasa <span class="text-red-600">Tak Terlupakan</span>
            </h2>
            <h3 class="text-xl font-semibold text-gray-700">{{ contactInfo.name }}</h3>
            <p class="text-gray-600 leading-relaxed text-base sm:text-lg">
              {{ contactInfo.aboutUs }}
            </p>
            <div class="pt-2">
              <UserAppButton
                size="md"
                variant="secondary"
                class="w-fit mx-auto md:mx-0"
                @click="scrollToSection('contact')"
              >
                <template #icon-left>
                  <MessageSquare class="w-4 h-4" />
                </template>
                Hubungi Kami
              </UserAppButton>
            </div>
          </div>

          <!-- Gambar (menggunakan aset lokal yang dipertahankan) -->
          <div class="flex justify-center items-center">
            <img
              :src="heroImg2"
              class="rounded-3xl shadow-xl w-full h-auto max-w-md object-cover border border-gray-100"
              alt="Restaurant Interior"
            />
          </div>
        </div>
      </section>

      <!-- HUBUNGI KAMI SECTION - Latar Belakang Abu-abu (Memberi Kontras) -->
      <section id="contact" class="text-center pt-16 pb-20 bg-gray-50">
        <!-- Kontainer Putih Besar dengan Shadow untuk efek Floating Card -->
        <div
          class="max-w-7xl mx-auto px-6 py-12 bg-white rounded-3xl shadow-2xl shadow-gray-200/50"
        >
          <h2 class="text-3xl font-extrabold mb-4 text-gray-900">
            <span class="text-red-600">Kontak</span> Kami
          </h2>
          <p class="text-gray-600 text-lg mb-8 max-w-xl mx-auto">
            Punya pertanyaan atau masukan? Kami siap melayani Anda dengan senang hati.
          </p>

          <!-- Kontak Info menggunakan Card (menggunakan data contactInfo dari dataUser.js) -->
          <div class="max-w-3xl mx-auto">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
              <!-- Telepon -->
              <UserAppCard padding="lg" class="flex flex-col items-center space-y-3">
                <PhoneCall class="w-8 h-8 text-red-600" />
                <h3 class="text-xl font-bold text-gray-900">Telepon</h3>
                <p class="text-gray-600 text-base">Silakan hubungi kami kapan saja.</p>
                <strong class="text-red-600 text-lg">{{ contactInfo.phone }}</strong>
              </UserAppCard>

              <!-- Email -->
              <UserAppCard padding="lg" class="flex flex-col items-center space-y-3">
                <Mail class="w-8 h-8 text-red-600" />
                <h3 class="text-xl font-bold text-gray-900">Email</h3>
                <p class="text-gray-600 text-base">Kirim pesan dan kami akan merespons cepat.</p>
                <strong class="text-red-600 text-lg">{{ contactInfo.email }}</strong>
              </UserAppCard>
            </div>
          </div>
        </div>
      </section>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import { getLatestMenus } from "@/api/menuService";

import heroImg from "@/assets/Ayam Geprek.png";
import heroImg2 from "@/assets/Restaurant Interior.png";

import Navbar from "@/components/Navbar.vue";
import UserAppButton from "@/components/baseUser/UserAppButton.vue";
import UserAppCard from "@/components/baseUser/UserAppCard.vue";
import { ShoppingCart, ChefHat, PhoneCall, Mail, MessageSquare } from "lucide-vue-next";
import { contactInfo } from "@/data/UserAppData";

// --- STATE & LOGIC MENU ---
const router = useRouter();

const latestMenus = ref([]);
const isLoadingMenus = ref(false);
const menuError = ref(null);

async function fetchLatestMenus() {
  try {
    isLoadingMenus.value = true;
    menuError.value = null;

    const res = await getLatestMenus(5);
    console.log("MENU API RESPONSE:", res.data);

    let menus = [];

    if (Array.isArray(res.data)) {
      menus = res.data;
    } else if (Array.isArray(res.data?.data)) {
      menus = res.data.data;
    } else if (Array.isArray(res.data?.data?.data)) {
      menus = res.data.data.data;
    }

    latestMenus.value = menus.slice(0, 5);
  } catch (err) {
    console.error("FETCH MENU ERROR:", err);
    menuError.value = "Gagal memuat menu terbaru";
  } finally {
    isLoadingMenus.value = false;
  }
}

onMounted(fetchLatestMenus);

// --- NAVIGATION & SCROLL LOGIC ---
function goToMenu() {
  router.push("/menu");
}

function goToDetail(menu) {
  router.push({
    name: "DetailMenu",
    params: { name: encodeURIComponent(menu.menu) },
  });
}

function scrollToSection(id) {
  const element = document.getElementById(id);
  if (element) {
    window.scrollTo({
      top: element.offsetTop - 80,
      behavior: "smooth",
    });
  }
}
</script>
