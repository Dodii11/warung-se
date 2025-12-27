<template>
  <div class="max-w-4xl mx-auto p-4 sm:p-6 lg:p-8 bg-gray-50 min-h-screen">
    <h1 class="text-3xl font-extrabold text-gray-900 mb-8 flex items-center gap-3">
      <CreditCard class="w-7 h-7 text-red-600" />
      Langkah Terakhir: Detail Pesanan
    </h1>

    <div class="grid grid-cols-1 md:grid-cols-5 gap-8">
      <!-- Kolom Kiri: Formulir Detail Pelanggan (3/5) -->
      <div class="md:col-span-3">
        <UserAppCard padding="lg">
          <h2 class="text-xl font-bold text-gray-800 mb-6 border-b pb-3 flex items-center gap-2">
            <User class="w-5 h-5" />
            Detail Pengiriman
          </h2>
          <form @submit.prevent="submitOrder" class="space-y-5">
            <!-- Nama dan Telepon -->
            <UserAppInput
              label="Nama Lengkap"
              placeholder="Contoh: Budi Santoso"
              v-model="formData.name"
              type="text"
              :error="validationErrors.name"
            />

            <UserAppInput
              label="Nomor Telepon (Aktif)"
              placeholder="Contoh: 081234567890"
              v-model="formData.phone"
              type="tel"
              :error="validationErrors.phone"
            />

            <!-- REVISI: BAGIAN ALAMAT LENGKAP -->
            <div class="space-y-5">
              <h3 class="text-lg font-semibold text-gray-800 pt-2 border-t border-gray-100">
                Alamat Lengkap
              </h3>
              <!-- 1. Detail Lokasi -->
              <UserAppInput
                label="Detail Lokasi / Ciri-ciri Alamat"
                placeholder="Contoh: Depan gang Waru, rumah warna hijau"
                v-model="formData.addressDetails"
                type="text"
                :error="validationErrors.addressDetails"
              />

              <!-- 2. Alamat Jalan -->
              <UserAppInput
                label="Alamat Jalan (Blok, Nomor, RT/RW)"
                placeholder="Contoh: Jl. Pandawa RT18 RW05, No. 45"
                v-model="formData.addressStreet"
                type="text"
                :error="validationErrors.addressStreet"
              />

             <!-- PROVINSI -->
<div class="w-full">
  <label class="block mb-1 text-sm text-gray-600">
    Provinsi
  </label>

  <select
  v-model="selectedProvinceId"
  class="w-full h-11 px-4 border rounded-lg bg-white"
>
  <option value="" disabled>Pilih Provinsi</option>
  <option
    v-for="prov in provinces"
    :key="prov.id"
    :value="prov.id"
  >
    {{ prov.name }}
  </option>
</select>

</div>



              <!-- 3. Kecamatan/Kota dan Kabupaten -->
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="w-full">
  <label class="block mb-1 text-sm text-gray-600">
    Kota / Kabupaten
  </label>

  <select
    v-model.number="selectedCityId"
    :disabled="!selectedProvinceId || loadingCities"
    class="w-full h-11 px-4
           rounded-lg border border-gray-300
           bg-white text-gray-800
           focus:outline-none focus:ring-2 focus:ring-red-500
           disabled:bg-gray-100 disabled:text-gray-400"
  >
    <option value="" disabled>
      {{ loadingCities ? "Memuat kota..." : "Pilih Kota / Kabupaten" }}
    </option>

    <option
      v-for="city in cities"
      :key="city.id"
      :value="city.id"
    >
      {{ city.name }}
    </option>
  </select>

  <p v-if="validationErrors.addressDistrict" class="text-sm text-red-500 mt-1">
    {{ validationErrors.addressDistrict }}
  </p>
</div>

                <div class="w-full">
  <label class="block mb-1 text-sm text-gray-600">
    Kecamatan
  </label>


  <select
    v-model.number="selectedDistrictId"
    :disabled="!selectedCityId || loadingDistricts"
    class="w-full h-11 px-4
           rounded-lg border border-gray-300
           bg-white text-gray-800
           focus:outline-none focus:ring-2 focus:ring-red-500
           disabled:bg-gray-100 disabled:text-gray-400"
  >
    <option value="" disabled>
      {{ loadingDistricts ? "Memuat kecamatan..." : "Pilih Kecamatan" }}
    </option>

    <option
      v-for="district in districts"
      :key="district.id"
      :value="district.id"
    >
      {{ district.name }}
    </option>
  </select>

  <p v-if="validationErrors.addressDistrict" class="text-sm text-red-500 mt-1">
    {{ validationErrors.addressDistrict }}
  </p>
