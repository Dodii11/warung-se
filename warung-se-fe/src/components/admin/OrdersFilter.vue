<template>
  <div class="flex flex-wrap items-center gap-3">
    <!-- Filter Status -->
    <select
      v-model="localStatus"
      @change="emitFilter"
      class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/50 outline-none"
    >
      <option value="">Semua Status</option>
      <option value="Selesai">Selesai</option>
      <option value="Tertunda">Tertunda</option>
      <option value="Diproses">Diproses</option>
      <option value="Gagal">Gagal</option>
      <option value="Dikirim">Dikirim</option>
    </select>

    <!-- Filter Date Range (optional) -->
    <input
      v-model="localDate"
      @change="emitFilter"
      type="date"
      class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/50 outline-none"
    />
  </div>
</template>

<script setup>
import { ref } from "vue";

const localStatus = ref("");
const localDate = ref("");

const emit = defineEmits(["update:filter"]);

const emitFilter = () => {
  emit("update:filter", {
    status: localStatus.value,
    date: localDate.value
  });
};
</script>
