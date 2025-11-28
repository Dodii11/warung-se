<template>
  <Teleport to="body">
    <Transition name="modal-fade">
      <!-- BACKDROP -->
      <div
        v-if="modelValue"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm p-4"
        @click.self="close"
      >
        <!-- MODAL CONTAINER -->
        <div
          class="bg-white rounded-2xl shadow-xl w-full max-w-lg flex flex-col max-h-[90vh] transform transition-all"
          role="dialog"
          aria-modal="true"
        >
          <!-- HEADER -->
          <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100 shrink-0">
            <h3 class="text-lg font-bold text-gray-800">{{ title }}</h3>
            <button
              @click="close"
              class="text-gray-400 hover:text-gray-600 transition-colors p-1 rounded-md hover:bg-gray-100 focus:outline-none"
            >
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
          </div>

          <!-- BODY (SCROLLABLE) -->
          <div class="p-6 overflow-y-auto grow">
            <slot />
          </div>

          <!-- FOOTER -->
          <div v-if="$slots.footer" class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3 rounded-b-2xl shrink-0">
            <slot name="footer" />
          </div>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup>
import { onMounted, onUnmounted } from 'vue'

const props = defineProps({
  modelValue: Boolean,
  title: { type: String, default: 'Modal' }
})

const emit = defineEmits(['update:modelValue'])

const close = () => {
  emit('update:modelValue', false)
}

// Tutup dengan tombol ESC
const handleKeydown = (e) => {
  if (e.key === 'Escape' && props.modelValue) close()
}

onMounted(() => document.addEventListener('keydown', handleKeydown))
onUnmounted(() => document.removeEventListener('keydown', handleKeydown))
</script>

<style scoped>
.modal-fade-enter-active,
.modal-fade-leave-active {
  transition: opacity 0.2s ease, transform 0.2s ease;
}

.modal-fade-enter-from,
.modal-fade-leave-to {
  opacity: 0;
  transform: scale(0.95);
}
</style>