</div>

              </div>
            </div>
            <!-- AKHIR REVISI ALAMAT LENGKAP -->

            <!-- Catatan Tambahan -->
            <div>
              <label
                for="note"
                class="block text-sm font-medium text-gray-700 tracking-wide mb-1.5"
              >
                Catatan Tambahan (Opsional)
              </label>
              <textarea
                id="note"
                v-model="formData.note"
                rows="2"
                placeholder="Contoh: Tolong kirim sebelum jam 18.00, atau tambahkan sambal extra."
                class="w-full px-4 py-2.5 rounded-lg text-sm transition-all border border-gray-300 outline-none focus:ring-2 focus:ring-offset-1 focus:ring-red-500 focus:border-transparent"
              ></textarea>
            </div>

            <UserAppButton
              type="submit"
              size="lg"
              class="w-full mt-6"
              :disabled="!isFormValid || loading"
              :loading="loading"
            >
              Konfirmasi Pesanan
              <template #icon-right>
                <Send class="w-5 h-5" />
              </template>
            </UserAppButton>
          </form>
        </UserAppCard>
      </div>

      <!-- Kolom Kanan: Ringkasan Pesanan (2/5) -->
      <div class="md:col-span-2 space-y-5">
        <UserAppCard>
          <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-3 flex items-center gap-2">
            <Receipt class="w-5 h-5" />
            Ringkasan Pesanan
          </h2>

          <!-- Detail Perhitungan Harga (dalam space-y-3) -->
          <div class="space-y-3 text-sm text-gray-700">
            <!-- Rincian Item -->
            <div v-for="item in cartItems" :key="item.id" class="flex justify-between items-start">
              <span class="text-gray-600 pr-2 grow min-w-0">{{ item.name }} ({{ item.qty }}x)</span>
              <span class="font-medium text-gray-800 shrink-0 whitespace-nowrap">{{
                formatCurrency(item.total)
              }}</span>
            </div>

            <hr class="my-3 border-gray-200" />

            <!-- Subtotal -->
            <div class="flex justify-between font-semibold">
              <span class="grow min-w-0">Subtotal Produk</span>
              <span class="shrink-0 whitespace-nowrap">{{ formatCurrency(subtotal) }}</span>
            </div>

            <!-- Biaya Pengiriman -->
            <div class="flex justify-between">
              <span class="grow min-w-0"
                >Biaya Pengiriman <Truck class="w-4 h-4 inline ml-1 text-red-500"
              /></span>
              <span class="font-semibold shrink-0 whitespace-nowrap">{{
                formatCurrency(shippingFee)
              }}</span>
            </div>

            <!-- PPN (Jika ada) -->
            <div class="flex justify-between">
              <span class="grow min-w-0">Pajak (PPN 0%)</span>
              <span class="font-semibold shrink-0 whitespace-nowrap">{{
                formatCurrency(ppn)
              }}</span>
            </div>
          </div>

          <!-- Total Akhir (Paling Kritis) - Dibuat terpisah dan menonjol -->
          <div class="mt-6 pt-4 border-t-2 border-red-500/20">
            <div
              class="flex flex-wrap justify-between items-center gap-2 p-4 rounded-xl bg-red-50 border border-red-200 shadow-lg"
            >
              <!-- Label Total -->
              <span
                class="text-xl font-extrabold text-red-800 flex-1 min-w-40 wrap-break-word leading-snug"
              >
                TOTAL PEMBAYARAN
              </span>

              <!-- Angka Total -->
              <span
                class="text-2xl sm:text-3xl font-black text-red-700 shrink-0 whitespace-nowrap text-right"
              >
                {{ formatCurrency(total) }}
              </span>
            </div>
          </div>
        </UserAppCard>

        <div class="text-center p-3 text-xs text-gray-500">
          Pastikan Anda telah memeriksa detail keranjang
          <span class="text-red-500 cursor-pointer hover:underline" @click="goBackToCart"
            >(Ubah Keranjang)</span
          >
          sebelum mengirim pesanan.
        </div>
      </div>
    </div>

    <!-- MODAL DETAIL PESANAN -->
    <UserAppModal :show="showOrderModal" @close="showOrderModal = false" size="lg">
      <DetailPesanan
        :order-data="latestOrderData"
        :order-id="latestOrderId"
        @close="handleCloseDetail"
      />
    </UserAppModal>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from "vue";
import { useRouter } from "vue-router";
import { fetchCart, clearCart } from "@/api/cart";
import { checkoutPesanan } from "@/api/pesanan";
import { fetchCheckoutProfile } from "@/api/account";
import { fetchProvinces, fetchCities, fetchDistricts   } from "@/api/rajaongkir";

import UserAppCard from "@/components/baseUser/UserAppCard.vue";
import UserAppInput from "@/components/baseUser/UserAppInput.vue";
import UserAppButton from "@/components/baseUser/UserAppButton.vue";
import UserAppModal from "@/components/baseUser/UserAppModal.vue";
import DetailPesanan from "@/views/user/DetailPesanan.vue";

import { User, Truck, Receipt, CreditCard, Send } from "lucide-vue-next";

const router = useRouter();

// ================= STATE =================
const cartItems = ref([]);
const subtotal = ref(0);
const shippingFee = ref(5000);
const ppn = ref(0);
const loading = ref(false);

const showOrderModal = ref(false);
const latestOrderData = ref(null);
const latestOrderId = ref(null);

