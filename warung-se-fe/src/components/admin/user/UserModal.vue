<template>
  <BaseModal
    :model-value="modelValue"
    @update:model-value="emit('update:model-value', $event)"
    title="Rincian Pengguna"
  >
    <div class="space-y-6">
      <!-- Bagian 1: Header - ID dan Status (Estetik dengan Warna Biru) -->
      <div
        class="flex justify-between items-center bg-blue-50 p-4 rounded-xl border border-blue-100"
      >
        <div class="flex items-center gap-4">
          <!-- Icon Estetik -->
          <div
            class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 shrink-0"
          >
            <UserIcon class="w-5 h-5" />
          </div>

          <div>
            <p class="text-xs font-medium text-blue-600 uppercase tracking-wider mb-0.5">
              ID Pengguna
            </p>
            <p class="text-lg font-bold text-blue-900">{{ form.id }}</p>
          </div>
        </div>
      </div>

      <!-- Bagian 2: Detail Informasi Pengguna (Gaya Grid 2 Kolom) -->
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

        <!-- Nama Lengkap -->
        <div class="bg-white p-3 rounded-lg border border-gray-100 shadow-sm">
          <div class="flex items-center gap-2 mb-1">
            <UserIcon class="w-3 h-3 text-blue-400" />
            <label class="text-xs font-medium text-gray-500 uppercase tracking-wide">
              Nama Lengkap
            </label>
          </div>
          <p class="font-semibold text-gray-900 pl-5">{{ form.name }}</p>
        </div>

        <!-- Email -->
        <div class="bg-white p-3 rounded-lg border border-gray-100 shadow-sm">
          <div class="flex items-center gap-2 mb-1">
            <MailIcon class="w-3 h-3 text-blue-400" />
            <label class="text-xs font-medium text-gray-500 uppercase tracking-wide">
              Email
            </label>
          </div>
          <p class="font-semibold text-gray-900 pl-5">{{ form.email }}</p>
        </div>

        <!-- Nomor Telepon -->
        <div class="bg-white p-3 rounded-lg border border-gray-100 shadow-sm">
          <div class="flex items-center gap-2 mb-1">
            <PhoneIcon class="w-3 h-3 text-blue-400" />
            <label class="text-xs font-medium text-gray-500 uppercase tracking-wide">
              Nomor Telepon
            </label>
          </div>
          <p class="font-semibold text-gray-900 pl-5">{{ form.phone }}</p>
        </div>

        <!-- Placeholder untuk kolom kedua yang kosong (jika ada data lain di sini) -->
        <div class="hidden sm:block"></div>

        <!-- Alamat (Mengambil lebar penuh) -->
        <div class="bg-white p-3 rounded-lg border border-gray-100 shadow-sm sm:col-span-2">
          <div class="flex items-center gap-2 mb-1">
            <MapPinIcon class="w-3 h-3 text-blue-400" />
            <label class="text-xs font-medium text-gray-500 uppercase tracking-wide">
              Alamat
            </label>
          </div>
          <p class="font-semibold text-gray-900 pl-5">{{ form.address }}</p>
        </div>

      </div>
    </div>

    <template #footer>
      <div class="flex justify-end">
        <BaseButton variant="outline-gray" @click="emit('update:model-value', false)">
          Tutup
        </BaseButton>
      </div>
    </template>
  </BaseModal>
</template>

<script setup>
import { ref, watch } from "vue";
import BaseModal from "@/components/base/BaseModal.vue";
import BaseButton from "@/components/base/BaseButton.vue";

import { UserIcon, MailIcon, PhoneIcon, MapPinIcon } from "lucide-vue-next";

const props = defineProps({
  modelValue: Boolean,
  itemData: { type: Object, default: null },
});

const emit = defineEmits(["update:model-value"]);

// Menggunakan ref untuk objek form (Logika tidak berubah)
const form = ref({
  id: "",
  name: "",
  email: "",
  phone: "",
  address: "",
  // Meskipun data dummy tidak memiliki 'status', kita tambahkan default
  status: "active",
});

// Watch props.itemData untuk menginisialisasi form (Logika tidak berubah)
watch(
  () => props.itemData,
  (item) => {
    // Saat itemData null (reset)
    if (!item) {
      form.value = { id: "", name: "", email: "", phone: "", address: "", status: "active" };
      return;
    }

    // Saat itemData memiliki nilai (saat tombol detail ditekan)
    form.value = {
      id: item.id ?? "",
      name: item.name ?? "",
      email: item.email ?? "",
      phone: item.phone ?? "",
      address: item.address ?? "",
      status: item.status ?? "active",
    };
  },
  { immediate: true }
);
</script>
