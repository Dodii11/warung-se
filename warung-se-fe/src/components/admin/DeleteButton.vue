<template>
  <button
    class="text-red-600 hover:text-red-800 text-sm font-medium flex items-center gap-1"
    @click="handleDelete"
  >
    <Trash class="w-4 h-4" />
    Hapus
  </button>
</template>

<script setup>
import { Trash } from "lucide-vue-next";

const emit = defineEmits(["delete"]);
const handleDelete = () => emit("delete");
</script>
