<template>
  <div class="relative w-full isolate">
    <select
      v-model="model"
      class="appearance-none w-full px-4 py-2.5 pr-10 rounded-lg border border-gray-300 bg-white text-sm text-gray-700 focus:ring-2 focus:ring-red-500/50 focus:border-transparent outline-none transition-all cursor-pointer relative z-10"
    >
      <option v-for="(option, index) in options" :key="index" :value="option">
        {{ option }}
      </option>
    </select>
    <div
      class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-gray-500 flex items-center justify-center z-20"
    >
      <ChevronDown class="w-4 h-4" />
    </div>
  </div>
</template>

<script setup>
import { computed } from "vue";
import { ChevronDown } from "lucide-vue-next";

const props = defineProps({
  modelValue: String,
  options: Array,
});

const emit = defineEmits(["update:modelValue"]);

const model = computed({
  get: () => props.modelValue,
  set: (v) => emit("update:modelValue", v),
});
</script>
