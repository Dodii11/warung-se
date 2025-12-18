<template>
  <div>Logging in...</div>
</template>

<script setup>
import { useAuth } from "@/stores/auth";
import { useRouter } from "vue-router";

const auth = useAuth();
const router = useRouter();

const token = new URLSearchParams(window.location.search).get("token");

(async () => {
  if (!token) {
    router.replace("/login");
    return;
  }

  // simpan token saja dulu
  localStorage.setItem("token", token);
  auth.token = token;
  auth.isLoggedIn = true;

  // load user dari API
  await auth.ensureUserLoaded();

  router.replace("/");
})();
</script>
