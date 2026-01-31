<!-- src/components/admin/driver/DriverAddButton.vue -->
<template>
  <BaseButton
    variant="primary"
    size="sm"
    @click="create"
  >
    <Plus class="w-4 h-4" />
    Tambah Driver
  </BaseButton>
</template>

<script setup>
import BaseButton from "@/components/base/BaseButton.vue";
import { Plus } from "lucide-vue-next";

const create = () => {
  console.log("Tambah driver");
};
</script>
