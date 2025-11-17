<template>
  <button
    class="flex items-center gap-1 px-3 py-1.5 text-xs font-medium rounded-md
           bg-white border border-gray-300 text-gray-700
           hover:bg-gray-100 hover:border-gray-400 transition-all duration-150"
  >
    <Eye class="w-4 h-4" />
    <span>Detail</span>
  </button>
</template>

<script setup>
import { Eye } from "lucide-vue-next";
</script>
