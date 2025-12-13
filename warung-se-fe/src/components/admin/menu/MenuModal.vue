<template>
  <BaseModal
    :model-value="modelValue"
    @update:model-value="$emit('update:modelValue', $event)"
    :title="modalTitle"
  >
    <!-- FORM DETAIL (READ ONLY) -->
    <div v-if="mode === 'detail'" class="space-y-6">
      <!-- Card Utama: Gambar & Status -->
      <div
        class="w-full h-56 rounded-xl overflow-hidden bg-gray-50 border border-gray-200 relative group shadow-lg"
      >
        <img
          :src="form.imagePreview"
          class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
          alt="Menu Image"
        />

        <!-- Badge Status (Otomatis merah jika stok habis atau status BE 'tidak_tersedia') -->
        <div
          class="absolute top-4 right-4 px-3 py-1.5 rounded-full text-xs font-bold bg-white/90 backdrop-blur-sm shadow-md border"
          :class="isUnavailable ? 'text-red-600 border-red-100' : 'text-green-600 border-green-100'"
        >
          {{ isUnavailable ? "Tidak Tersedia" : "Tersedia" }}
        </div>
      </div>

      <!-- Informasi Menu -->
      <div class="space-y-5">
        <!-- Nama Menu (Judul Besar - Mengikuti gaya UserModal) -->
        <div class="bg-blue-50 p-4 rounded-xl border border-blue-100">
          <label class="text-xs font-medium text-blue-600 uppercase tracking-wide block mb-1"
            >Nama Menu</label
          >
          <p class="text-xl font-bold text-blue-900">{{ form.name }}</p>
        </div>

        <!-- Grid Info (Harga & Stok - Card terpisah) -->
        <div class="grid grid-cols-2 gap-4">
          <!-- Harga Card -->
          <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
            <div class="flex items-start gap-3">
              <TagIcon class="w-4 h-4 text-blue-500 mt-1 shrink-0" />
              <div>
                <label class="text-xs font-medium text-gray-500 block mb-1">Harga</label>
                <p class="text-gray-900 font-bold text-lg">
                  Rp {{ Number(form.price).toLocaleString("id-ID") }}
                </p>
              </div>
            </div>
          </div>
          <!-- Stok Tersedia Card -->
          <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
            <div class="flex items-start gap-3">
              <PackageSearchIcon class="w-4 h-4 text-blue-500 mt-1 shrink-0" />
              <div>
                <label class="text-xs font-medium text-gray-500 block mb-1">Stok Tersedia</label>
                <p
                  class="font-bold text-lg"
                  :class="form.stock > 0 ? 'text-gray-900' : 'text-red-600'"
                >
                  {{ form.stock }} Porsi
                </p>
              </div>
            </div>
          </div>
        </div>

        <!-- Kategori & Deskripsi -->
        <div class="space-y-4">
          <!-- Kategori Card -->
          <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
            <label class="text-xs font-medium text-gray-500 uppercase tracking-wide block mb-2"
              >Kategori</label
            >
            <span
              class="px-3 py-1.5 rounded-lg bg-red-50 text-primary text-sm font-medium border border-red-100 inline-flex items-center gap-2"
            >
              <Utensils class="w-4 h-4 text-current" />
              {{ form.category }}
            </span>
          </div>

          <!-- Deskripsi Card -->
          <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
            <label
              class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-3 flex items-center gap-1"
            >
              <ScrollTextIcon class="w-3 h-3 text-gray-400" /> Deskripsi
            </label>
            <p class="text-gray-700 text-sm leading-relaxed">
              {{ form.description || "Tidak ada deskripsi untuk menu ini." }}
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- FORM ADD/EDIT -->
    <form v-else @submit.prevent="handleSubmit" class="space-y-5">
      <!-- Upload Gambar -->
      <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-xl border border-gray-200">
        <div
          class="w-24 h-24 rounded-xl border-2 border-dashed border-gray-300 flex items-center justify-center bg-white text-gray-400 overflow-hidden shrink-0 relative hover:border-primary hover:bg-red-50 transition-colors"
        >
          <img
            v-if="form.imagePreview"
            :src="form.imagePreview"
            class="w-full h-full object-cover"
            alt="Preview"
          />
          <ImagePlus v-else />
        </div>
        <div class="flex-1 space-y-2">
          <label class="text-sm font-medium text-gray-700 flex items-center gap-1">
            <ImagePlus class="w-4 h-4 text-gray-400" /> Foto Menu
          </label>
          <input
            type="file"
            @change="handleFileChange"
            accept="image/*"
            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-red-50 file:text-primary hover:file:bg-red-100 cursor-pointer transition-colors"
          />
          <p class="text-xs text-gray-400">Format: JPG, PNG. Maksimal 2MB.</p>
        </div>
      </div>

      <!-- Nama Menu -->
      <BaseInput label="Nama Menu" v-model="form.name" placeholder="Contoh: Ayam Geprek">
        <template #icon><Utensils class="w-4 h-4 text-gray-400" /></template>
      </BaseInput>

      <!-- Kategori -->
      <div class="flex flex-col gap-1.5">
        <label class="text-sm font-medium text-gray-700 flex items-center gap-1 mb-1">
          <ClipboardListIcon class="w-4 h-4 text-gray-400" /> Kategori
        </label>
        <BaseDropdown v-model="form.category" :options="categoryOptions" class="w-full" />
      </div>

      <!-- Harga & Stok -->
      <div class="grid grid-cols-2 gap-4">
        <BaseInput label="Harga (Rp)" type="number" v-model="form.price" placeholder="0">
          <template #icon><TagIcon class="w-4 h-4 text-gray-400" /></template>
        </BaseInput>
        <BaseInput label="Stok Awal" type="number" v-model="form.stock" placeholder="0">
          <template #icon><PackageIcon class="w-4 h-4 text-gray-400" /></template>
        </BaseInput>
      </div>

      <!-- Status (Radio Group) -->
      <div class="flex flex-col gap-1.5 p-3 rounded-xl border border-gray-200">
        <label class="text-sm font-medium text-gray-700 flex items-center gap-1">
          <ActivityIcon class="w-4 h-4 text-gray-400" /> Status Ketersediaan
        </label>
        <div class="flex gap-4 pt-1">
          <label class="flex items-center cursor-pointer gap-2">
            <input
              type="radio"
              v-model="form.status"
              value="Tersedia"
              :disabled="Number(form.stock) <= 0"
              class="w-4 h-4 text-primary border-gray-300 focus:ring-primary"
            />
            <span class="text-sm text-gray-700">Tersedia</span>
          </label>
          <label class="flex items-center cursor-pointer gap-2">
            <input
              type="radio"
              v-model="form.status"
              value="Tidak Tersedia"
              class="w-4 h-4 text-red-600 border-gray-300 focus:ring-red-600"
            />
            <span class="text-sm text-gray-700">Tidak Tersedia</span>
          </label>
        </div>
        <p v-if="Number(form.stock) <= 0" class="text-xs text-red-500 mt-1">
          Status otomatis menjadi 'Tidak Tersedia' karena Stok habis (0).
        </p>
      </div>

      <!-- Deskripsi -->
      <div class="flex flex-col gap-1.5">
        <label class="text-sm font-medium text-gray-700 flex items-center gap-1 mb-1">
          <ScrollTextIcon class="w-4 h-4 text-gray-400" /> Deskripsi
        </label>
        <textarea
          v-model="form.description"
          rows="3"
          class="w-full px-4 py-2.5 rounded-lg border border-gray-300 text-sm focus:ring-2 focus:ring-primary/50 outline-none resize-none transition-all placeholder:text-gray-400"
          placeholder="Jelaskan detail menu, bahan, atau rasa..."
        ></textarea>
      </div>
    </form>

    <!-- FOOTER -->
    <template #footer>
      <!-- Footer Mode Detail -->
      <div v-if="mode === 'detail'" class="w-full flex justify-end">
        <BaseButton variant="outline-gray" @click="$emit('update:modelValue', false)">
          Tutup
        </BaseButton>
      </div>

      <!-- Footer Mode Form -->
      <div v-else class="flex gap-3 w-full justify-end">
        <BaseButton variant="outline-gray" @click="$emit('update:modelValue', false)">
          Batal
        </BaseButton>
        <BaseButton
          @click="handleSubmit"
          :loading="isSaving || props.loading"
          :disabled="isSaving || props.loading || !isFormValid"
        >
          <template #icon-left><SaveIcon class="w-4 h-4" /></template>
          {{ mode === "edit" ? "Simpan Perubahan" : "Simpan Menu" }}
        </BaseButton>
      </div>
    </template>
  </BaseModal>
