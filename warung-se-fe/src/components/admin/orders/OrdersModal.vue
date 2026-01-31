<template>
  <BaseModal
    :model-value="modelValue"
    @update:model-value="$emit('update:modelValue', $event)"
    :title="modalTitle"
  >
    <!-- DETAIL MODE -->
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

      <!-- Detail Tanggal -->
      <div class="flex items-center gap-2 text-sm text-gray-500 bg-gray-50 px-3 py-2 rounded-lg">
        <CalendarIcon class="w-4 h-4" />
        <span>
          Dipesan pada:
          <span class="font-medium text-gray-700">{{ form.date }}</span>
        </span>
      </div>

      <!-- Rincian Pelanggan dan Driver -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Pelanggan -->
        <BaseCard class="p-5 space-y-4 shadow-sm border border-gray-100">
          <div class="flex items-center gap-2 pb-2 border-b border-gray-100">
            <UserIcon class="w-5 h-5 text-indigo-500" />
            <h3 class="text-base font-semibold text-gray-900">Pelanggan</h3>
          </div>
          <dl class="text-sm space-y-3">
            <div>
              <dt class="font-medium text-gray-900">{{ form.customer }}</dt>
            </div>
            <div class="flex flex-col pt-2 border-t border-gray-50">
              <dt class="text-xs font-medium text-gray-500">Nomor Telepon:</dt>
              <dd class="text-gray-700 font-medium break-all">
                {{ form.customerPhone || "N/A" }}
              </dd>
            </div>
            <div class="flex flex-col">
              <dt class="text-xs font-medium text-gray-500">Alamat Pengiriman:</dt>
              <dd class="text-gray-700 line-clamp-2">
                {{ form.customerAddress || "N/A" }}
              </dd>
            </div>
          </dl>
        </BaseCard>

        <!-- Driver -->
        <BaseCard class="p-5 space-y-4 shadow-sm border border-gray-100">
          <div class="flex items-center gap-2 pb-2 border-b border-gray-100">
            <TruckIcon class="w-5 h-5 text-teal-500" />
            <h3 class="text-base font-semibold text-gray-900">Driver</h3>
          </div>
          <dl class="text-sm space-y-3">
            <div>
              <dt
                :class="
                  form.driver && form.driver !== 'Belum ditetapkan'
                    ? 'text-gray-900'
                    : 'text-red-500 italic'
                "
              >
                {{ driverName }}
              </dt>
            </div>
            <div class="flex flex-col pt-2 border-t border-gray-50">
              <dt class="text-xs font-medium text-gray-500">Nomor Telepon:</dt>
              <dd class="text-gray-700 font-medium break-all">
                {{ form.driverPhone || "N/A" }}
              </dd>
            </div>
            <div class="flex flex-col">
              <dt class="text-xs font-medium text-gray-500">Nama Kendaraan/Plat:</dt>
              <dd class="text-gray-700 font-medium">
                {{ form.driverVehicle || "N/A" }}
              </dd>
            </div>
          </dl>
        </BaseCard>
      </div>

      <!-- Rincian Item -->
      <div>
        <label
          class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-2 flex items-center gap-1"
        >
          <ShoppingBagIcon class="w-3 h-3" /> Rincian Pesanan
        </label>

        <div class="border border-gray-200 rounded-xl overflow-hidden">
          <div class="divide-y divide-gray-100 max-h-48 overflow-y-auto bg-white">
            <div
              v-for="(item, index) in form.items"
              :key="index"
              class="p-3 flex justify-between items-center hover:bg-gray-50"
            >
              <div class="flex items-center gap-3">
                <div
                  class="w-10 h-10 rounded-lg bg-gray-100 border border-gray-200 overflow-hidden shrink-0"
                >
                  <img :src="item.image || ''" class="w-full h-full object-cover" alt="item" />
                </div>
                <div>
                  <p class="text-sm font-medium text-gray-900 line-clamp-1">
                    {{ item.name }}
                  </p>
                  <p class="text-xs text-gray-500">
                    {{ item.qty }} x Rp {{ formatCurrency(item.price) }}
                  </p>
                </div>
              </div>
              <span class="font-semibold text-gray-700 text-sm">
                Rp {{ formatCurrency(item.qty * item.price) }}
              </span>
            </div>

            <!-- CATATAN PESANAN -->
            <div
              v-if="form.catatan"
              class="border-t bg-gray-50 border-gray-200  px-4 py-3 text-sm text-gray-700"
            >
              <p class="text-xs font-semibold text-gray-500 ">Catatan Pelanggan</p>
              <p class="text-xs whitespace-pre-line">
                {{ form.catatan }}
              </p>
            </div>
          </div>

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
              <span class="text-xl font-bold text-primary">
                Rp {{ formatCurrency(grandTotal) }}
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- FORM MODE -->
    <form v-else @submit.prevent="handleSubmit" class="space-y-6">
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

        <div v-if="isShippingStatus" class="flex flex-col gap-2">
          <label class="text-sm font-medium text-gray-700 flex items-center gap-1">
            <TruckIcon class="w-4 h-4 text-gray-400" /> Tetapkan Driver
          </label>
          <BaseDropdown v-model="form.driver" :options="driverOptions" class="w-full" />
        </div>
      </div>
    </form>

    <template #footer>
      <div v-if="mode === 'detail'" class="w-full flex justify-between">
        <BaseButton variant="primary" @click="handlePrint">
          <template #icon-left>
            <PrinterIcon class="w-4 h-4" />
          </template>
          Cetak
        </BaseButton>
        <BaseButton variant="outline-gray" @click="$emit('update:modelValue', false)">
          Tutup
        </BaseButton>
      </div>

      <div v-else class="flex gap-3 w-full justify-end">
        <BaseButton variant="outline-gray" @click="$emit('update:modelValue', false)">
          Batal
        </BaseButton>
        <BaseButton @click="handleSubmit" :loading="isSaving">
          <template #icon-left>
            <SaveIcon class="w-4 h-4" />
          </template>
          Simpan
        </BaseButton>
      </div>
    </template>
  </BaseModal>
