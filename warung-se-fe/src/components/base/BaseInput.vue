<!-- src/components/base/BaseInput.vue -->
<template>
  <div class="w-full">
    <label v-if="label" class="block text-sm font-medium mb-1 text-gray-700">
      {{ label }}
    </label>
    <input
      :type="type"
      :placeholder="placeholder"
      v-model="model"
      class="w-full px-4 py-3 border rounded-lg text-sm transition-all focus:outline-none focus:ring-2 focus:ring-[#E53935] focus:border-transparent"
      :class="error ? 'border-red-500' : 'border-gray-300'"
    />
    <p v-if="error" class="text-red-500 text-xs mt-1">{{ error }}</p>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  label: String,
  placeholder: String,
  type: { type: String, default: 'text' },
  modelValue: [String, Number],
  error: String,
})

const emit = defineEmits(['update:modelValue'])
const model = computed({
  get: () => props.modelValue,
  set: (val) => emit('update:modelValue', val),
})
</script>