</template>

<script setup>
import { reactive, watch, computed, ref } from "vue"; // <-- ref DITAMBAHKAN di sini
import {
  ImagePlus,
  Utensils,
  TagIcon,
  PackageSearchIcon,
  ScrollTextIcon,
  ClipboardListIcon,
  PackageIcon,
  ActivityIcon,
  SaveIcon,
} from "lucide-vue-next";

import BaseModal from "@/components/base/BaseModal.vue";
import BaseInput from "@/components/base/BaseInput.vue";
import BaseDropdown from "@/components/base/BaseDropdown.vue";
import BaseButton from "@/components/base/BaseButton.vue";

const props = defineProps({
  modelValue: Boolean,
  mode: { type: String, default: "add" },
  itemData: { type: Object, default: null },
  categoryOptions: { type: Array, default: () => [] },
  loading: { type: Boolean, default: false }, // Tambahkan prop loading dari parent
});

const emit = defineEmits(["update:modelValue", "save"]); // Emit save ke parent

const isSaving = ref(false); // State loading untuk tombol submit

// --- COMPUTED: LOGIKA STATUS OTOMATIS (Hanya untuk Tampilan/UI) ---
// Jika stok habis (<= 0) ATAU status diset manual ke 'Tidak Tersedia',
// maka menu dianggap tidak tersedia.
const isUnavailable = computed(() => {
  return Number(form.stock) <= 0 || form.status === "Tidak Tersedia";
});

