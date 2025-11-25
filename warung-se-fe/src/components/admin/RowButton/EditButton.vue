<template>
  <button
    class="flex items-center gap-1 px-3 py-1.5 text-xs font-medium rounded-md
           bg-blue-50 text-blue-600 border border-blue-200
           hover:bg-blue-100 transition-all duration-150"
  >
    <Pencil class="w-4 h-4" />
    <span>Edit</span>
  </button>
</template>

<script setup>
import { Pencil } from "lucide-vue-next"
</script>
