<template>
  <div class="flex items-center gap-2">
    <DetailButton :row="item" />
    <!-- Tambahan aksi lain nanti tinggal taruh sini -->
  </div>
</template>

<script setup>
import DetailButton from './DetailButton.vue';

defineProps({
  item: Object
})
</script>
