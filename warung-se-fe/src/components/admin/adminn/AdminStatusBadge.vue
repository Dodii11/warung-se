<template>
  <span :class="badgeClass">
    {{ status }}
  </span>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  status: {
    type: String,
    required: true,
    // Validator untuk memastikan nilai status yang diterima adalah salah satu dari daftar
    validator: (value) => ['Aktif', 'Nonaktif', 'SuperAdmin', 'Admin'].includes(value),
  }
});

const badgeClass = computed(() => {
  const base = "px-3 py-1 rounded-full text-xs font-medium whitespace-nowrap";
  switch (props.status) {
    case 'Aktif':
      return `${base} bg-green-100 text-green-800`;
    case 'Nonaktif':
      return `${base} bg-red-100 text-red-800`;
    case 'SuperAdmin':
      return `${base} bg-yellow-100 text-yellow-800`;
    case 'Admin':
      return `${base} bg-blue-100 text-blue-800`;
    default:
      return `${base} bg-gray-100 text-gray-800`;
  }
});
</script>
