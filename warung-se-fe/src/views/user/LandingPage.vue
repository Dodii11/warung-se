<template>
  <UserLayout>
  <!-- <div class="min-h-screen bg-white"> -->
    <!-- 🔴 Navbar -->
    <!-- <Navbar /> -->

    <!-- 🔥 Hero Section -->
    <section class="max-w-7xl mx-auto px-6 py-16 grid md:grid-cols-2 gap-10">
      <div class="flex flex-col justify-center space-y-4">
        <h1 class="text-4xl md:text-5xl font-bold leading-tight text-gray-900">
          Nikmati Kelezatan <br />
          Ayam Geprek <br />
          Tercihuyy
        </h1>

        <p class="text-gray-600 text-lg leading-relaxed">
          Kombinasi sempurna antara ayam krispi, sambal pedas yang menggugah selera, dan nasi hangat.
        </p>

        <button class="button-text bg-red-600 hover:bg-red-700 px-5 py-3 rounded-lg shadow-md w-fit">
          Pesan Sekarang
        </button>
      </div>

  <div class="flex justify-center items-center">
    <img
      :src="heroImg"
      class="rounded-xl shadow-lg w-full h-auto object-cover"
      alt="Hero Image"
        />
      </div>
    </section>

    <!-- ⭐ Menu Unggulan -->
    <section class="py-10">
      <h2 class="text-center text-2xl font-bold mb-6">Menu Unggulan</h2>

      <div class="flex justify-center space-x-6 mb-6 text-sm font-medium">
        <span class="cursor-pointer text-red-600 border-b-2 border-red-600 pb-1">Ayam</span>
        <span class="cursor-pointer text-gray-600 hover:text-red-600 pb-1">Mie</span>
        <span class="cursor-pointer text-gray-600 hover:text-red-600 pb-1">Minuman</span>
        <span class="cursor-pointer text-gray-600 hover:text-red-600 pb-1">Paket Hemat</span>
      </div>

      <div class="max-w-7xl mx-auto px-4 grid md:grid-cols-5 sm:grid-cols-2 gap-6">
        <div
          v-for="(item, index) in menus"
          :key="index"
          class="bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition p-3"
        >
          <img :src="item.img" class="rounded-md w-full h-32 object-cover" />

          <h3 class="mt-3 font-semibold text-gray-900">{{ item.name }}</h3>

          <p class="text-red-600 font-bold text-sm">Rp {{ item.price }}</p>

          <div class="mt-2">
            <DetailButton />
          </div>
        </div>
      </div>
    </section>

    <!-- 🧑‍🍳 Tentang Kami -->
    <section class="max-w-7xl mx-auto px-6 py-16">
      <div class="bg-gray-50 shadow-md rounded-xl p-8 grid md:grid-cols-2 gap-10 items-center">

        <div>
          <h2 class="text-2xl font-bold mb-3">Tentang Kami</h2>

          <h3 class="text-lg font-semibold text-red-600 mb-2">Warung Serba Enak</h3>

          <p class="text-gray-600 leading-relaxed">
            Selamat datang di WarungSE, sensasi rasa ayam geprek bukan sekadar makanan,
            tetapi kebahagiaan dalam setiap suap yang tak terlupakan. Kami percaya bahwa
            setiap hidangan harus spesial. Karena itu, kami hanya menggunakan ayam segar pilihan
            yang digeprek hingga renyah sempurna, lalu disajikan dengan sambal dadakan yang pedas
            tetapi tetap menggugah selera Anda.
          </p>
        </div>

   <div class="flex justify-center items-center">
    <img
      :src="heroImg2"
      class="rounded-xl shadow-lg w-full h-auto object-cover"
      alt="Hero Image"
    />
  </div>

      </div>
    </section>

    <!-- 📞 Hubungi Kami -->
    <section class="text-center py-10">
      <h2 class="text-xl font-bold mb-4">Hubungi Kami</h2>
      <p class="text-gray-700">Punya pertanyaan atau masukan? Kami siap membantu!</p>
      <p class="text-gray-700">Telepon: <strong>0812-0000-0000</strong> | Email: support@warungse.com</p>
    </section>

    <!-- ⚫ Footer -->
    <!-- <footer class="bg-red-600 text-white py-4 text-center">
      <p>© 2025 WarungSE. Semua hak dilindungi.</p>
    </footer>
  </div> -->
  </UserLayout>
</template>

<script setup>
import UserLayout from "../layouts/UserLayout.vue";
import Navbar from "@/components/Navbar.vue";
import DetailButton from "@/components/DetailButton.vue";
import heroImg from '@/assets/Ayam Geprek.png'
import heroImg2 from '@/assets/Restaurant Interior.png'


const menus = [
  {
    name: "Ayam Geprek Sambal Matah",
    price: "20.000",
    img: "https://i.ibb.co/WpfYrY8/matah.jpg",
  },
  {
    name: "Ayam Geprek Saus Lada Hitam",
    price: "22.000",
    img: "https://i.ibb.co/Np8Skhq/ladahitam.jpg",
  },
  {
    name: "Ayam Geprek Keju",
    price: "24.000",
    img: "https://i.ibb.co/t2CtrWn/keju.jpg",
  },
  {
    name: "Ayam Geprek Sambal Terasi",
    price: "20.000",
    img: "https://i.ibb.co/cNyR7gV/terasi.jpg",
  },
  {
    name: "Ayam Geprek Sambal Ijo",
    price: "20.000",
    img: "https://i.ibb.co/WKxYkbW/ijo.jpg",
  },
];
</script>

<style scoped>
</style>
