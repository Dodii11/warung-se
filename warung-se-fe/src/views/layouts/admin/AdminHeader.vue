<template>
  <header
    class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-10 sticky top-0 z-30"
  >
    <!-- Mobile menu button -->
    <button class="md:hidden" @click="$emit('openMobile')">
      <Menu class="w-6 h-6 text-gray-700" />
    </button>

    <div class="flex-1"></div>

    <!-- User Area -->
    <div class="flex items-center gap-3">
      <div class="text-right">
        <p class="text-sm font-medium text-gray-900">
          {{ user.nama_user || 'Guest' }}
        </p>
        <p class="text-xs text-gray-500">
          {{ user.email || '' }}
        </p>
      </div>

      <img
        src="https://ui-avatars.com/api/?name=Admin&background=E53935&color=fff"
        alt="User Avatar"
        class="w-10 h-10 rounded-full border border-gray-200"
      />
    </div>
  </header>
</template>

<script setup>
import { Menu } from "lucide-vue-next";
// import { ChevronLeft } from "lucide-vue-next";

// Fetch user saat komponen mount
onMounted(async () => {
  await auth.fetchUser(); // ambil user dari API
});

// Ambil user dari store
const user = computed(() => auth.user || {});

// Avatar dinamis
const userAvatar = computed(() => {
  if (user.value.nama_user) {
    return `https://ui-avatars.com/api/?name=${encodeURIComponent(
      user.value.nama_user
    )}&background=E53935&color=fff`;
  }
  return "https://ui-avatars.com/api/?name=Guest&background=E53935&color=fff";
});
</script>
