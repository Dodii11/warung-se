<!-- src/components/admin/user/UserSearch.vue -->
<template>
  <div class="w-full md:w-72">
    <BaseInput
      v-model="keyword"
      placeholder="Cari berdasarkan ID, nama..."
      @update:modelValue="emitSearch"
    />
  </div>
</template>

<script setup>
import { ref } from "vue";
import BaseInput from "@/components/base/BaseInput.vue";

const keyword = ref("");

const emit = defineEmits(["update:search"]);

const emitSearch = () => {
  emit("update:search", keyword.value);
};
</script>
