<template>
  <div class="flex items-center justify-center p-10 md:p-16 border border-dashed border-gray-200 rounded-xl bg-gray-50/50 min-h-[300px]">
    <div class="text-center max-w-sm space-y-4">
      <!-- Ikon Dinamis (Opsional) -->
      <component
        :is="icon"
        v-if="icon"
        class="w-12 h-12 mx-auto text-primary-500/70"
      />

      <!-- Judul -->
      <h3 class="text-xl font-semibold text-gray-800">
        {{ title }}
      </h3>

      <!-- Deskripsi -->
      <p class="text-sm text-gray-500">
        {{ description }}
      </p>

      <!-- Slot untuk Tombol Aksi (Misalnya: Tombol "Tambah Baru") -->
      <div v-if="$slots.default" class="pt-2">
        <slot></slot>
      </div>
    </div>
  </div>
</template>

<script setup>
import { defineProps } from 'vue';
import { BoxIcon } from 'lucide-vue-next';

defineProps({
  /**
   * Judul utama untuk empty state (Misalnya: "Data Tidak Ditemukan")
   */
  title: {
    type: String,
    required: true,
  },
  /**
   * Deskripsi detail tentang mengapa data kosong atau bagaimana cara menambahkannya.
   */
  description: {
    type: String,
    required: true,
  },
  /**
   * Komponen ikon Lucide-Vue-Next yang akan ditampilkan. Default: BoxIcon.
   * Contoh: 'BoxIcon' atau komponen yang sudah di-import.
   */
  icon: {
    type: [Object, String],
    default: () => BoxIcon,
  },
});
</script>
