<template>
  <BaseDropdown
    v-model="model"
    :options="options"
  />
</template>

<script setup>
import { computed } from "vue";
import BaseDropdown from "@/components/base/BaseDropdown.vue";

const props = defineProps({
  modelValue: { type: String, default: "Status" }
});

const emit = defineEmits(["update:modelValue"]);

const options = [
  "Status",
  "Tersedia",
  "Sedang Pengiriman",
  "Tidak Aktif"
];

const model = computed({
  get: () => props.modelValue,
  set: (v) => emit("update:modelValue", v)
});
</script>
