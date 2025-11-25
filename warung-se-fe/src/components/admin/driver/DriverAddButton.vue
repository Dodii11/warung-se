<!-- src/components/admin/driver/DriverAddButton.vue -->
<template>
  <BaseButton
    variant="primary"
    size="sm"
    class="rounded-full px-4 py-2 flex items-center gap-2"
    @click="create"
  >
    <Plus class="w-4 h-4" />
    Tambahkan Driver
  </BaseButton>
</template>

<script setup>
import BaseButton from "@/components/base/BaseButton.vue";
import { Plus } from "lucide-vue-next";

const create = () => {
  console.log("Tambah driver");
};
</script>
