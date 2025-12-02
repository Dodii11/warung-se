<template>
  <BaseDropdown
    v-model="model"
    :options="options"
    placeholder="Filter Status"
  />
</template>

<script setup>
import { computed } from "vue";
import BaseDropdown from "@/components/base/BaseDropdown.vue"; // Asumsi path BaseDropdown

const props = defineProps({
  // modelValue harus sesuai dengan nama state yang di-bind di parent (filterStatus)
  modelValue: { type: String, default: "Semua" }
});

const emit = defineEmits(["update:modelValue"]);

// Opsi status akun yang tersedia
const options = [
  "Semua",
  "Aktif",
  "Nonaktif",
];

const model = computed({
  get: () => props.modelValue,
  // Mengirimkan nilai terpilih kembali ke parent component
  set: (v) => emit("update:modelValue", v)
});
</script>
