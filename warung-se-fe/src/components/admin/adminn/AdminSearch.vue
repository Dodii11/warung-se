<template>
  <BaseSearch
    v-model="keyword"
    placeholder="Cari ID atau nama..."
    @update:modelValue="emitSearch"
  />
</template>

<script setup>
import { ref } from "vue"
import BaseSearch from "@/components/base/BaseSearch.vue"

const emit = defineEmits(["update:modelValue"])
const keyword = ref("")

const emitSearch = (val) => {
  emit("update:modelValue", val)
}
</script>
