<template>
  <div class="flex flex-col gap-2 w-28">
    <DetailButton class :row="item" />
  </div>
</template>

<script setup>
import DetailButton from "@/components/admin/RowButton/DetailButton.vue";

defineProps({
  item: Object,
});
</script>
