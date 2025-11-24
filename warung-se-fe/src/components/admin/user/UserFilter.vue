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
  modelValue: { type: String, default: "asc" }
});

const emit = defineEmits(["update:modelValue"]);

// Label dropdown
const options = [
  "Urutkan ID",
  "ID Terkecil",   // asc
  "ID Terbesar"    // desc
];

// Mapping internal <-> UI
const model = computed({
  get: () => props.modelValue === "asc" ? options[0] : options[1],
  set: (value) => {
    const mapped =
      value === options[0] ? "asc" :
      value === options[1] ? "asc" :
      value === options[2] ? "desc" :
      "asc";

    emit("update:modelValue", mapped);
  }
});
</script>
