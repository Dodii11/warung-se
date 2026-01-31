<template>
  <div class="flex flex-col gap-2 w-28">
    <!-- DETAIL: semua role admin boleh -->
    <DetailButton @click="$emit('detail', item)" />

    <!-- EDIT: hanya super admin -->
    <EditButton
      v-if="isSuperAdmin"
      @click="$emit('edit', item)"
    />

    <!-- DELETE: hanya super admin -->
    <DeleteButton
      v-if="isSuperAdmin"
      @click="$emit('delete', item)"
    />
  </div>
</template>

<script setup>
import { computed } from "vue";
import { useAuth } from "@/stores/auth";

import DetailButton from "../RowButton/DetailButton.vue";
import EditButton from "../RowButton/EditButton.vue";
import DeleteButton from "../RowButton/DeleteButton.vue";

defineProps({
  item: Object,
});

defineEmits(["edit", "detail", "delete"]);

// ===== AUTH =====
const auth = useAuth();

// Ambil dari getter (yang kita sepakati barusan)
const isSuperAdmin = computed(() => auth.isSuperAdmin);
</script>
