<!-- src/components/user/UserProfileTabs.vue -->
<template>
  <div class="flex border-b mb-6">
    <!-- Tab Profil -->
    <router-link 
      to="/user/profile"
      :class="[
        'px-4 py-2 font-medium',
        isActive('UserProfile') ? 'border-b-2 border-red-500 text-red-600' : 'text-gray-600'
      ]"
    >
      Profil
    </router-link>

    <!-- Tab Pesanan -->
    <router-link 
      to="/user/orders"
      :class="[
        'px-4 py-2 font-medium',
        isActive('UserPesanan') ? 'border-b-2 border-red-500 text-red-600' : 'text-gray-600'
      ]"
    >
      Pesanan
    </router-link>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { useRoute } from 'vue-router'

const route = useRoute()

// Cek apakah route saat ini adalah route dengan nama tertentu
const isActive = (name) => {
  return route.name === name
}
</script>