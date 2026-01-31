<template>
  <div class="flex flex-col gap-2 w-28">
    <DetailButton @click="$emit('detail', item)"> </DetailButton>
    <EditButton v-if="isSuperAdmin" @click="$emit('edit', item)"> </EditButton>
    <DeleteButton v-if="isSuperAdmin" @click="$emit('delete', item)"> </DeleteButton>
  </div>
</template>

<script setup>
import DetailButton from "../RowButton/DetailButton.vue";
import EditButton from "../RowButton/EditButton.vue";
import DeleteButton from "../RowButton/DeleteButton.vue";

import { useAuth } from "@/stores/auth";
import { computed } from "vue";

const auth = useAuth();
const isSuperAdmin = computed(() => auth.isSuperAdmin);

defineProps({
  item: Object,
});

defineEmits(["edit", "detail", "delete", "toggle-status"]);
</script>
