<template>
  <div class="relative">
    <select
      v-model="model"
      class="appearance-none px-4 py-2.5 pr-10 rounded-lg border border-gray-300 bg-white
             text-sm focus:ring-2 focus:ring-primary/50 outline-none"
    >
      <option
        v-for="(option, index) in options"
        :key="index"
        :value="option"
      >
        {{ option }}
      </option>
    </select>

    <!-- Icon lucide -->
    <ChevronDown
      class="w-4 h-4 text-gray-500 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"
    />
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
