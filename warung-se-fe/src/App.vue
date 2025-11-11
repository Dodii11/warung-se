<script setup>
import { RouterView } from 'vue-router'
import Navbar from './components/Navbar.vue';
</script>

<template>
    <Navbar /> <main style="padding: 1rem;">
    <RouterView />
  </main>
</template>

<style scoped>
</style>
