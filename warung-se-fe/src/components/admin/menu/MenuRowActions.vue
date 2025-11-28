<template>
  <div class="flex flex-col gap-2 w-28">
    <DetailButton @click="$emit('detail', item)"> </DetailButton>
    <EditButton @click="$emit('edit', item)"> </EditButton>
    <DeleteButton @click="$emit('delete', item)"> </DeleteButton>
  </div>
</template>

<script setup>
import DetailButton from "../RowButton/DetailButton.vue";
import EditButton from "../RowButton/EditButton.vue";
import DeleteButton from "../RowButton/DeleteButton.vue";

defineProps({
  item: Object,
});

defineEmits(["edit", "detail", "delete", "toggle-status"]);
</script>
