<template>
  <span
    class="px-3 py-1 text-xs font-semibold rounded-full whitespace-nowrap inline-flex items-center gap-1.5"
    :class="badgeClass.classes"
  >
    <component :is="badgeClass.icon" class="w-3 h-3" />
    {{ status }}
  </span>
</template>

<script setup>
import { computed } from 'vue';
import {
    CheckCircleIcon, XCircleIcon, ShieldCheckIcon, UserIcon
} from 'lucide-vue-next';

const props = defineProps({
  status: {
    type: String,
    required: true,
    validator: (value) => ['Aktif', 'Nonaktif', 'SuperAdmin', 'Admin'].includes(value),
  }
});

const badgeClass = computed(() => {
  const base = "font-medium border";
  switch (props.status) {
    case 'Aktif':
      return {
        classes: `${base} bg-green-100 text-green-800 border-green-200`,
        icon: CheckCircleIcon,
      };
    case 'Nonaktif':
      return {
        classes: `${base} bg-red-100 text-red-800 border-red-200`,
        icon: XCircleIcon,
      };
    case 'Admin':
    case 'SuperAdmin': // Role: Menggunakan warna yang sama untuk peran admin
      return {
        classes: `${base} bg-blue-100 text-blue-800 border-blue-200`,
        icon: ShieldCheckIcon,
      };
    default:
      return {
        classes: `${base} bg-gray-100 text-gray-800 border-gray-200`,
        icon: UserIcon,
      };
  }
});
</script>
