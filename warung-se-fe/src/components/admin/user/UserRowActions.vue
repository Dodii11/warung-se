<template>
  <div class="flex flex-col gap-2 w-28">
    <DetailButton @click="$emit('detail', item)"> </DetailButton>
  </div>
</template>

<script setup>
import DetailButton from "../RowButton/DetailButton.vue";

defineProps({
  item: Object,
});

defineEmits(["detail"]);
</script>
