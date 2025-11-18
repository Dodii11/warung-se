<template>
  <div class="p-10">
    <h1>Login Berhasil!</h1>
    <p>Token: {{ token }}</p>
  </div>
</template>

<script setup>
import { useRoute, useRouter } from 'vue-router'

const route = useRoute()
const router = useRouter()

const token = route.query.token

// Simpan token ke localStorage
localStorage.setItem("token", token)

// Redirect ke dashboard setelah 1 detik
setTimeout(() => {
  router.push('/admin/dashboard')
}, 1000)
</script>
