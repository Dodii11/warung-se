<template>
  <BaseModal
    :model-value="modelValue"
    @update:model-value="$emit('update:modelValue', $event)"
    :title="modalTitle"
  >
    <!-- =========================
         MODE DETAIL (READ ONLY)
         ========================= -->
    <div v-if="mode === 'detail'" class="space-y-6">
      <!-- Header Status -->
      <div
        class="flex justify-between items-center bg-gray-50 p-4 rounded-xl border border-gray-200"
      >
        <div>
          <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">ID Pesanan</p>
          <p class="text-lg font-bold text-gray-900">{{ form.id }}</p>
        </div>
        <BaseStatusBadge :status="form.status" />
      </div>

      <!-- Info Pelanggan -->
      <div class="grid grid-cols-2 gap-4">
        <div class="bg-white p-3 rounded-lg border border-gray-100 shadow-sm">
          <div class="flex items-center gap-2 mb-1">
            <UserIcon class="w-3 h-3 text-gray-400" />
            <label class="text-xs font-medium text-gray-500 uppercase tracking-wide"
              >Pelanggan</label
            >
          </div>
          <p class="font-semibold text-gray-900 pl-5">{{ form.customer }}</p>
        </div>

        <div class="bg-white p-3 rounded-lg border border-gray-100 shadow-sm">
          <div class="flex items-center gap-2 mb-1">
            <TruckIcon class="w-3 h-3 text-gray-400" />
            <label class="text-xs font-medium text-gray-500 uppercase tracking-wide">Driver</label>
          </div>
          <p
            class="font-medium pl-5"
            :class="
              form.driver && form.driver !== 'Belum ditetapkan'
                ? 'text-gray-900'
                : 'text-red-500 italic'
            "
          >
            {{
              form.driver && form.driver !== "Belum ditetapkan" ? form.driver : "Belum Ditetapkan"
            }}
          </p>
        </div>
      </div>

      <!-- Detail Tanggal -->
      <div class="flex items-center gap-2 text-sm text-gray-500 bg-gray-50 px-3 py-2 rounded-lg">
        <CalendarIcon class="w-4 h-4" />
        <span
          >Dipesan pada: <span class="font-medium text-gray-700">{{ form.date }}</span></span
        >
      </div>

      <!-- Rincian Item -->
      <div>
        <label
          class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-2 flex items-center gap-1"
        >
          <ShoppingBagIcon class="w-3 h-3" /> Rincian Pesanan
        </label>
        <div class="border border-gray-200 rounded-xl overflow-hidden">
          <!-- List Item -->
          <div class="divide-y divide-gray-100 max-h-48 overflow-y-auto bg-white">
            <div
              v-for="(item, index) in currentItems"
              :key="index"
              class="p-3 flex justify-between items-center hover:bg-gray-50"
            >
              <div class="flex items-center gap-3">
                <div
                  class="w-10 h-10 rounded-lg bg-gray-100 border border-gray-200 overflow-hidden shrink-0"
                >
                  <img :src="item.image" class="w-full h-full object-cover" alt="item" />
                </div>
                <div>
                  <p class="text-sm font-medium text-gray-900 line-clamp-1">{{ item.name }}</p>
                  <p class="text-xs text-gray-500">
                    {{ item.qty }} x Rp {{ formatCurrency(item.price) }}
                  </p>
                </div>
              </div>
              <span class="font-semibold text-gray-700 text-sm">
                Rp {{ formatCurrency(item.qty * item.price) }}
              </span>
            </div>
          </div>

          <!-- Kalkulasi Harga -->
          <div class="bg-gray-50 p-4 space-y-2 border-t border-gray-200">
            <div class="flex justify-between text-xs text-gray-500">
              <span>Subtotal</span>
              <span>Rp {{ formatCurrency(subtotal) }}</span>
            </div>
            <div class="flex justify-between text-xs text-gray-500">
              <span>Ongkos Kirim</span>
              <span>Rp {{ formatCurrency(shippingCost) }}</span>
            </div>
            <div class="pt-2 border-t border-gray-200 flex justify-between items-center">
              <span class="text-sm font-bold text-gray-800">Total Bayar</span>
              <span class="text-xl font-bold text-primary"
                >Rp {{ formatCurrency(grandTotal) }}</span
              >
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- =========================
         MODE FORM (EDIT)
         ========================= -->
    <form v-else @submit.prevent="handleSubmit" class="space-y-6">
      <!-- Info Ringkas -->
      <div class="p-4 bg-blue-50 border border-blue-100 rounded-xl flex items-center gap-4">
        <div
          class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 shrink-0"
        >
          <UserIcon class="w-5 h-5" />
        </div>
        <div class="flex-1">
          <p class="text-xs text-blue-600 font-bold uppercase tracking-wider mb-0.5">Pelanggan</p>
          <p class="text-blue-900 font-bold text-lg">{{ form.customer }}</p>
          <p class="text-xs text-blue-500">ID: {{ form.id }}</p>
        </div>
      </div>

      <div class="grid grid-cols-1 gap-5">
        <div class="flex flex-col gap-2">
          <label class="text-sm font-medium text-gray-700 flex items-center gap-1">
            <ActivityIcon class="w-4 h-4 text-gray-400" /> Status Pesanan
          </label>
          <BaseDropdown v-model="form.status" :options="statusOptions" class="w-full" />
        </div>

        <div class="flex flex-col gap-2">
          <label class="text-sm font-medium text-gray-700 flex items-center gap-1">
            <TruckIcon class="w-4 h-4 text-gray-400" /> Tetapkan Driver
          </label>
          <BaseDropdown v-model="form.driver" :options="driverOptions" class="w-full" />
        </div>
      </div>
    </form>

    <!-- FOOTER -->
    <template #footer>
      <div v-if="mode === 'detail'" class="w-full flex justify-between">
        <BaseButton variant="primary" @click="handlePrint">
          <template #icon-left><PrinterIcon class="w-4 h-4" /></template>
          Cetak
        </BaseButton>
        <BaseButton variant="outline-gray" @click="$emit('update:modelValue', false)"
          >Tutup</BaseButton
        >
      </div>

      <div v-else class="flex gap-3 w-full justify-end">
        <BaseButton variant="outline-gray" @click="$emit('update:modelValue', false)"
          >Batal</BaseButton
        >
        <BaseButton @click="handleSubmit" :loading="isSaving">
          <template #icon-left><SaveIcon class="w-4 h-4" /></template>
          Simpan
        </BaseButton>
      </div>
    </template>
  </BaseModal>
