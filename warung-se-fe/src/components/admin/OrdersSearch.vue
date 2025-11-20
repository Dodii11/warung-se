<template>
  <div class="w-full md:w-64">
    <input
      v-model="keyword"
      @input="emitSearch"
      type="text"
      placeholder="Cari pesanan..."
      class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary/50 outline-none"
    />
  </div>
</template>

<script setup>
import { ref } from "vue";
const keyword = ref("");

const emit = defineEmits(["update:search"]);
const emitSearch = () => emit("update:search", keyword.value);
</script>
