<script setup>
import { RouterLink } from 'vue-router'
import { useAuthStore } from '@/stores/authStore'

// "otak" (dummy data)
const auth = useAuthStore()
</script>

<template>
  <nav style="background-color: #f0f0f0; padding: 1rem;">
    <strong>Warung SE</strong>
    <hr>

    <RouterLink to="/">Home</RouterLink> |
    <RouterLink to="/login">Login</RouterLink> |

    <RouterLink
      v-if="auth.isLoggedIn && auth.user.role === 'admin'"
      to="/admin">
      Admin Dashboard
    </RouterLink>

    <RouterLink
      v-if="auth.isLoggedIn && auth.user.role === 'user'"
      to="/orders">
      Pesanan Saya
    </RouterLink>
  </nav>
</template>