</template>

<script setup>
import { ref, reactive, computed, watch } from "vue";
import BaseModal from "@/components/base/BaseModal.vue";
import BaseDropdown from "@/components/base/BaseDropdown.vue";
import BaseButton from "@/components/base/BaseButton.vue";
import BaseStatusBadge from "@/components/base/BaseStatusBadge.vue";
import BaseCard from "@/components/base/BaseCard.vue";
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
  itemData: { type: Object, default: null },
  statusOptions: { type: Array, default: () => [] },
  driverOptions: { type: Array, default: () => [] },
  driverOptionsMap: { type: Object, default: () => ({}) },
});

const emit = defineEmits(["update:modelValue", "save"]);

const isSaving = ref(false);
const shippingCost = 5000;

const modalTitle = computed(() => (props.mode === "detail" ? "Detail Pesanan" : "Update Pesanan"));
const driverName = computed(() => {
  if (!form.driver) return "Belum ditetapkan";
  return props.driverOptionsMap[form.driver] || form.driver;
});

const defaultForm = {
  id: "",
  apiId: null,
  customer: "",
  date: "",
  status: "",
  driver: "",
  customerPhone: "",
  customerAddress: "",
  driverPhone: "",
  driverVehicle: "",
  items: [],
  catatan: "",
};

const form = reactive({ ...defaultForm });

const isShippingStatus = computed(() => form.status === "Dikirim");
const formatAlamat = (a) => {
  if (!a) return "-";
  return `${a.alamat}, ${a.kecamatan}, ${a.data_lokasi}`;
};

const initForm = () => {
  const d = props.itemData || {};

  Object.assign(form, {
    ...defaultForm,
    id: d.id_pesanan || "-",
    apiId: d.id_pesanan,
    status: d.status || "Tertunda",
    date: d.tanggal_pesanan ? new Date(d.tanggal_pesanan).toLocaleDateString("id-ID") : "-",
    customer: d.user?.nama_user || "-",
    customerPhone: d.user?.no_telp || "-",
    customerAddress: formatAlamat(d.alamat),
    driver: d.driver?.id_driver || "",
    driverPhone: d.driver?.no_telp || "-",
    driverVehicle: d.driver?.plat_kendaraan || "-",
    catatan: d.catatan || "",
    items: Array.isArray(d.detail)
      ? d.detail.map((i) => ({
          name: i.menu?.menu || "-",
          image: i.menu?.gambar_url || "",
          qty: i.jumlah,
          price: i.menu?.harga || 0,
        }))
      : [],
  });
};

watch(
  () => props.modelValue,
  (v) => {
    if (v) initForm();
  }
);

const subtotal = computed(() =>
  Array.isArray(form.items) ? form.items.reduce((sum, i) => sum + i.price * i.qty, 0) : 0
);

const grandTotal = computed(() => subtotal.value + shippingCost);
const formatCurrency = (v) => Number(v).toLocaleString("id-ID");

const handleSubmit = async () => {
  isSaving.value = true;

  await emit("save", {
    id: form.apiId,
    status: form.status,
    driver: isShippingStatus.value ? form.driver : null, // NAMA
  });

  isSaving.value = false;
  emit("update:modelValue", false);
};

const handlePrint = () => console.log(`Printing order ID: ${form.id}`);
</script>