// --- COMPUTED: VALIDASI FORM SEDERHANA ---
const isFormValid = computed(() => {
  // Pastikan name, price, dan category terisi
  // Price harus angka positif
  return form.name && form.price !== "" && Number(form.price) > 0 && form.category;
});

const modalTitle = computed(() => {
  if (props.mode === "detail") return "Detail Menu";
  if (props.mode === "edit") return "Update Menu";
  return "Tambah Menu Baru";
});

const defaultForm = {
  id: null, // Tambahkan ID untuk memudahkan pengiriman data edit
  name: "",
  category: "",
  price: "", // Biarkan string dulu, validasi nanti
  stock: "", // Biarkan string dulu, validasi nanti
  description: "",
  imageFile: null, // Objek File yang dipilih
  imagePreview: "https://via.placeholder.com/150x150?text=No+Image  ", // Placeholder default
  status: "Tersedia", // Default status
};

const form = reactive({ ...defaultForm });

// Watch untuk mengisi form saat itemData berubah (mode edit/detail)
watch(
  () => props.itemData,
  (newItem) => {
    // Reset form saat modal dibuka (juga saat ditutup, tapi watch akan mengisi ulang jika dibuka)
    Object.assign(form, { ...defaultForm });
    // Jangan reset imagePreview jika sedang edit/detail dan ada gambar dari BE
    if (props.mode === "edit" || props.mode === "detail") {
      form.imagePreview = newItem?.gambar_url || "https://via.placeholder.com/150x150?text=No+Image  ";
    } else {
      form.imagePreview = "https://via.placeholder.com/150x150?text=No+Image  "; // Reset jika mode add
    }
    form.imageFile = null; // Selalu reset file input FE

    if (newItem && (props.mode === "edit" || props.mode === "detail")) {
      console.log("Loading item data for edit/detail:", newItem); // Debug log
      // 1. Pemuatan Data untuk Edit/Detail
      Object.assign(form, {
        id: newItem.id_menu, // <-- PENTING: Ambil ID untuk operasi Edit
        name: newItem.menu,
        category: newItem.kategori,
        price: Number(newItem.harga).toString(), // Convert ke string untuk input type number
        stock: Number(newItem.stok).toString(), // Convert ke string untuk input type number
        description: newItem.deskripsi,
        // imagePreview sudah diisi di atas
        // Jangan set imageFile karena itu adalah objek File dari upload FE, bukan path dari BE
        status: newItem.status.charAt(0).toUpperCase() + newItem.status.slice(1), // Ubah ke format Title Case
      });
      console.log("Form ID set to:", form.id); // Debug log
    } else {
      console.log("Loading default data for add"); // Debug log
      // 2. Logika Default untuk Add
      if (props.categoryOptions.length > 0) {
        const validOption = props.categoryOptions.find((opt) => opt !== "Kategori");
        if (validOption) form.category = validOption;
      }
    }
  },
  { immediate: true, deep: true }
);

