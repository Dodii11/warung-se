
<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Header Profil -->
    <header class="bg-white border-b border-blue-500 shadow-sm">
      <div class="container mx-auto px-4 py-3 flex items-center justify-between">
        <!-- Kembali -->
        <div class="flex items-center space-x-2">
          <button @click="$router.back()" class="p-2 hover:bg-gray-100 rounded-full">
            <ChevronLeft class="w-5 h-5 text-gray-700" />
          </button>
          <span class="text-gray-700 font-medium">Kembali</span>
        </div>

        <!-- Actions -->
        <div class="flex items-center space-x-4">
          <button 
            @click="logout"
            class="px-4 py-2 bg-red-100 text-red-600 rounded-lg font-medium hover:bg-red-200 transition"
          >
            Logout
          </button>
          <div class="flex items-center space-x-2">
            <span class="text-sm">Halo, User</span>
            <img src="https://placehold.co/30x30?text=U" alt="User" class="w-8 h-8 rounded-full object-cover" />
          </div>
        </div>
      </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
      <router-view />
    </main>

   
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/authStore'
import { ChevronLeft } from 'lucide-vue-next'

const router = useRouter()
const authStore = useAuthStore()

const logout = () => {
  authStore.logout()
  router.push('/login')
}
</script>
