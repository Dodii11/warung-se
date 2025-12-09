<template>
  <div class="min-h-screen bg-gray-50 pb-16 font-sans">
    <!-- Main Content Area -->
    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">
      <!-- Combined Header: Title and Logout Button -->
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-extrabold text-gray-900">Profile</h1>

        <!-- Tombol Logout yang sekarang memanggil fungsi handleLogout -->
        <UserAppButton
          variant="secondary"
          size="sm"
          @click="handleLogout"
          class="text-sm shadow-md"
          :disabled="authStore.isLoading"
        >
          <LogOut class="w-4 h-4 mr-1" />
          {{ authStore.isLoading ? "Memproses..." : "Logout" }}
        </UserAppButton>
      </div>

      <!-- Tab Navigation -->
      <div class="flex space-x-4 border-b border-gray-200 overflow-x-auto pb-1 mb-8">
        <UserAppCategoryButton :isActive="activeTab === 'profile'" @click="activeTab = 'profile'">
          <div class="flex items-center gap-2"><User class="w-4 h-4" /> Profil Saya</div>
        </UserAppCategoryButton>
        <UserAppCategoryButton :isActive="activeTab === 'orders'" @click="activeTab = 'orders'">
          <div class="flex items-center gap-2"><ShoppingBag class="w-4 h-4" /> Riwayat Pesanan</div>
        </UserAppCategoryButton>
      </div>

      <!-- Conditional Content Rendering -->
      <UserProfilePage
        v-if="activeTab === 'profile'"
        :profileData="profile"
        :addressData="address"
        :passwordData="password"
        @saveProfile="saveProfileChanges"
        @saveAddress="saveAddressChanges"
        @savePassword="savePasswordChanges"
      />

      <UserOrdersPage
        v-if="activeTab === 'orders'"
        :orders="orders"
        @printReceipt="handlePrintReceipt"
      />
    </main>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { LogOut, User, ShoppingBag } from "lucide-vue-next";
import { useRouter } from "vue-router";
import { useAuthStore } from "@/stores/authStore";

import UserProfilePage from "./UserProfilePage.vue";
import UserOrdersPage from "./UserOrdersPage.vue";

import UserAppButton from "@/components/baseUser/UserAppButton.vue";
import UserAppCategoryButton from "@/components/baseUser/UserAppCategoryButton.vue";

// Inisialisasi Store dan Router
const authStore = useAuthStore();
const router = useRouter();

// FUNGSI LOGOUT AKTUAL
const handleLogout = async () => {
  try {
    await authStore.logout();
    await router.push({ name: "Login" });
    console.log("Logout berhasil dan dialihkan ke halaman Login.");
  } catch (error) {
    console.error("Gagal melakukan logout:", error);
  }
};

const activeTab = ref("profile");

const profile = ref({
  name: authStore.user?.name || "Loading Name...",
  email: authStore.user?.email || "Loading Email...",
  phone: "+6281-2345-67890",
});

const address = ref({
  details: "Rumah cat hijau di seberang lapangan",
  street: "Jepara, RT18 RW05 JI.Pandawa",
  district: "Jepara",
  regency: "Jepara",
});

const password = ref({
  current: "",
  new: "",
  confirm: "",
});

const orders = ref([
  {
    id: 1,
    orderNumber: "#12345",
    date: "15 Jul 2024",
    items: 2,
    total: "Rp 25.000",
    status: "Selesai",
  },
  {
    id: 2,
    orderNumber: "#12344",
    date: "10 Jul 2024",
    items: 3,
    total: "Rp 50.000",
    status: "Gagal",
  },
  {
    id: 3,
    orderNumber: "#12343",
    date: "05 Jul 2024",
    items: 1,
    total: "Rp 15.000",
    status: "Selesai",
  },
]);

// Logika Penyimpanan
const saveProfileChanges = (newProfileData) => {
  console.log("Menyimpan perubahan profil. Data baru dari form:", newProfileData);
};
const saveAddressChanges = (newAddressData) => {
  console.log("Menyimpan perubahan alamat. Data baru dari form:", newAddressData);
};
const savePasswordChanges = (newPasswordData) => {
  console.log("Menyimpan perubahan kata sandi. Data baru dari form:", newPasswordData);
};
const handlePrintReceipt = (orderId) => {
  console.log(`Perintah cetak resi untuk pesanan ${orderId}`);
};
</script>