// Watch untuk menonaktifkan radio "Tersedia" jika stok 0
// Dan otomatis mengganti status jika stok 0 saat input berubah
watch(
  () => form.stock,
  (newStock) => {
    if (Number(newStock) <= 0) {
      form.status = "Tidak Tersedia";
    }
  }
);

const handleFileChange = (e) => {
  const file = e.target.files[0];
  if (file) {
    // --- VALIDASI SEDERHANA DI FE ---
    const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
    if (!allowedTypes.includes(file.type)) {
      alert('Hanya file gambar (JPG, PNG, GIF) yang diperbolehkan.');
      // Reset input file agar tidak memilih file yang salah lagi
      e.target.value = '';
      return;
    }

    if (file.size > 2 * 1024 * 1024) { // 2MB
      alert('Ukuran file tidak boleh lebih dari 2MB.');
      e.target.value = '';
      return;
    }
    // ------------------------------------

    form.imageFile = file;
    form.imagePreview = URL.createObjectURL(file);
  } else {
    // Jika tidak ada file dipilih (misalnya user klik cancel atau menghapus pilihan)
    // Kembalikan ke gambar lama jika sedang edit, atau ke placeholder jika add
    if (props.mode === 'edit' && props.itemData?.gambar_url) {
        form.imagePreview = props.itemData.gambar_url;
    } else {
        form.imagePreview = "https://via.placeholder.com/150x150?text=No+Image  ";
    }
    form.imageFile = null;
  }
};

const handleSubmit = async () => {
  if (props.mode === "detail") return;

  console.log("Submit clicked. Current form data:", { ...form });

  // Validasi form sederhana
  if (!isFormValid.value) {
    console.error("Form tidak valid. Nama, Harga (positif), dan Kategori wajib diisi.");
    return;
  }

  // Logika Status saat DISIMPAN (Bukan saat input berubah)
  // Tentukan status yang akan dikirim ke BE
  let statusToSend = form.status;
  if (Number(form.stock) <= 0) {
    statusToSend = "Tidak Tersedia";
  }

  console.log("Emitting save event with data:", {
    id: form.id,
    name: form.name,
    description: form.description,
    price: Number(form.price),
    category: form.category,
    stock: Number(form.stock),
    status: statusToSend,
    imageFile: form.imageFile, // Bisa null jika tidak ada file baru
  }); // Debug log

  // Emit event save ke parent (AdminMenu.vue)
  emit("save", {
    id: form.id, // Penting untuk update
    name: form.name,
    description: form.description,
    price: Number(form.price),
    category: form.category,
    stock: Number(form.stock),
    status: statusToSend, // Kirim status yang sudah di-override jika perlu
    imageFile: form.imageFile, // Kirim file jika ada, null jika tidak ada
  });

  // Parent (AdminMenu.vue) akan menangani loading dan penutupan modal
  // isSaving.value akan diatur oleh parent
  // emit("update:modelValue", false); // Parent akan tutup modal setelah sukses
};
</script>
