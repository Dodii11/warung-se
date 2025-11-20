<!-- src/components/admin/driver/DriverRowActions.vue -->
<template>
  <div class="flex items-center gap-4">

    <button
      class="text-primary text-sm font-medium hover:underline"
      @click="detail"
    >
      Lihat Detail
    </button>

    <button
      class="text-red-500 text-sm font-medium hover:underline"
      @click="assign"
    >
      Tetapkan Pesanan
    </button>

  </div>
</template>

<script setup>
const props = defineProps({
  row: Object,
});

const detail = () => {
  console.log("Detail driver:", props.row);
};

const assign = () => {
  console.log("Tetapkan pesanan untuk:", props.row);
};
</script>
