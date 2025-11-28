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

      <!-- Card Profil Utama (ID & Nama) -->
      <div class="p-4 bg-blue-50 rounded-xl border border-blue-100 shadow-inner">
        <div class="flex items-center gap-4">
          <!-- Gambar Profil -->
          <div
            class="w-16 h-16 rounded-full overflow-hidden border-2 border-blue-300 bg-white shadow-md flex-shrink-0"
          >
             <img
                :src="form.profileImage"
                class="w-full h-full object-cover"
                alt="Foto Profil Admin"
                onerror="this.onerror=null; this.src='https://placehold.co/64x64/D1D5DB/4B5563?text=ADM';"
            />
          </div>

          <div class="flex-1 min-w-0">
            <p class="text-xs font-medium text-blue-600 uppercase tracking-wider mb-0.5 truncate">
              {{ form.role }} (ID: {{ form.id }})
            </p>
            <p class="text-xl font-bold text-blue-900 truncate">{{ form.name }}</p>
          </div>
        </div>
      </div>

      <!-- Grid Detail: Email, Status, Peran -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <!-- Email -->
        <div class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm">
          <div class="flex items-center gap-2 mb-1">
            <MailIcon class="w-4 h-4 text-primary" />
            <label class="text-xs font-medium text-gray-500 uppercase tracking-wide">
              Email
            </label>
          </div>
          <p class="font-semibold text-gray-900 pl-6 break-all">{{ form.email }}</p>
        </div>

        <!-- Peran (Role) -->
        <div class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm">
          <div class="flex items-center gap-2 mb-1">
            <ShieldCheckIcon class="w-4 h-4 text-primary" />
            <label class="text-xs font-medium text-gray-500 uppercase tracking-wide">
              Peran
            </label>
          </div>
          <div class="pl-6">
             <AdminStatusBadge :status="form.role" class="py-1.5 px-3" />
          </div>
        </div>

        <!-- Status Akun -->
        <div class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm">
          <div class="flex items-center gap-2 mb-1">
            <ActivityIcon class="w-4 h-4 text-primary" />
            <label class="text-xs font-medium text-gray-500 uppercase tracking-wide">
              Status Akun
            </label>
          </div>
          <div class="pl-6">
             <AdminStatusBadge :status="form.status" class="py-1.5 px-3" />
          </div>
        </div>

        <!-- Password (Sebagai Tanda Keamanan - Tidak menampilkan nilai asli) -->
        <div class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm">
          <div class="flex items-center gap-2 mb-1">
            <LockIcon class="w-4 h-4 text-primary" />
            <label class="text-xs font-medium text-gray-500 uppercase tracking-wide">
              Password
            </label>
          </div>
          <p class="font-semibold text-gray-900 pl-6">
              •••••••• (Tidak Ditampilkan)
          </p>
        </div>
      </div>
    </div>

    <!-- =========================
     MODE FORM (ADD / EDIT)
     ========================= -->
    <form v-else @submit.prevent="handleSubmit" class="space-y-5">

      <!-- Upload Foto Profil (Opsional) -->
      <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl border border-gray-200">
        <div
          class="w-16 h-16 rounded-full border-2 border-dashed border-gray-300 flex items-center justify-center bg-white text-gray-400 overflow-hidden shrink-0 relative hover:border-primary hover:bg-blue-50 transition-colors"
        >
          <img
            v-if="form.profileImage"
            :src="form.profileImage"
            class="w-full h-full object-cover"
            alt="Preview"
          />
          <UserIcon v-else class="w-6 h-6" />
        </div>
        <div class="flex-1 space-y-2">
          <label class="text-sm font-medium text-gray-700 block flex items-center gap-1">
            <CameraIcon class="w-4 h-4 text-gray-400" /> Foto Profil
          </label>
          <input
            type="file"
            @change="handleFileChange"
            accept="image/*"
            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100 cursor-pointer transition-colors"
          />
        </div>
      </div>

      <!-- Nama, ID, Email -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Nama -->
        <BaseInput label="Nama Lengkap" v-model="form.name" placeholder="Nama Admin">
          <template #icon><UserIcon class="w-4 h-4 text-gray-400" /></template>
        </BaseInput>
        <!-- ID -->
        <BaseInput label="ID Pengguna (Optional)" v-model="form.id" placeholder="AD00X" :disabled="mode === 'edit'">
          <template #icon><HashIcon class="w-4 h-4 text-gray-400" /></template>
        </BaseInput>
      </div>

      <!-- Email -->
      <BaseInput label="Email" v-model="form.email" type="email" placeholder="contoh@domain.com">
        <template #icon><MailIcon class="w-4 h-4 text-gray-400" /></template>
      </BaseInput>

      <!-- Password (Hanya di mode Add dan Edit) -->
      <BaseInput
        :label="mode === 'add' ? 'Kata Sandi' : 'Kata Sandi Baru (Kosongkan jika tidak diubah)'"
        v-model="form.password"
        type="password"
        placeholder="Minimal 8 karakter"
      >
        <template #icon><LockIcon class="w-4 h-4 text-gray-400" /></template>
      </BaseInput>

      <!-- Status Akun (Hanya di mode Edit) -->
      <div
        v-if="mode === 'edit'"
        class="flex flex-col gap-1.5 p-3 rounded-xl border border-gray-200"
      >
        <label class="text-sm font-medium text-gray-700 flex items-center gap-1">
          <ActivityIcon class="w-4 h-4 text-gray-400" /> Kelola Status Akun
        </label>

        <div class="flex gap-4 pt-1">
          <label class="flex items-center cursor-pointer gap-2">
            <input
              type="radio"
              v-model="form.status"
              value="Aktif"
              class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-600"
            />
            <span class="text-sm text-gray-700">Aktif</span>
          </label>
          <label class="flex items-center cursor-pointer gap-2">
            <input
              type="radio"
              v-model="form.status"
              value="Nonaktif"
              class="w-4 h-4 text-red-600 border-gray-300 focus:ring-red-600"
            />
            <span class="text-sm text-gray-700">Nonaktif</span>
          </label>
        </div>
      </div>

      <!-- Peran (Role) - Read Only, karena hanya Admin -->
      <BaseInput label="Peran" v-model="form.role" disabled placeholder="Admin">
        <template #icon><ShieldCheckIcon class="w-4 h-4 text-gray-400" /></template>
      </BaseInput>

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
          {{ mode === "edit" ? "Simpan Perubahan" : "Buat Akun Admin" }}
        </BaseButton>
      </div>
    </template>
  </BaseModal>
