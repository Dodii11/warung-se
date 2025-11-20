<template>
  <div class="flex flex-col gap-2 w-28">
    <DetailButton class="w-28" :row="item" />
    <EditButton class="w-28" :row="item " />
  </div>
</template>

<script setup>
import DetailButton from "../RowButton/DetailButton.vue";
import EditButton from "../RowButton/EditButton.vue";

defineProps({
  item: Object,
});
</script>
