<template>
  <BaseModal
    :model-value="modelValue"
    @update:model-value="emit('update:model-value', $event)"
    title="Detail Pengguna"
  >
    <div class="space-y-6">
      <!-- Header: ID & Status -->
      <div class="flex justify-between items-center bg-blue-50 p-4 rounded-xl border border-blue-100">
        <div class="flex items-center gap-4">
          <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 shrink-0">
            <UserIcon class="w-5 h-5" />
          </div>
          <div>
            <p class="text-xs font-medium text-blue-600 uppercase tracking-wider mb-0.5">ID Pengguna</p>
            <p class="text-lg font-bold text-blue-900">{{ form.id }}</p>
          </div>
        </div>
        <span class="px-3 py-1 text-sm font-semibold rounded-full"
              :class="form.status === 'aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'">
          {{ form.status }}
        </span>
      </div>

      <!-- Info Grid -->
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <!-- Nama -->
        <div class="bg-white p-3 rounded-lg border border-gray-100 shadow-sm">
          <div class="flex items-center gap-2 mb-1">
            <UserIcon class="w-3 h-3 text-blue-400" />
            <label class="text-xs font-medium text-gray-500 uppercase tracking-wide">Nama Lengkap</label>
          </div>
          <p class="font-semibold text-gray-900 pl-5">{{ form.name }}</p>
        </div>

        <!-- Email -->
        <div class="bg-white p-3 rounded-lg border border-gray-100 shadow-sm">
          <div class="flex items-center gap-2 mb-1">
            <MailIcon class="w-3 h-3 text-blue-400" />
            <label class="text-xs font-medium text-gray-500 uppercase tracking-wide">Email</label>
          </div>
          <p class="font-semibold text-gray-900 pl-5">{{ form.email }}</p>
        </div>

        <!-- Nomor Telepon -->
        <div class="bg-white p-3 rounded-lg border border-gray-100 shadow-sm">
          <div class="flex items-center gap-2 mb-1">
            <PhoneIcon class="w-3 h-3 text-blue-400" />
            <label class="text-xs font-medium text-gray-500 uppercase tracking-wide">Nomor Telepon</label>
          </div>
          <p class="font-semibold text-gray-900 pl-5">{{ form.phone }}</p>
        </div>

        <div class="hidden sm:block"></div>

        <!-- Daftar Alamat -->
        <div class="bg-white p-3 rounded-lg border border-gray-100 shadow-sm sm:col-span-2 space-y-2">
          <div v-if="form.alamat.length === 0" class="text-gray-500 pl-2">Belum ada alamat</div>
          <div v-for="a in form.alamat" :key="a.id_alamat" class="border border-gray-100 p-2 rounded-lg bg-gray-50 flex justify-between items-center">
            <div>
              <p class="font-semibold">{{ a.alamat }}</p>
              <p class="text-xs text-gray-500">{{ a.kecamatan }}, {{ a.kota }}</p>
            </div>
            <span v-if="a.is_default" class="px-2 py-0.5 text-xs rounded-full bg-blue-100 text-blue-800">Default</span>
          </div>
        </div>
      </div>
    </div>

    <template #footer>
      <div class="flex justify-end">
        <BaseButton variant="outline-gray" @click="emit('update:model-value', false)">Tutup</BaseButton>
      </div>
    </template>
  </BaseModal>
</template>

<script setup>
import { ref, watch } from "vue";
import BaseModal from "@/components/base/BaseModal.vue";
import BaseButton from "@/components/base/BaseButton.vue";
import { UserIcon, MailIcon, PhoneIcon } from "lucide-vue-next";

const props = defineProps({
  modelValue: Boolean,
  itemData: { type: Object, default: null },
});
const emit = defineEmits(["update:model-value"]);

const form = ref({
  id: "",
  name: "",
  email: "",
  phone: "",
  alamat: [],
  status: "",
});

watch(
  () => props.itemData,
  (item) => {
    if (!item) {
      form.value = { id: "", name: "", email: "", phone: "", alamat: [], status: "" };
      return;
    }
    form.value = {
      id: item.id_user ?? "",
      name: item.nama_user ?? "",
      email: item.email_user ?? "",
      phone: item.no_telp ?? "-",
      alamat: item.alamat ?? [],
      status: item.status ?? "",
    };
  },
  { immediate: true }
);
</script>
