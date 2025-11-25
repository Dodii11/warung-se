<template>
  <div class="relative w-full md:w-64">
    <Search class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" />

    <input
      :value="modelValue"
      @input="onInput"
      :placeholder="placeholder"
      type="text"
      class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary/50 outline-none"
    />
  </div>
</template>

<script setup>
import { Search } from "lucide-vue-next";

defineProps({
  modelValue: String,
  placeholder: {
    type: String,
    default: "Cari...",
  },
});

const emit = defineEmits(["update:modelValue"]);

const onInput = (e) => {
  emit("update:modelValue", e.target.value);
};
</script>
