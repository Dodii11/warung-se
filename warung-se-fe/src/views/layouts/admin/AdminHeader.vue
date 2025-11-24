<template>
  <header
    class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-10 sticky top-0 z-30"
  >
    <!-- Mobile menu button -->
    <button class="md:hidden" @click="$emit('openMobile')">
      <Menu class="w-6 h-6 text-gray-700" />
    </button>

    <!-- Collapse button (desktop)
    <button class="hidden md:block" @click="$emit('toggleCollapse')">
      <ChevronLeft
        class="w-6 h-6 text-gray-700 transition-transform duration-300"
        :class="collapsed ? 'rotate-180' : ''"
      />
    </button> -->

    <div class="flex-1"></div>

    <!-- User Area -->
    <div class="flex items-center gap-3">
      <div class="text-right">
        <p class="text-sm font-medium text-gray-900">Admin</p>
        <p class="text-xs text-gray-500">Administrator</p>
      </div>

      <UserRound alt="User Avatar" class="w-10 h-10" />
    </div>
  </header>
</template>

<script setup>
import { Menu, UserRound } from "lucide-vue-next";
// import { ChevronLeft } from "lucide-vue-next";

// defineProps({
//   collapsed: Boolean
// });
</script>
