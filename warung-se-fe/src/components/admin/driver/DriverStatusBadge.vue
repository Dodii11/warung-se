<!-- src/components/admin/driver/DriverStatusBadge.vue -->
<template>
  <span
    class="px-3 py-1 text-xs font-semibold rounded-full whitespace-nowrap"
    :class="badge"
  >
    {{ status }}
  </span>
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
  status: String
});

const badge = computed(() => {
  switch (props.status) {
    case "Tidak Aktif":
      return "bg-red-100 text-red-700";
    case "Tersedia":
      return "bg-green-100 text-green-700";
    case "Sedang Pengiriman":
      return "bg-yellow-100 text-yellow-700";
    default:
      return "bg-gray-100 text-gray-700";
  }
});
</script>
