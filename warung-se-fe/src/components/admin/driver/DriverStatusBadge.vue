<!-- src/components/admin/driver/DriverStatusBadge.vue -->
<template>
  <span
    class="px-3 py-1 text-xs font-semibold rounded-full whitespace-nowrap inline-flex items-center gap-1.5"
    :class="badge.classes"
  >
    <component :is="badge.icon" class="w-3 h-3" />
    {{ status }}
  </span>
</template>

<script setup>
import { computed } from "vue";
import { XCircleIcon, CheckCircleIcon, ClockIcon } from "lucide-vue-next";

const props = defineProps({
  status: String,
});

const badge = computed(() => {
  switch (props.status) {
    case "Tidak Aktif":
      return {
        classes: "bg-red-100 text-red-700 border border-red-200",
        icon: XCircleIcon,
      };
    case "Tersedia":
      return {
        classes: "bg-green-100 text-green-700 border border-green-200",
        icon: CheckCircleIcon,
      };
    case "Sedang Pengiriman":
      return {
        classes: "bg-yellow-100 text-yellow-700 border border-yellow-200",
        icon: ClockIcon,
      };
    default:
      return {
        classes: "bg-gray-100 text-gray-700 border border-gray-200",
        icon: ClockIcon,
      };
  }
});
</script>
