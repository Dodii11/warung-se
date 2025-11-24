<template>
  <BaseSearch
    v-model="keyword"
    placeholder="Cari pesanan..."
    @update:modelValue="emitSearch"
  />
</template>

<script setup>
import { ref } from "vue";
import BaseSearch from "@/components/base/BaseSearch.vue";

const emit = defineEmits(["update:search"]);
const keyword = ref("");

const emitSearch = (val) => {
  emit("update:search", val);
};
</script>
