<template>
  <div
    :class="[
      'bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300 ease-out',
      paddingClasses,
      'text-gray-800'
    ]"
  >
    <slot />
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  padding: { type: String, default: 'md' }
})

const paddingClasses = computed(() => {
  switch (props.padding) {
    case 'sm': return 'p-4'
    case 'lg': return 'p-10'
    default: return 'p-6'
  }
})
</script>
