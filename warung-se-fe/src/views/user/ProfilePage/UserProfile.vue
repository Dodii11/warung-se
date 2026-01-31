<template>
  <div class="min-h-screen bg-gray-50 pb-16 font-sans">
    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">
      <!-- Header -->
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-extrabold text-gray-900">Profile</h1>
        <UserAppButton
          variant="secondary"
          size="sm"
          @click="handleLogout"
          class="text-sm shadow-md"
          :disabled="auth.loading"
        >
          <LogOut class="w-4 h-4 mr-1" />
          {{ auth.loading ? "Memproses..." : "Logout" }}
        </UserAppButton>
      </div>

      <!-- Tabs -->
      <div class="flex space-x-4 border-b border-gray-200 overflow-x-auto pb-1 mb-8">
        <UserAppCategoryButton :isActive="activeTab === 'profile'" @click="activeTab = 'profile'">
          <div class="flex items-center gap-2"><User class="w-4 h-4" /> Profil Saya</div>
        </UserAppCategoryButton>
        <UserAppCategoryButton :isActive="activeTab === 'orders'" @click="activeTab = 'orders'">
          <div class="flex items-center gap-2"><ShoppingBag class="w-4 h-4" /> Riwayat Pesanan</div>
        </UserAppCategoryButton>
      </div>

      <!-- Content -->
      <UserProfilePage
        v-if="activeTab === 'profile'"
        :profileData="profile"
        :addressData="activeAlamat || { alamat: '', kecamatan: '', kota: '', data_lokasi: '' }"
        :passwordData="passwordData"
        :errors="passwordError"
        @saveProfile="saveProfileChanges"
        @saveAddress="saveAddressChanges"
        @savePassword="savePasswordChanges"
      />

      <UserOrdersPage
        v-if="activeTab === 'orders'"
        :orders="orders"
        @printReceipt="handlePrintReceipt"
        :loading="loadingOrders"
      />
    </main>
  </div>
</template>

<script setup>
import { ref, computed, reactive } from "vue";
import { LogOut, User, ShoppingBag } from "lucide-vue-next";
import { useRouter } from "vue-router";
import { updateProfile, updatePassword } from "@/api/account";
import { getAlamatList, createAlamat, updateAlamat } from "@/api/alamat";
import { OrdersAPI } from "@/api/orders";
import { useAuth } from "@/stores/auth";

import UserProfilePage from "./UserProfilePage.vue";
import UserOrdersPage from "./UserOrdersPage.vue";

import UserAppButton from "@/components/baseUser/UserAppButton.vue";
import UserAppCategoryButton from "@/components/baseUser/UserAppCategoryButton.vue";

const auth = useAuth();
const router = useRouter();

const activeTab = ref("profile");

const profile = computed(() => ({
  name: auth.user?.nama_user || "",
  email: auth.user?.email_user || "",
  phone: auth.user?.no_telp || "",
}));

const alamatList = ref([]);
const loadingAlamat = ref(false);
const activeAlamat = computed(() => alamatList.value.find((a) => a.is_default) || null);

const passwordData = reactive({ current: "", new: "", confirm: "" });
const passwordError = reactive({ current: "", new: "", confirm: "" });

const orders = ref([]);
const loadingOrders = ref(false);

// =======================
// Fetch Orders (User)
// =======================
const fetchOrders = async () => {
  loadingOrders.value = true;
  try {
    const res = await OrdersAPI.getUserOrders();

    // karena orders.js sudah return res.data
    if (!Array.isArray(res)) {
      console.warn("Orders bukan array:", res);
      orders.value = [];
      return;
    }

    orders.value = res.map(adaptOrder);
  } catch (error) {
    console.error("Gagal load orders:", error);
    orders.value = [];
  } finally {
    loadingOrders.value = false;
  }
};

fetchOrders();

// =======================
// Helpers
// =======================
const adaptOrder = (p) => ({
  id: p.id_pesanan,
  orderNumber: p.id_pesanan,
  date: new Date(p.tanggal_pesanan).toLocaleDateString("id-ID"),
  items: p.detail?.reduce((sum, d) => sum + d.jumlah, 0) || 0,
  total: `Rp ${Number(p.total_harga).toLocaleString("id-ID")}`,
  status: normalizeStatus(p.status),
  driver: p.driver?.nama_driver || "Belum ditetapkan",
  raw: p,
});

const normalizeStatus = (status) => {
  if (!status) return "";
  const map = {
    tertunda: "Tertunda",
    diproses: "Diproses",
    dikirim: "Dikirim",
    selesai: "Selesai",
    gagal: "Gagal",
  };
  return map[status.toLowerCase()] || status;
};

// =======================
// Logout
// =======================
const handleLogout = async () => {
  try {
    await auth.logout();
    router.push({ name: "Login" });
  } catch (error) {
    console.error("Gagal logout:", error);
  }
};

// =======================
// Profile / Address / Password
// =======================
const saveProfileChanges = async (newProfileData) => {
  try {
    const payload = { nama_user: newProfileData.name, no_telp: newProfileData.phone };
    const res = await updateProfile(payload);
    auth.user = { ...auth.user, ...res.data };
    console.log("Profil berhasil diperbarui", res.data);
  } catch (error) {
    console.error("Gagal update profil:", error);
  }
};

const fetchAlamat = async () => {
  loadingAlamat.value = true;
  try {
    const res = await getAlamatList();
    alamatList.value = res.data;
  } catch (error) {
    console.error("Gagal load alamat:", error);
  } finally {
    loadingAlamat.value = false;
  }
};

fetchAlamat();

const saveAddressChanges = async (newAddressData) => {
  try {
    if (activeAlamat.value?.id_alamat) {
      await updateAlamat(activeAlamat.value.id_alamat, newAddressData);
    } else {
      await createAlamat(newAddressData);
    }
    await fetchAlamat();
    alert("Alamat berhasil disimpan");
  } catch (error) {
    console.error("Gagal menyimpan alamat:", error);
    alert("Gagal menyimpan alamat");
  }
};

const savePasswordChanges = async (payload) => {
  passwordError.current = passwordError.new = passwordError.confirm = "";
  try {
    await updatePassword({
      current_password: payload.current,
      new_password: payload.new,
      new_password_confirmation: payload.confirm,
    });
    passwordData.current = passwordData.new = passwordData.confirm = "";
    alert("Password berhasil diperbarui");
  } catch (error) {
    if (error.response?.status === 422) {
      const errors = error.response.data.errors;
      if (errors?.current_password) passwordError.current = errors.current_password[0];
      if (errors?.new_password) passwordError.new = errors.new_password[0];
      if (errors?.new_password_confirmation)
        passwordError.confirm = errors.new_password_confirmation[0];
      if (error.response.data.message) passwordError.current = error.response.data.message;
    } else {
      console.error(error);
      alert("Terjadi kesalahan server");
    }
  }
};

const handlePrintReceipt = (orderId) => {
  console.log(`Cetak resi pesanan ${orderId}`);
};
</script>
