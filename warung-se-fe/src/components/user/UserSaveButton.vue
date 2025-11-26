<!-- src/components/user/UserSaveButton.vue -->
<template>
  <button 
    @click="$emit('click')"
    class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-full font-bold transition"
  >
    {{ label }}
  </button>
</template>

<script setup>
defineProps({
  label: {
    type: String,
    default: 'Simpan Perubahan'
  }
})

// Emit event click agar parent bisa handle aksi
defineEmits(['click'])
</script>