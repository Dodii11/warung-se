<template>
  <span
    :class="[
      'cursor-pointer pb-1.5 transition-all duration-300 px-5 py-2 rounded-full text-center text-sm sm:text-base font-medium whitespace-nowrap',
      isActive
        ? 'bg-red-600 text-white shadow-md shadow-red-300/50 font-bold transform scale-105'
        : 'bg-white text-gray-700 border border-gray-200 hover:bg-red-50 hover:text-red-600',
    ]"
    @click="$emit('click')"
  >
    <slot />
  </span>
</template>

<script setup>
// Komponen dasar untuk tombol kategori dengan styling konsisten
defineProps({
  // Menentukan apakah tombol ini sedang aktif
  isActive: {
    type: Boolean,
    default: false,
  },
});

defineEmits(['click']);
</script>
