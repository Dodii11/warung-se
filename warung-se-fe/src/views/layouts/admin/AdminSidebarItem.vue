<template>
  <RouterLink
    :to="item.path"
    class="flex items-center px-4 py-2.5 rounded-lg transition-all duration-200 group"
    :class="[
      collapsed ? 'justify-center' : 'gap-3',
      isActive
        ? 'bg-red-50 text-red-600 font-semibold'
        : 'text-gray-700 hover:bg-gray-100'
    ]"
  >
    <component
      :is="item.icon"
      class="w-5 h-5 transition-colors duration-200"
      :class="isActive ? 'text-red-600' : 'text-gray-500 group-hover:text-gray-700'"
    />

    <!-- Hide text when collapsed -->
    <span
      class="transition-opacity duration-200"
      :class="collapsed ? 'opacity-0 w-0 overflow-hidden' : 'opacity-100'"
    >
      {{ item.label }}
    </span>
  </RouterLink>
</template>

<script setup>
import { computed } from "vue";
import { useRoute } from "vue-router";

const props = defineProps({
  item: Object,
  collapsed: Boolean
});

const route = useRoute();
const isActive = computed(() => route.path === props.item.path);
</script>
