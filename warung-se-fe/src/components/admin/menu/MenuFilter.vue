<template>
  <BaseDropdown
    v-model="model"
    :options="options"
  />
</template>

<script setup>
import { computed } from "vue"
import BaseDropdown from "@/components/base/BaseDropdown.vue"

const props = defineProps({
  modelValue: [String, Number],
  options: { type: Array, default: () => [] }
})

const emit = defineEmits(["update:modelValue"])

const model = computed({
  get: () => props.modelValue,
  set: (v) => emit("update:modelValue", v)
})
</script>
