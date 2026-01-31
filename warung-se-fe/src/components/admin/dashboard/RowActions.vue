<template>
  <div class="flex flex-col gap-2 w-28">
    <DetailButton :row="item" @click="emit('detail', item)" />
  </div>
</template>

<script setup>
import DetailButton from "@/components/admin/RowButton/DetailButton.vue";

defineProps({
  item: Object,
});

const emit = defineEmits(["detail"])

</script>
