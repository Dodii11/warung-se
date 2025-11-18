<template>
  <div class="min-h-screen flex items-center justify-center text-lg">
    Sedang memproses login...
  </div>
</template>

<script setup>
import { onMounted } from "vue";
import { useRoute, useRouter } from "vue-router";
import { useAuthStore } from "@/stores/authStore";

const route = useRoute();
const router = useRouter();
const auth = useAuthStore();

onMounted(async () => {
  const token = route.query.token;
  if (!token) return router.replace("/login");

  try {
    auth.setToken(token);
    await auth.fetchUser(); // optional
  } catch (_) {
    auth.logout();
  } finally {
    router.replace("/admin/dashboard");
  }
});
</script>
