<template>
  <!-- WRAPPER UTAMA -->
  <div class="min-h-screen flex flex-col">

    <!-- 🔴 Navbar -->
    <Navbar />

    <!-- MAIN CONTENT -->
    <main class="flex-1 pt50"> 
<!-- Hero Section -->
<section class="relative bg-white w-full min-h-screen flex items-center">

  <div class="max-w-7xl mx-auto px-6 w-full grid md:grid-cols-2 gap-10 items-center justify-center
              translate-y-[-120px] md:translate-y-[-160px] lg:translate-y-[-100px] transition-all duration-300">

    <!-- Text -->
    <div class="flex flex-col justify-center space-y-4 text-center md:text-left">
      
      <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold leading-tight text-gray-900">
        Nikmati Kelezatan <br />
        Ayam Geprek <br />
        Tercihuyy
      </h1>

      <p class="text-gray-600 text-base sm:text-lg md:text-lg leading-relaxed">
        Kombinasi sempurna antara ayam krispi, sambal pedas yang menggugah selera, dan nasi hangat.
      </p>

      <button
        class="button-text bg-red-600 hover:bg-red-700 px-6 py-3 rounded-lg shadow-md w-fit mx-auto md:mx-0"
        @click="goToMenu"
      >
        Pesan Sekarang
      </button>
    </div>

    <!-- Gambar -->
    <div class="flex justify-center items-center">
      <img
        :src="heroImg"
        class="rounded-xl shadow-lg w-full max-w-md h-auto object-contain"
        alt="Hero Image"
      />
    </div>

  </div>

</section>

      <!-- Menu Unggulan -->
      <section class="py-10 bg-gray-50 w-full">
        <h2 class="text-center text-2xl font-bold mb-6">Menu Unggulan</h2>

        <div class="flex flex-wrap justify-center gap-4 mb-6 text-sm font-medium">
          <span
            v-for="cat in categories"
            :key="cat"
            @click="selectedCategory = cat"
            :class="[
              'cursor-pointer pb-1 transition',
              selectedCategory === cat
                ? 'text-red-600 border-b-2 border-red-600'
                : 'text-gray-600 hover:text-red-600'
            ]"
          >
            {{ cat }}
          </span>
        </div>

        <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
          <div
            v-for="(item, index) in filteredMenus"
            :key="index"
            class="bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition p-3"
          >
            <img :src="item.img" class="rounded-md w-full h-32 sm:h-40 md:h-32 object-cover" />

            <h3 class="mt-3 font-semibold text-gray-900 text-sm sm:text-base">{{ item.name }}</h3>
            <p class="text-red-600 font-bold text-sm sm:text-base">Rp {{ item.price }}</p>

            <button
              class="w-full bg-red-600 text-white text-xs sm:text-sm font-semibold rounded-md py-1.5 hover:bg-red-700 transition mt-2"
              @click="goToDetail(item.name)"
            >
              Pesan Sekarang
            </button>
          </div>
        </div>
      </section>

      <!-- Tentang Kami -->
      <section class="bg-white py-12 sm:py-16">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-8 items-center bg-gray-50 shadow-md rounded-xl p-6 sm:p-8">
          <div class="text-center md:text-left">
            <h2 class="text-2xl sm:text-3xl font-bold mb-3">Tentang Kami</h2>
            <h3 class="text-lg sm:text-xl font-semibold text-red-600 mb-2">Warung Serba Enak</h3>
            <p class="text-gray-600 leading-relaxed text-sm sm:text-base">
              Selamat datang di WarungSE, sensasi rasa ayam geprek bukan sekadar makanan,
              tetapi kebahagiaan dalam setiap suap yang tak terlupakan. Kami percaya bahwa
              setiap hidangan harus spesial. Karena itu, kami hanya menggunakan ayam segar pilihan
              yang digeprek hingga renyah sempurna, lalu disajikan dengan sambal dadakan yang pedas
              tetapi tetap menggugah selera Anda.
            </p>
          </div>

          <div class="flex justify-center items-center mt-6 md:mt-0">
            <img
              :src="heroImg2"
              class="rounded-xl shadow-lg w-full h-auto max-w-md object-cover"
              alt="Hero Image"
            />
          </div>
        </div>
      </section>

      <!-- Hubungi Kami -->
<section class="text-center pt-10 pb-6 bg-white">
        <h2 class="text-xl font-bold mb-4">Hubungi Kami</h2>
        <p class="text-gray-700 text-sm sm:text-base">
          Punya pertanyaan atau masukan? Kami siap membantu!
        </p>
        <p class="text-gray-700 text-sm sm:text-base">
          Telepon: <strong>0812-0000-0000</strong> | Email: support@warungse.com
        </p>
      </section>
    </main>

        <Footer />

</div>
</template>

<script setup>
import heroImg from '@/assets/Ayam Geprek.png';
import heroImg2 from '@/assets/Restaurant Interior.png';
import { ref, computed } from "vue";
import { useRouter } from "vue-router";
import Footer from '@/components/Footer.vue';
import Navbar from '@/components/Navbar.vue';

const router = useRouter();

function goToMenu() {
  router.push("/menu");
}

const menus = [
  { name: "Ayam Geprek Original", price: "15.000", img: "https://placehold.co/300x200/png?text=Original", category: "Ayam" },
  { name: "Ayam Geprek Sambal Matah", price: "20.000", img: "https://placehold.co/300x200/png?text=Matah", category: "Ayam" },
  { name: "Ayam Geprek Keju", price: "24.000", img: "https://placehold.co/300x200/png?text=Keju", category: "Ayam" },

  { name: "Mie Goreng Spesial", price: "12.000", img: "https://placehold.co/300x200/png?text=Mie+Goreng", category: "Mie" },
  { name: "Mie Rebus Bakso", price: "13.000", img: "https://placehold.co/300x200/png?text=Mie+Rebus", category: "Mie" },

  { name: "Es Teh Manis", price: "3.000", img: "https://placehold.co/300x200/png?text=Es+Teh", category: "Minuman" },
  { name: "Es Jeruk Segar", price: "4.000", img: "https://placehold.co/300x200/png?text=Es+Jeruk", category: "Minuman" },

  { name: "Paket Hemat Ayam + Minuman", price: "25.000", img: "https://placehold.co/300x200/png?text=Paket+Combo+1", category: "Paket Combo" },
  { name: "Paket Mie + Minuman", price: "22.000", img: "https://placehold.co/300x200/png?text=Paket+Combo+2", category: "Paket Combo" }
];

const categories = ["Ayam", "Mie", "Minuman", "Paket Combo"];
const selectedCategory = ref("Ayam");

const filteredMenus = computed(() =>
  menus.filter(m => m.category === selectedCategory.value)
);

function goToDetail(name) {
  router.push({ name: "DetailMenu", params: { name: encodeURIComponent(name) } });
}
</script>
