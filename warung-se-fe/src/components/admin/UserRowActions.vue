<!-- src/components/admin/user/UserRowActions.vue -->
<template>
  <div class="flex items-center gap-3">

    <!-- Tombol Detail -->
    <BaseButton size="sm" variant="outline-gray">
      Detail
    </BaseButton>

    <!-- Lihat Pesanan -->
    <button
      class="text-primary text-sm font-medium hover:underline"
      @click="viewOrders"
    >
      Lihat Pesanan
    </button>

  </div>
</template>

<script setup>
import BaseButton from "@/components/base/BaseButton.vue";

const props = defineProps({
  row: Object,
});

const viewOrders = () => {
  console.log("Lihat pesanan untuk:", props.row.id);
};
</script>