</template>

<script setup>
import { ref, reactive, watch, computed } from "vue";
import BaseModal from "@/components/base/BaseModal.vue";
import BaseInput from "@/components/base/BaseInput.vue";
import BaseButton from "@/components/base/BaseButton.vue";
import AdminStatusBadge from "@/components/admin/adminn/AdminStatusBadge.vue";

import {
    UserIcon, MailIcon, LockIcon, ShieldCheckIcon, ActivityIcon, HashIcon, SaveIcon, CameraIcon
} from "lucide-vue-next";

const props = defineProps({
  modelValue: Boolean,
  mode: { type: String, default: "add" }, // 'add', 'edit', 'detail'
  itemData: { type: Object, default: null },
});

const emit = defineEmits(["update:modelValue", "save"]);

const isSaving = ref(false);

const modalTitle = computed(() => {
  if (props.mode === "detail") return "Detail Profil Admin";
  if (props.mode === "edit") return `Edit Profil Admin: ${props.itemData?.name || ''}`;
  return "Tambah Akun Admin Baru";
});

const defaultForm = {
  id: "",
  name: "",
  email: "",
  password: "", // Hanya diisi saat 'add' atau 'edit' (untuk password baru)
  role: "Admin",
  status: "Aktif",
  profileImage: "https://placehold.co/64x64/1D4ED8/FFFFFF?text=ADM",
  imageFile: null,
};

const form = reactive({ ...defaultForm });

// Logika Inisialisasi Form
watch(
  () => [props.itemData, props.mode],
  ([newItem, newMode]) => {
    if (!newItem || newMode === 'add') {
      Object.assign(form, { ...defaultForm });
      form.password = ""; // Pastikan password direset untuk mode 'add'
      return;
    }

    // Inisialisasi dari itemData untuk mode 'edit' atau 'detail'
    Object.assign(form, {
      id: newItem.id ?? "",
      name: newItem.name ?? "",
      email: newItem.email ?? "",
      role: newItem.role ?? "Admin",
      status: newItem.status ?? "Aktif",
      profileImage: newItem.profileImage || "https://placehold.co/64x64/1D4ED8/FFFFFF?text=ADM",
      password: "", // Password selalu kosong saat dibuka (hanya diisi jika ingin diubah)
      imageFile: null,
    });
  },
  { immediate: true }
);

const handleFileChange = (e) => {
  const file = e.target.files[0];
  if (file) {
    form.imageFile = file;
    form.profileImage = URL.createObjectURL(file);
  }
};

const handleSubmit = async () => {
  if (props.mode === "detail") return;

  // Pengecekan dasar
  if (!form.name || !form.email) {
    console.error("Nama dan Email wajib diisi!");
    return;
  }
  if (props.mode === 'add' && !form.password) {
     console.error("Password wajib diisi untuk akun baru!");
     return;
  }
  // Tambahkan validasi email, dll. di sini

  isSaving.value = true;
  await new Promise((r) => setTimeout(r, 800));

  emit("save", {
    ...form,
    // ID otomatis jika kosong
    id: form.id || (props.mode === 'add' ? `AD${Math.floor(Math.random() * 999).toString().padStart(3, '0')}` : props.itemData.id),
    profileImage: form.profileImage,
  });

  isSaving.value = false;
  emit("update:modelValue", false);
};
</script>
