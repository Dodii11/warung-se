<!-- src/components/base/BaseInput.vue -->
<template>
  <div class="w-full flex flex-col gap-1.5">
    <label
      v-if="label"
      class="text-sm font-medium text-gray-700 tracking-wide"
    >
      {{ label }}
    </label>

    <input
      :type="type"
      :placeholder="placeholder"
      v-model="model"
      :class="[
        'w-full px-4 py-2.5 rounded-lg text-sm transition-all border outline-none',
        'focus:ring-2 focus:ring-offset-1 focus:ring-[#E53935]',
        error ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-transparent',
      ]"
    />

    <p v-if="error" class="text-xs text-red-500 mt-0.5 font-medium">
      {{ error }}
    </p>
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
