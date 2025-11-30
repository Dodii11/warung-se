<template>
  <BaseModal
    :model-value="modelValue"
    @update:model-value="emit('update:modelValue', $event)"
    :title="modalTitle"
  >
    <!-- =========================
     MODE DETAIL (READ ONLY)
     ========================= -->
    <div v-if="mode === 'detail'" class="space-y-6">
      <!-- Header Estetik: ID Driver dan Status -->
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
              ID Driver
            </p>
            <p class="text-lg font-bold text-blue-900">{{ form.id }}</p>
          </div>
        </div>

        <!-- Menampilkan status pengguna -->
        <DriverStatusBadge :status="form.status" class="py-2 px-4" />
      </div>

      <!-- Detail Informasi Driver (Gaya Grid 2 Kolom) -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <!-- Nama Lengkap -->
        <div class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm">
          <div class="flex items-center gap-2 mb-1">
            <UserCheckIcon class="w-4 h-4 text-blue-500" />
            <label class="text-xs font-medium text-gray-500 uppercase tracking-wide">
              Nama Lengkap
            </label>
          </div>
          <p class="font-semibold text-gray-900 pl-6">{{ form.name }}</p>
        </div>

        <!-- Nomor Telepon -->
        <div class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm">
          <div class="flex items-center gap-2 mb-1">
            <PhoneIcon class="w-4 h-4 text-blue-500" />
            <label class="text-xs font-medium text-gray-500 uppercase tracking-wide">
              Nomor Telepon
            </label>
          </div>
          <p class="font-semibold text-gray-900 pl-6">{{ form.phone }}</p>
        </div>

        <!-- Jenis Kendaraan -->
        <div class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm">
          <div class="flex items-center gap-2 mb-1">
            <Motorbike v-if="form.vehicleType === 'Sepeda Motor'" class="w-4 h-4 text-blue-500" />
            <CarIcon v-else-if="form.vehicleType === 'Mobil'" class="w-4 h-4 text-blue-500" />
            <TruckIcon v-else class="w-4 h-4 text-blue-500" />
            <label class="text-xs font-medium text-gray-500 uppercase tracking-wide">
              Tipe Kendaraan
            </label>
          </div>
          <p class="font-semibold text-gray-900 pl-6">{{ form.vehicleType }}</p>
        </div>

        <!-- Nama/Plat Kendaraan -->
        <div class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm">
          <div class="flex items-center gap-2 mb-1">
            <TagIcon class="w-4 h-4 text-blue-500" />
            <label class="text-xs font-medium text-gray-500 uppercase tracking-wide">
              Nama Kendaraan/Plat
            </label>
          </div>
          <p class="font-semibold text-gray-900 pl-6">{{ form.vehicleName }}</p>
        </div>
      </div>

      <!-- Foto Profil (Area Khusus) -->
      <div class="space-y-3 pt-2">
        <label class="text-sm font-medium text-gray-700 flex items-center gap-2">
            <CameraIcon class="w-4 h-4 text-gray-500" /> Foto Profil
        </label>
        <div
            class="w-full h-40 md:h-60 rounded-xl overflow-hidden bg-gray-100 border border-gray-200 shadow-inner flex items-center justify-center"
        >
            <img
                :src="form.imagePreview"
                class="w-full h-full object-cover"
                alt="Foto Profil Driver"
                onerror="this.onerror=null; this.src='https://placehold.co/600x400/D1D5DB/4B5563?text=Driver+Image';"
            />
        </div>
        <p class="text-xs text-gray-500 text-right">Diperbarui: {{ form.lastUpdate || 'Belum diketahui' }}</p>
      </div>

    </div>

    <!-- =========================
         MODE FORM (ADD / EDIT)
         ========================= -->
    <form v-else @submit.prevent="handleSubmit" class="space-y-5">

      <!-- Input ID Driver (Hanya di mode Add jika ingin diisi manual) -->
      <BaseInput v-if="mode === 'add'" label="ID Driver" v-model="form.id" placeholder="#DRV-001">
        <template #icon><HashIcon class="w-4 h-4 text-gray-400" /></template>
      </BaseInput>

      <!-- Input Nama & Telepon -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <BaseInput label="Nama Lengkap" v-model="form.name" placeholder="Nama Driver">
          <template #icon><UserCheckIcon class="w-4 h-4 text-gray-400" /></template>
        </BaseInput>
        <BaseInput label="Nomor Telepon" v-model="form.phone" placeholder="+62 8xx xxxx xxxx">
          <template #icon><PhoneIcon class="w-4 h-4 text-gray-400" /></template>
        </BaseInput>
      </div>

      <!-- Input Kendaraan -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Nama Kendaraan -->
        <BaseInput label="Nama Kendaraan/Plat" v-model="form.vehicleName" placeholder="Contoh: B 1234 ABC">
          <template #icon><TagIcon class="w-4 h-4 text-gray-400" />
            <TagIcon class="w-4 h-4 text-gray-400" />
          </template>
        </BaseInput>

        <!-- Tipe Kendaraan Dropdown -->
        <div class="flex flex-col gap-1.5">
          <label class="text-sm font-medium text-gray-700 flex items-center gap-1 mb-1">
            <Motorbike class="w-4 h-4 text-gray-400" /> Tipe Kendaraan
          </label>
          <BaseDropdown v-model="form.vehicleType" :options="vehicleOptions" class="w-full" />
        </div>
      </div>

      <!-- Status Ketersediaan (Hanya di mode Edit, tidak saat Sedang Pengiriman) -->
      <div
        v-if="mode === 'edit'"
        class="flex flex-col gap-1.5 p-3 rounded-xl border border-gray-200"
      >
        <label class="text-sm font-medium text-gray-700 flex items-center gap-1">
          <ActivityIcon class="w-4 h-4 text-gray-400" /> Status Ketersediaan
        </label>

        <!-- Notifikasi jika sedang pengiriman (Tidak bisa diubah) -->
        <div v-if="form.status === 'Sedang Pengiriman'"
             class="p-3 bg-yellow-50 text-yellow-800 rounded-lg text-sm font-medium flex items-center gap-2"
        >
            <AlertTriangleIcon class="w-5 h-5" />
            Driver sedang dalam pengiriman. Status ketersediaan tidak dapat diubah manual.
        </div>

        <!-- Opsi Status (Hanya Tersedia / Tidak Aktif) -->
        <div v-else class="flex gap-4 pt-1">
          <label class="flex items-center cursor-pointer gap-2">
            <input
              type="radio"
              v-model="form.status"
              value="Tersedia"
              class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-600"
            />
            <span class="text-sm text-gray-700">Tersedia</span>
          </label>
          <label class="flex items-center cursor-pointer gap-2">
            <input
              type="radio"
              v-model="form.status"
              value="Tidak Aktif"
              class="w-4 h-4 text-red-600 border-gray-300 focus:ring-red-600"
            />
            <span class="text-sm text-gray-700">Tidak Aktif</span>
          </label>
        </div>
      </div>

      <!-- Upload Foto Profil -->
      <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-xl border border-gray-200">
        <div
          class="w-24 h-24 rounded-xl border-2 border-dashed border-gray-300 flex items-center justify-center bg-white text-gray-400 overflow-hidden shrink-0 relative hover:border-primary hover:bg-blue-50 transition-colors"
        >
          <img
            v-if="form.imagePreview"
            :src="form.imagePreview"
            class="w-full h-full object-cover"
            alt="Preview"
          />
          <ImagePlus />
        </div>
        <div class="flex-1 space-y-2">
          <label class="text-sm font-medium text-gray-700 flex items-center gap-1">
            <CameraIcon class="w-4 h-4 text-gray-400" /> Foto Profil Driver
          </label>
          <input
            type="file"
            @change="handleFileChange"
            accept="image/*"
            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100 cursor-pointer transition-colors"
          />
          <p class="text-xs text-gray-400">Format: JPG, PNG. Maksimal 1MB.</p>
        </div>
      </div>

    </form>

    <!-- FOOTER -->
    <template #footer>
      <!-- Footer Mode Detail -->
      <div v-if="mode === 'detail'" class="w-full flex justify-end">
        <BaseButton variant="outline-gray" @click="emit('update:modelValue', false)">
          Tutup
        </BaseButton>
      </div>

      <!-- Footer Mode Form -->
      <div v-else class="flex gap-3 w-full justify-end">
        <BaseButton variant="outline-gray" @click="emit('update:modelValue', false)">
          Batal
        </BaseButton>
        <BaseButton @click="handleSubmit" :loading="isSaving" variant="primary">
          <template #icon-left><SaveIcon class="w-4 h-4" /></template>
          {{ mode === "edit" ? "Simpan Perubahan" : "Tambah Driver" }}
        </BaseButton>
      </div>
    </template>
  </BaseModal>
