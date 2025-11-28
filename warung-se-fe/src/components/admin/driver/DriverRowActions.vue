<template>
  <div class="flex flex-col gap-2 w-28">
    <DetailButton @click="openModal('detail')" />
    <EditButton @click="openModal('edit')" />
    <DeleteButton @click="confirmDelete" />
  </div>

  <!-- Modal Driver -->
  <DriverModal
    v-model="isModalOpen"
    :mode="modalMode"
    :item-data="item"
    @save="handleSave"
  />

</template>

<script setup>
import { ref } from "vue";
import DetailButton from "../RowButton/DetailButton.vue";
import EditButton from "../RowButton/EditButton.vue";
import DeleteButton from "../RowButton/DeleteButton.vue";
import DriverModal from "@/components/admin/driver/DriverModal.vue";

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
    // Di sini seharusnya ada logika POST/PUT ke API atau Firestore
    console.log(`Menyimpan data driver ${props.item.id} dengan data baru:`, formData);
    // Tutup modal
    isModalOpen.value = false;
};
</script>
