<template>
  <Transition name="modal-fade">
    <div
      v-if="show"
      class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6"
      @click.self="$emit('close')"
      aria-modal="true"
      role="dialog"
    >
      <!-- Overlay dengan backdrop-blur -->
      <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" aria-hidden="true"></div>

      <!-- Kontainer Modal -->
      <div
        :class="[
          'relative w-full max-h-[90vh] overflow-y-auto bg-white rounded-2xl shadow-2xl transform transition-all duration-300',
          sizeClasses
        ]"
      >
        <!-- Tombol Tutup (Hanya jika closeable) -->
        <button
          v-if="closeable"
          class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 z-10 p-2 transition-colors rounded-full bg-white/70 backdrop-blur-sm"
          @click="$emit('close')"
          aria-label="Tutup Modal"
        >
          <X class="w-5 h-5" />
        </button>

        <!-- Slot untuk konten -->
        <slot></slot>
      </div>
    </div>
  </Transition>
</template>

<script setup>
import { computed } from 'vue';
import { X } from 'lucide-vue-next';

const props = defineProps({
  show: { type: Boolean, default: false },
  closeable: { type: Boolean, default: true },
  size: { type: String, default: 'lg' } // sm, md, lg, xl
});

defineEmits(['close']);

const sizeClasses = computed(() => {
  switch (props.size) {
    case 'sm': return 'max-w-xs';
    case 'md': return 'max-w-md';
    case 'xl': return 'max-w-xl';
    default: return 'max-w-lg'; // lg default
  }
});
</script>

<style scoped>
/* Transisi Fade */
.modal-fade-enter-active,
.modal-fade-leave-active {
  transition: opacity 0.3s ease;
}

.modal-fade-enter-from,
.modal-fade-leave-to {
  opacity: 0;
}
</style>
