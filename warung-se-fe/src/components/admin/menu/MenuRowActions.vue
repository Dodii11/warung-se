<template>
  <div class="flex flex-col gap-2 w-28">
    <DetailButton class :row="item" />
    <EditButton class :row="item" />
    <DeleteButton class :row="item" />
  </div>
</template>

<script setup>
import DetailButton from "@/components/admin/RowButton/DetailButton.vue";
import DeleteButton from "../RowButton/DeleteButton.vue";
import EditButton from "../RowButton/EditButton.vue";

defineProps({
  item: Object,
});
</script>
