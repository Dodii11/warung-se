<template>
    <BaseSearch
      v-model="keyword"
      placeholder="Cari ID atau nama..."
      @update:modelValue="emitSearch"
    />
</template>

<script setup>
import { ref } from "vue";
import BaseSearch from "@/components/base/BaseSearch.vue";

const keyword = ref("");

const emit = defineEmits(["update:search"]);

const emitSearch = () => {
  emit("update:search", keyword.value);
};
</script>
