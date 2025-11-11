<!-- src/components/base/BaseCard.vue -->
<template>
  <div
    :class="[
      'bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300',
      paddingClasses
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
