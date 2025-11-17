<template>
  <span
    class="px-3 py-1 text-xs font-semibold rounded-full"
    :class="badgeClass"
  >
    {{ props.status }}
  </span>
</template>
<script setup>
import { computed } from 'vue'

const props = defineProps({
  status: { type: String, required: true },
})

const badgeClass = computed(() => {
  switch (props.status) {
    case "Selesai":
      return "bg-green-100 text-green-700"
    case "Tertunda":
      return "bg-yellow-100 text-yellow-700"
    case "Diproses":
      return "bg-blue-100 text-blue-700"
    case "Gagal":
      return "bg-red-100 text-red-700"
    case "Dikirim":
      return "bg-cyan-100 text-cyan-700"
    default:
      return "bg-gray-100 text-gray-700"
  }
})
</script>

