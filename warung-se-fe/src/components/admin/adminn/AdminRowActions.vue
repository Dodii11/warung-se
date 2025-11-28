<template>
  <div class="flex flex-col gap-2 w-28">
    <DetailButton @click="openModal('detail')" />
    <EditButton @click="openModal('edit')" />
    <DeleteButton @click="confirmDelete" />
  </div>

  <!-- Modal Admin -->
  <AdminModal
    v-model="isModalOpen"
    :mode="modalMode"
    :item-data="item"
    @save="handleSave"
  />

</template>

<script setup>
import { ref } from "vue";
// Catatan: Asumsi path ke RowButton sudah benar sekarang
import DetailButton from "../RowButton/DetailButton.vue";
import EditButton from "../RowButton/EditButton.vue";
import DeleteButton from "../RowButton/DeleteButton.vue";
import AdminModal from "../adminn/AdminModal.vue";

const props = defineProps({
  item: Object,
});

const isModalOpen = ref(false);
const modalMode = ref('detail');
const isConfirmDeleteOpen = ref(false);

const openModal = (mode) => {
  modalMode.value = mode;
  isModalOpen.value = true;
};

const confirmDelete = () => {
  isConfirmDeleteOpen.value = true;
};

// Logika Dummy untuk Aksi CRUD
const handleSave = (formData) => {
    console.log(`Menyimpan data admin ${props.item.id} dengan data baru:`, formData);
    // Di sini akan ada emit ke AdminAdmin.vue untuk memperbarui daftar
    isModalOpen.value = false;
};

</script>
