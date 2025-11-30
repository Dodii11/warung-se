<template>
  <div class="flex flex-col gap-2 w-28">
    <!-- DETAIL: Emit event 'detail' dengan data 'item' -->
    <DetailButton @click="$emit('detail', item)" />

    <!-- EDIT: Emit event 'edit' dengan data 'item' -->
    <EditButton @click="$emit('edit', item)" />

    <!-- DELETE: Emit event 'delete' dengan data 'item' -->
    <DeleteButton @click="$emit('delete', item)" />
  </div>
</template>

<script setup>
import DetailButton from "../RowButton/DetailButton.vue";
import EditButton from "../RowButton/EditButton.vue";
import DeleteButton from "../RowButton/DeleteButton.vue";

defineProps({
  item: Object,
});

// Definisikan semua event yang akan dipancarkan ke parent view
defineEmits(["edit", "detail", "delete"]);
</script>
