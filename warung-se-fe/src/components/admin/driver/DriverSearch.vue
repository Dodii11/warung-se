<template>
  <BaseInput
    v-model="local"
    placeholder="Cari id/nama..."
    class="w-full"
    @input="emitSearch"
  />
</template>

<script setup>
import { ref } from "vue";
import BaseInput from "@/components/base/BaseInput.vue";

const emit = defineEmits(["update:search"]);
const local = ref("");

const emitSearch = () => {
  emit("update:search", local.value);
};
</script>
