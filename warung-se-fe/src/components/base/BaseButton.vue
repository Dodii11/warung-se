<template>
  <button
    :class="[
      'font-medium rounded-lg transition-all duration-300 flex items-center justify-center gap-2 focus:outline-none transform active:scale-[0.98]',
      sizeClasses,
      variantClasses,
      { 'opacity-70 cursor-not-allowed': disabled || loading }
    ]"
    :disabled="disabled || loading"
  >
    <slot name="icon-left" />
    <span v-if="!loading" class="flex items-center gap-2">
      <slot />
    </span>
    <span v-else class="flex items-center gap-2">
      <svg
        class="animate-spin w-5 h-5 text-white"
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
      >
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z" />
      </svg>
      Loading...
    </span>
    <slot name="icon-right" />
  </button>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  variant: { type: String, default: 'primary' },
  size: { type: String, default: 'md' },
  disabled: { type: Boolean, default: false },
  loading: { type: Boolean, default: false },
})

const sizeClasses = computed(() => {
  switch (props.size) {
    case 'sm':
      return 'px-3 py-2 text-sm'
    case 'lg':
      return 'px-6 py-3 text-lg'
    default:
      return 'px-4 py-2.5 text-base'
  }
})

const variantClasses = computed(() => {
  switch (props.variant) {
    case 'secondary':
      return 'bg-white border border-[var(--color-primary)] text-[var(--color-primary)] hover:bg-[color:var(--color-primary)/0.08]'
    case 'outline-gray':
      return 'bg-transparent border border-[var(--color-gray-300)] text-[var(--color-gray-600)] hover:bg-[var(--color-gray-100)]'
    case 'google':
      return 'bg-[#4285F4] text-white hover:bg-[#3367D6] shadow-md hover:shadow-lg'
    default:
      return 'bg-[var(--color-primary)] text-white hover:bg-[var(--color-primary-dark)] shadow-md hover:shadow-lg'
  }
})
</script>
