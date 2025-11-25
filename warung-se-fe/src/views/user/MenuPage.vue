<template>
  <div class="max-w-7xl mx-auto py-8 px-4">
    <!-- Judul -->
    <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-red-600 mb-2 text-center">
      Menu Kami
    </h1>
    <p class="text-center text-sm sm:text-base text-red-800 mb-8 max-w-md mx-auto">
      Temukan kelezatan renyah di setiap gigitan. Dibuat dengan bahan-bahan segar dan resep rahasia kami.
    </p>

    <!-- Filter Buttons -->
    <div class="flex flex-wrap justify-center gap-2 sm:gap-3 mb-8">
      <button
        v-for="cat in categories"
        :key="cat"
        @click="selectedCategory = cat"
        :class="[
          'px-3 sm:px-4 py-1.5 border rounded-full text-xs sm:text-sm font-semibold transition',
          selectedCategory === cat
            ? 'bg-red-600 text-white border-red-600'
            : 'text-red-600 border-red-600 hover:bg-red-100 hover:text-red-700'
        ]"
      >
        {{ cat }}
      </button>
    </div>

    <!-- Menu Grid -->
    <section>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
        <div
          v-for="(item, idx) in filteredMenus"
          :key="idx"
          class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-100 flex flex-col"
        >
          <!-- Gambar -->
          <div class="bg-gray-200 w-full h-40 sm:h-32 flex items-center justify-center text-gray-400 text-xs sm:text-sm">
            Image Placeholder
          </div>

          <!-- Detail -->
          <div class="p-3 text-gray-900 flex-1 flex flex-col justify-between text-xs sm:text-sm">
            <div>
              <h3 class="font-semibold mb-1 sm:mb-2">{{ item.name }}</h3>
              <p class="text-gray-500 mb-2 sm:mb-3">{{ item.desc }}</p>
              <p class="text-red-600 font-bold mb-3 sm:mb-4">Rp {{ item.price }}</p>
            </div>
            <button
              class="w-full bg-red-600 text-white text-xs sm:text-sm font-semibold rounded-md py-1.5 hover:bg-red-700 transition"
              @click="goToDetail(item.name)"
            >
              Pesan Sekarang
            </button>
          </div>
        </div>
      </div>
    </section>
  </div>

<Footer />
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'
import Footer from '@/components/Footer.vue'  

const router = useRouter()

const categories = ['Ayam', 'Mie', 'Minuman', 'Paket Combo']
const selectedCategory = ref('Ayam')

const menus = [
  { name: 'Ayam Geprek Original', price: '15.000', desc: 'Potongan ayam krispi.', category: 'Ayam' },
  { name: 'Ayam Geprek Keju', price: '18.000', desc: 'Ayam geprek dengan saus keju.', category: 'Ayam' },
  { name: 'Ayam Geprek Sambal Matah', price: '20.000', desc: 'Ayam geprek Sambal Matah.', category: 'Ayam' },
  { name: 'Mie Goreng Spesial', price: '12.000', desc: 'Mie goreng dengan bumbu rahasia.', category: 'Mie' },
  { name: 'Mie Rebus Bakso', price: '13.000', desc: 'Mie rebus dengan bakso kenyal.', category: 'Mie' },
  { name: 'Es Teh', price: '3.000', desc: 'Es teh manis segar.', category: 'Minuman' },
  { name: 'Es Jeruk', price: '4.000', desc: 'Es jeruk segar.', category: 'Minuman' },
  { name: 'Paket Hemat Ayam + Minuman', price: '25.000', desc: 'Ayam geprek + es teh.', category: 'Paket Combo' },
  { name: 'Paket Mie + Minuman', price: '22.000', desc: 'Mie goreng + jus jeruk.', category: 'Paket Combo' },
]

const filteredMenus = computed(() =>
  menus.filter(item => item.category === selectedCategory.value)
)

function goToDetail(name) {
  router.push({ name: 'DetailMenu', params: { name: encodeURIComponent(name) } })
}
</script>
