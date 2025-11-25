<template>
  <div class="flex flex-wrap items-center gap-3">

    <BaseDropdown
      v-model="localStatus"
      :options="statusOptions"
    />

    <div class="relative">
      <!-- BaseInput -->
    <BaseInput
      v-model="localDate"
      type="date"
      ref="dateInput"
      class="cursor-pointer"
    >
      <template #iconRight>
        <Calendar class="w-4 h-4" @click="openDatePicker" />
      </template>
    </BaseInput>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from "vue"
import BaseDropdown from "@/components/base/BaseDropdown.vue"
import BaseInput from "@/components/base/BaseInput.vue"
import { Calendar } from "lucide-vue-next"
import { statusOptions } from "@/data/ordersData"

const emit = defineEmits(["update:filter"])

const localStatus = ref("Status")
const localDate = ref("")

const dateInput = ref(null)

const openDatePicker = () => {
  if (dateInput.value?.$el) {
    // Ambil input asli dari dalam BaseInput
    const inputEl = dateInput.value.$el.querySelector("input")
    inputEl?.showPicker()
  }
}

const emitFilter = () => {
  emit("update:filter", {
    status: localStatus.value,
    date: localDate.value,
  })
}

watch([localStatus, localDate], emitFilter)
</script>

<style scoped>
/* Hilangkan icon date default */
input[type="date"]::-webkit-calendar-picker-indicator {
  opacity: 0;
  display: none;
}
</style>