</template>

<script setup>
import { ref, reactive, watch, computed } from "vue";
import BaseModal from "@/components/base/BaseModal.vue";
import BaseInput from "@/components/base/BaseInput.vue";
import BaseDropdown from "@/components/base/BaseDropdown.vue";
import BaseButton from "@/components/base/BaseButton.vue";
import DriverStatusBadge from "@/components/admin/driver/DriverStatusBadge.vue";

import {
    UserIcon, PhoneIcon, TagIcon, CarIcon, TruckIcon,
    ImagePlus, SaveIcon, UserCheckIcon, ActivityIcon, HashIcon, CameraIcon,
    AlertTriangleIcon,
    Motorbike
} from "lucide-vue-next";

const props = defineProps({
  modelValue: Boolean,
  mode: { type: String, default: "add" }, // 'add', 'edit', 'detail'
  itemData: { type: Object, default: null },
});

const emit = defineEmits(["update:modelValue", "save", "delete"]);

const isSaving = ref(false);

const vehicleOptions = ["Sepeda Motor", "Mobil", "Truk Pick Up"]; // Opsi tipe kendaraan

const modalTitle = computed(() => {
  if (props.mode === "detail") return "Detail Profil Driver";
  if (props.mode === "edit") return `Update Driver: ${props.itemData?.name || ''}`;
  return "Tambahkan Driver Baru";
});

