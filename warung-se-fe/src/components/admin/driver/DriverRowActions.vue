<template>
  <!-- Menghapus Modal Driver dari sini -->
  <div class="flex flex-col gap-2 w-28">
    <!-- openModal(mode) diganti dengan emit event(item) -->
    <DetailButton @click="$emit('detail', item)" />
    <EditButton @click="$emit('edit', item)" />
    <!-- confirmDelete diganti dengan emit delete(item) -->
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

defineEmits(["edit", "detail", "delete"]);
</script>
