<template>
  <div class="flex flex-col gap-2 w-28">
    <DetailButton :row="item" @click="emit('detail', item)"/>
    <EditButton :row="item " @click="emit('edit', item)"/>
  </div>
</template>

<script setup>
import DetailButton from "../RowButton/DetailButton.vue";
import EditButton from "../RowButton/EditButton.vue";

defineProps({
  item: Object,
});

const emit = defineEmits(["detail", "edit"])

</script>
