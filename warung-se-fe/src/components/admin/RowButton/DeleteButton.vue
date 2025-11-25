<template>
  <button
    @click="handleDelete"
    class="flex items-center gap-1 px-3 py-1.5 text-xs font-medium rounded-md
           bg-red-50 text-red-600 border border-red-200
           hover:bg-red-100 transition-all duration-150"
  >
    <Trash class="w-4 h-4" />
    <span>Hapus</span>
  </button>
</template>

<script setup>
import { Trash } from "lucide-vue-next";

const emit = defineEmits(["delete"]);
const handleDelete = () => emit("delete");
</script>