</template>

<script setup>
import { ref, reactive, watch, computed } from "vue";
import BaseModal from "@/components/base/BaseModal.vue";
import BaseDropdown from "@/components/base/BaseDropdown.vue";
import BaseButton from "@/components/base/BaseButton.vue";
import BaseStatusBadge from "@/components/base/BaseStatusBadge.vue";

import {
  UserIcon,
  TruckIcon,
  CalendarIcon,
  ShoppingBagIcon,
  PrinterIcon,
  SaveIcon,
  ActivityIcon,
} from "lucide-vue-next";

const props = defineProps({
  modelValue: Boolean,
  mode: { type: String, default: "detail" },
  order: { type: Object, default: null }, // dari Dashboard
  itemData: { type: Object, default: null }, // dari Orders page
  statusOptions: { type: Array, default: () => [] },
  driverOptions: { type: Array, default: () => [] },
});

const emit = defineEmits(["update:modelValue", "save"]);

const isSaving = ref(false);
const shippingCost = 10000; // Tetap sama seperti versi lama

// ===============================
//   Title (dipertahankan)
// ===============================
const modalTitle = computed(() =>
  props.mode === "detail" ? "Rincian Pesanan" : "Update Status Pesanan"
);

// ===============================
//   Default Form (dipertahankan)
// ===============================
const defaultForm = {
  id: "",
  customer: "",
  date: "",
  status: "",
  driver: "",
  items: [],
};

const form = reactive({ ...defaultForm });

// ===============================
//   Dummy Items (dipertahankan)
// ===============================
const dummyItems = [
  {
    name: "Ayam Geprek Sambal Matah",
    qty: 2,
    price: 14000,
    image: "https://via.placeholder.com/150",
  },
  {
    name: "Es Teh Manis",
    qty: 2,
    price: 3000,
    image: "https://via.placeholder.com/150",
  },
];

// ===============================
//   Data final: itemData > order
// ===============================
const sourceData = computed(() => {
  return props.itemData || props.order || {};
});

// ===============================
//   Init form setiap buka modal
// ===============================
const initForm = () => {
  const d = sourceData.value;

  Object.assign(form, {
    ...defaultForm,
    ...d,
    driver: d.driver || "Belum ditetapkan",
    items: d.items || [],
  });
};

// trigger saat modal dibuka
watch(
  () => props.modelValue,
  (v) => {
    if (v) initForm();
  }
);

// ===============================
//   Perhitungan (dipertahankan)
// ===============================
const currentItems = computed(() => {
  return form.items && form.items.length > 0 ? form.items : dummyItems;
});

const subtotal = computed(() =>
  currentItems.value.reduce((sum, item) => sum + item.price * item.qty, 0)
);

const grandTotal = computed(() => subtotal.value + shippingCost);

const formatCurrency = (value) => Number(value).toLocaleString("id-ID");

// ===============================
//  Submit (dipertahankan)
// ===============================
const handleSubmit = async () => {
  isSaving.value = true;
  await new Promise((r) => setTimeout(r, 800));

  emit("save", {
    id: form.id,
    status: form.status,
    driver: form.driver,
  });

  isSaving.value = false;
  emit("update:modelValue", false);
};

const handlePrint = () => {
  alert(`Printing ${form.id}...`);
};
</script>

<style scoped>
.max-h-48::-webkit-scrollbar {
  width: 4px;
}
.max-h-48::-webkit-scrollbar-track {
  background: #f1f1f1;
}
.max-h-48::-webkit-scrollbar-thumb {
  background: #cbd5e1;
  border-radius: 2px;
}
.max-h-48::-webkit-scrollbar-thumb:hover {
  background: #94a3b8;
}
</style>
