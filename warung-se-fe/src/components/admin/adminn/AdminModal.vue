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
          <!-- ICON Profil -->
          <div
            class="w-16 h-16 rounded-full overflow-hidden border-2 border-blue-300 bg-white shadow-md flex items-center justify-center text-blue-500"
          >
            <!-- Menggunakan Ikon UserCircleIcon dari Lucide -->
            <UserCircleIcon class="w-10 h-10" />
          </div>

          <div class="flex-1 min-w-0">
            <p class="text-xs font-medium text-blue-600 uppercase tracking-wider mb-0.5 truncate">
              {{ form.role }} (ID: {{ form.id }})
            </p>
            <p class="text-xl font-bold text-blue-900 truncate">{{ form.name }}</p>
          </div>
        </div>
      </div>

      <!-- Grid Detail: Email, Status, Peran, Password -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Email -->
        <div class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm">
          <div class="flex items-center gap-2 mb-1">
            <MailIcon class="w-4 h-4 text-primary" />
            <label class="text-xs font-medium text-gray-500 uppercase tracking-wide"> Email </label>
          </div>
          <p class="font-semibold text-gray-900 pl-6 break-all">{{ form.email }}</p>
        </div>

        <!-- Peran (Role) -->
        <div class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm">
          <div class="flex items-center gap-2 mb-1">
            <ShieldCheckIcon class="w-4 h-4 text-primary" />
            <label class="text-xs font-medium text-gray-500 uppercase tracking-wide"> Peran </label>
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

        <!-- Password (Dikembalikan ke disensor) -->
        <div class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm">
          <div class="flex items-center gap-2 mb-1">
            <LockIcon class="w-4 h-4 text-primary" />
            <label class="text-xs font-medium text-gray-500 uppercase tracking-wide">
              Password
            </label>
          </div>
          <!-- format disensor (********) -->
          <p class="font-semibold text-gray-900 pl-6 break-all">
            ********
          </p>
        </div>
      </div>
    </div>

    <!-- =========================
      MODE FORM (ADD / EDIT)
      ========================= -->
    <form v-else @submit.prevent="handleSubmit" class="space-y-5">
      <!-- Nama, ID -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Nama -->
        <BaseInput label="Nama Lengkap" v-model="form.name" placeholder="Nama Admin">
          <template #icon><UserIcon class="w-4 h-4 text-gray-400" /></template>
        </BaseInput>
        <!-- ID -->
        <BaseInput
          label="ID Pengguna"
          v-model="form.id"
          placeholder="AD00X"
          :disabled="mode === 'edit'"
          :help-text="mode === 'edit' ? 'ID tidak dapat diubah' : 'Kosongkan untuk ID otomatis'"
        >
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

      <!-- Peran & Status (Grid 2 Kolom) -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Peran (Role) - DROPDOWN -->
        <div class="space-y-1">
          <label class="text-sm font-medium text-gray-700  flex items-center gap-1">
            <ShieldCheckIcon class="w-4 h-4 text-gray-400" /> Peran (Role)
          </label>
          <!-- BaseDropdown menggunakan array of strings sesuai komponen asli -->
          <BaseDropdown
            v-model="form.role"
            :options="roleOptions"
            placeholder="Pilih Peran"
            disabled
          />
          <p class="text-xs text-gray-500 mt-1">Peran diatur secara default sebagai 'Admin'.</p>
        </div>

        <!-- Status Akun (Hanya di mode Edit) -->
        <div v-if="mode === 'edit'" class="space-y-1.5">
          <label class="text-sm font-medium text-gray-700 flex items-center gap-1">
            <ActivityIcon class="w-4 h-4 text-gray-400" /> Kelola Status Akun
          </label>

          <div class="flex gap-4 pt-1 p-2 rounded-lg border border-gray-200 bg-white">
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
import BaseDropdown from "@/components/base/BaseDropdown.vue";
import AdminStatusBadge from "@/components/admin/adminn/AdminStatusBadge.vue";

import {
  UserIcon,
  MailIcon,
  LockIcon,
  ShieldCheckIcon,
  ActivityIcon,
  HashIcon,
  SaveIcon,
  UserCircleIcon,
} from "lucide-vue-next";

const props = defineProps({
  modelValue: Boolean,
  mode: { type: String, default: "add" }, // 'add', 'edit', 'detail'
  itemData: { type: Object, default: null },
});

const emit = defineEmits(["update:modelValue", "save"]);

const isSaving = ref(false);

// Disesuaikan kembali menjadi array of strings agar sesuai dengan BaseDropdown
const roleOptions = ["Admin"];

const modalTitle = computed(() => {
  if (props.mode === "detail") return "Detail Profil Admin";
  if (props.mode === "edit") return `Update Profil Admin: ${props.itemData?.name || ""}`;
  return "Tambah Akun Admin Baru";
});

const defaultForm = {
  id: "",
  name: "",
  email: "",
  password: "",
  role: "Admin",
  status: "Aktif",
};

const form = reactive({ ...defaultForm });

// Logika Inisialisasi Form
watch(
  () => [props.itemData, props.mode],
  ([newItem, newMode]) => {
    // Reset form untuk mode 'add'
    if (!newItem || newMode === "add") {
      Object.assign(form, { ...defaultForm });
      form.password = "";
      return;
    }

    // Inisialisasi dari itemData untuk mode 'edit' atau 'detail'
    Object.assign(form, {
      id: newItem.id ?? "",
      name: newItem.name ?? "",
      email: newItem.email ?? "",
      role: newItem.role ?? "Admin",
      status: newItem.status ?? "Aktif",
      // Memuat password tetap dilakukan di sini agar form.password ada isinya
      // di mode 'detail', meskipun tidak ditampilkan di UI.
      password: newItem.password ?? "",
    });

    // Untuk mode 'edit', password input harus dikosongkan secara eksplisit
    if (newMode === "edit") {
      form.password = "";
    }
  },
  { immediate: true }
);

const handleSubmit = async () => {
  if (props.mode === "detail") return;

  // Pengecekan dasar
  if (!form.name || !form.email) {
    console.error("Nama dan Email wajib diisi!");
    return;
  }
  if (props.mode === "add" && !form.password) {
    console.error("Password wajib diisi untuk akun baru!");
    return;
  }

  isSaving.value = true;
  await new Promise((r) => setTimeout(r, 800));

  emit("save", {
    ...form,
    // ID otomatis jika kosong
    id:
      form.id ||
      (props.mode === "add"
        ? `AD${Math.floor(Math.random() * 999)
            .toString()
            .padStart(3, "0")}`
        : props.itemData.id),
    // Pastikan password dikirim, meskipun mungkin kosong jika di mode edit
  });

  isSaving.value = false;
  emit("update:modelValue", false);
};
</script>