// ================= RAJA ONGKIR =================
const provinces = ref([]);
const cities = ref([]);
const selectedProvinceId = ref("");
const selectedCityId = ref("");
const loadingCities = ref(false);
const districts = ref([]);
const selectedDistrictId = ref("");
const loadingDistricts = ref(false);

// ================= FORM =================
const formData = ref({
  name: "",
  phone: "",
  addressDetails: "",
  addressStreet: "",
  addressDistrict: "",
  addressRegency: "",
  note: "",
});

const validationErrors = ref({});

// ================= LOAD CART =================
onMounted(async () => {
  await autofillCheckout();
  const res = await fetchCart();
  loadProvinces();

  cartItems.value = (res.data.data || []).map((item) => ({
    id_menu: item.id_menu,
    name: item.menu?.menu ?? "Menu tidak ditemukan",
    qty: item.jumlah ?? 0,
    total: Number(item.subtotal ?? 0),
  }));

  subtotal.value = cartItems.value.reduce((s, i) => s + i.total, 0);
});

// ================= COMPUTED =================
const total = computed(() => subtotal.value + shippingFee.value + ppn.value);

const isFormValid = computed(
  () => formData.value.name && formData.value.phone && formData.value.addressStreet
);

// ================= UTIL =================
function formatCurrency(val) {
  return new Intl.NumberFormat("id-ID", {
    style: "currency",
    currency: "IDR",
  }).format(val || 0);
}

// ================= SUBMIT ORDER =================
async function submitOrder() {
  try {
    loading.value = true;

    const payload = {
      cart: cartItems.value.map((item) => ({
        id_menu: item.id_menu,
        jumlah: item.qty,
      })),
      catatan: formData.value.note ?? "",
    };
    const res = await checkoutPesanan(payload);

    latestOrderData.value = {
      orderNumber: res.data.id_pesanan,
      status: res.data.status,
      customer: {
        name: formData.value.name,
        phone: formData.value.phone,
        address: `${formData.value.addressStreet}, ${formData.value.addressDistrict}, ${formData.value.addressRegency}`,
      },
      items: res.data.detail.map((d) => ({
        name: d.menu?.menu ?? "-",
        qty: d.jumlah,
        total: d.subtotal,
        image: d.menu?.image_url ? `/storage/${d.menu.image_url}` : null,
      })),
      subtotal: res.data.total_harga,
      shippingFee: shippingFee.value,
      total: res.data.total_harga + shippingFee.value,
    };

    latestOrderId.value = res.data.id_pesanan;

    // Simpan untuk ReceiptPage
    localStorage.setItem("latestOrder", JSON.stringify(latestOrderData.value));

    await clearCart();
    showOrderModal.value = true;
  } catch (err) {
    console.error("CHECKOUT ERROR:", err);
    alert("Gagal membuat pesanan");
  } finally {
    loading.value = false;
  }
}

async function loadProvinces() {
  try {
    const res = await fetchProvinces();
    provinces.value = res.data.data ?? [];
  } catch (e) {
    console.error("Gagal load provinsi", e);
  }
}

onMounted(loadProvinces);


async function autofillCheckout() {
  try {
    const res = await fetchCheckoutProfile();
    const data = res.data;

    // data user
    formData.value.name = data.nama_user ?? "";
    formData.value.phone = data.no_telp ?? "";

    // data alamat default
    if (data.alamat) {
      formData.value.addressDetails = data.alamat.data_lokasi ?? "";
      formData.value.addressStreet = data.alamat.alamat ?? "";
      formData.value.addressDistrict = data.alamat.kecamatan ?? "";
      formData.value.addressRegency = data.alamat.kota ?? "";
    }
  } catch (e) {
    console.warn("Autofill gagal", e);
  }
}

function goBackToCart() {
  router.push("/cart");
}

watch(selectedProvinceId, async (provinceId) => {
  if (!provinceId) return;

  selectedCityId.value = "";
  selectedDistrictId.value = "";
  cities.value = [];
  districts.value = [];

  loadingCities.value = true;
  loadingDistricts.value = false; // ⬅️ PENTING

  try {
    const res = await fetchCities(provinceId);
    cities.value = res.data ?? [];
  } catch (e) {
    console.error("Gagal load kota", e);
  } finally {
    loadingCities.value = false;
  }
});



watch(selectedCityId, async (cityId) => {
  if (!cityId) return;

  selectedDistrictId.value = "";
  districts.value = [];
  loadingDistricts.value = true;

  try {
    const res = await fetchDistricts(cityId);

    // ⬇️ karena API kamu return ARRAY LANGSUNG
    districts.value = res.data ?? [];

    console.log("DISTRICTS:", districts.value);
  } catch (e) {
    console.error("Gagal load kecamatan", e);
  } finally {
    loadingDistricts.value = false;
  }
});

watch(selectedDistrictId, (districtId) => {
  const district = districts.value.find(d => d.id == districtId);
  if (district) {
    formData.value.addressDistrict = district.name;
  }
});
watch(selectedDistrictId, (v) => {
  console.log("SELECTED DISTRICT:", v, typeof v);
});

</script>