const defaultForm = {
  id: "",
  name: "",
  phone: "",
  vehicleName: "",
  vehicleType: vehicleOptions[0],
  imageFile: null,
  imagePreview: "https://placehold.co/600x400/D1D5DB/4B5563?text=Foto+Profil",
  status: "Tidak Aktif", // Default status saat tambah
  lastUpdate: new Date().toLocaleDateString('id-ID'),
};

const form = reactive({ ...defaultForm });

// Logika Inisialisasi Form
watch(
  () => [props.itemData, props.mode],
  ([newItem, newMode]) => {
    // Reset form saat modal ditutup atau mode "add"
    if (!newItem || newMode === 'add') {
      Object.assign(form, { ...defaultForm, imagePreview: "" });
      form.vehicleType = vehicleOptions[0];
      return;
    }

    // Inisialisasi dari itemData untuk mode 'edit' atau 'detail'
    Object.assign(form, {
      id: newItem.id ?? "",
      name: newItem.name ?? "",
      phone: newItem.phone ?? "",
      vehicleName: newItem.vehicleName ?? "",
      vehicleType: newItem.vehicleType ?? vehicleOptions[0],
      // Gunakan placeholder jika tidak ada gambar (atau URL gambar nyata jika ada)
      imagePreview: newItem.image || "https://placehold.co/600x400/1D4ED8/FFFFFF?text=Driver+"+newItem.name.split(' ')[0],
      status: newItem.status ?? "Tidak Aktif",
      lastUpdate: newItem.lastUpdate ?? defaultForm.lastUpdate,
      imageFile: null, // File selalu null saat diinisialisasi
    });
  },
  { immediate: true }
);

const handleFileChange = (e) => {
  const file = e.target.files[0];
  if (file) {
    form.imageFile = file;
    form.imagePreview = URL.createObjectURL(file);
  }
};

const handleSubmit = async () => {
  if (props.mode === "detail") return;

  if (!form.name || !form.phone || !form.vehicleName) {
    console.error("Nama, Telepon, dan Nama Kendaraan wajib diisi!");
    return;
  }

  isSaving.value = true;
  await new Promise((r) => setTimeout(r, 800));

  emit("save", {
    ...form,
    // Pastikan ID dihasilkan jika mode 'add' dan ID manual kosong
    id: form.id || (props.mode === 'add' ? `#DRV-${Math.floor(Math.random() * 99999).toString().padStart(5, '0')}` : props.itemData.id),
    image: form.imagePreview, // Simpan URL gambar yang sudah di-preview
  });

  isSaving.value = false;
  emit("update:modelValue", false);
};
</script>
