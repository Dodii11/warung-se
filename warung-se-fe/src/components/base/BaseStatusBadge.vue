<template>
  <span
    class="px-3 py-1 text-xs font-semibold rounded-full whitespace-nowrap inline-flex items-center gap-1.5"
    :class="badgeClass.container"
  >
    <!-- Ikon Status -->
    <component :is="badgeClass.icon" class="w-3 h-3" />

    {{ props.status }}
  </span>
</template>

<script setup>
import { computed } from 'vue'
// Import semua ikon yang diperlukan dari Lucide
import { CheckCircleIcon, ClockIcon, LoaderIcon, XCircleIcon, TruckIcon, MinusCircleIcon } from 'lucide-vue-next'

const props = defineProps({
  status: { type: String, required: true },
})

const badgeClass = computed(() => {
  const baseClasses = {
      // Default: Gray
      container: "bg-gray-100 text-gray-700",
      icon: MinusCircleIcon,
  }

  switch (props.status) {
    case "Selesai":
      baseClasses.container = "bg-green-100 text-green-700"
      baseClasses.icon = CheckCircleIcon // Lingkaran Centang
      break
    case "Tertunda":
      baseClasses.container = "bg-yellow-100 text-yellow-700"
      baseClasses.icon = ClockIcon // Jam
      break
    case "Diproses":
      baseClasses.container = "bg-blue-100 text-blue-700"
      baseClasses.icon = LoaderIcon // Loader/Spin (menggambarkan sedang berjalan)
      break
    case "Gagal":
      baseClasses.container = "bg-red-100 text-red-700"
      baseClasses.icon = XCircleIcon // Lingkaran Silang
      break
    case "Dikirim":
      baseClasses.container = "bg-cyan-100 text-cyan-700"
      baseClasses.icon = TruckIcon // Truk (Menggambarkan pengiriman)
      break
    default:
      // Status tidak dikenal
      baseClasses.container = "bg-gray-100 text-gray-700"
      baseClasses.icon = MinusCircleIcon
      break
  }
  return baseClasses
})
</script>
