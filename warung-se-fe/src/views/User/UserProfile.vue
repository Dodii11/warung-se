<template>
  <div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Akun Saya</h1>

    <!-- Tab Navigation -->
    <div class="flex border-b mb-6">
      <router-link 
        to="/user/profile"
        :class="[
          'px-4 py-2 font-medium',
          $route.path === '/user/profile' ? 'border-b-2 border-red-500 text-red-600' : 'text-gray-600'
        ]"
      >
        Profil
      </router-link>
      <router-link 
        to="/user/pesanan"
        :class="[
          'px-4 py-2 font-medium',
          $route.path === '/user/pesanan' ? 'border-b-2 border-red-500 text-red-600' : 'text-gray-600'
        ]"
      >
        Pesanan
      </router-link>
    </div>

    <!-- Dua Kolom Atas -->
    <div class="flex flex-col lg:flex-row gap-8 justify-center">
      <!-- Informasi Pribadi -->
      <div class="bg-white rounded-xl shadow p-6 w-full lg:w-[450px]">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Informasi Pribadi</h2>
        <div class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
            <input 
              v-model="user.name" 
              type="text" 
              class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
            />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input 
              v-model="user.email" 
              type="email" 
              class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
            />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
            <input 
              v-model="user.phone" 
              type="tel" 
              class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
            />
          </div>
        </div>
        <div class="mt-6">
          <UserSaveButton @click="saveProfile" />
        </div>
      </div>

      <!-- Alamat Rumah -->
      <div class="bg-white rounded-xl shadow p-6 w-full lg:w-[450px]">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Alamat Rumah</h2>
        <div class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Jalan</label>
            <input 
              v-model="user.address.street" 
              type="text" 
              class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
            />
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Kecamatan/Kota</label>
              <input 
                v-model="user.address.district" 
                type="text" 
                class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
              />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Kabupaten</label>
              <input 
                v-model="user.address.city" 
                type="text" 
                class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
              />
            </div>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Provinsi</label>
              <input 
                v-model="user.address.province" 
                type="text" 
                class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
              />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Kode Pos</label>
              <input 
                v-model="user.address.postalCode" 
                type="text" 
                class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
              />
            </div>
          </div>
        </div>
        <div class="mt-6">
          <UserSaveButton @click="saveAddress" />
        </div>
      </div>
    </div>

    <!-- Ubah Kata Sandi — DI TENGAH, UKURAN SAMA -->
    <div class="flex justify-center mt-8">
      <div class="bg-white rounded-xl shadow p-6 w-full lg:w-[450px]">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Ubah Kata Sandi</h2>
        <div class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi Saat Ini</label>
            <input 
              v-model="password.current" 
              type="password" 
              class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
            />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi Baru</label>
            <input 
              v-model="password.new" 
              type="password" 
              class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
            />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Kata Sandi Baru</label>
            <input 
              v-model="password.confirm" 
              type="password" 
              class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
            />
          </div>
        </div>
        <div class="mt-6 flex flex-wrap gap-4">
          <UserSaveButton @click="savePassword" />
          <UserSaveButton 
            label="Simpan Semua Perubahan" 
            variant="secondary"
            @click="saveAllChanges"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import UserSaveButton from "@/components/user/UserSaveButton.vue";

const user = ref({
  name: "Sasha",
  email: "Sasha@gmail.com",
  phone: "+6281234567890",
  address: {
    street: "Surakarta, RT18 RW05 Jl. Antariksa No.7",
    district: "Jebres",
    city: "Surakarta",
    province: "Jawa Tengah",
    postalCode: "12345"
  }
});

const password = ref({
  current: "",
  new: "",
  confirm: ""
});

const saveProfile = () => alert("Profil disimpan!");
const saveAddress = () => alert("Alamat disimpan!");
const savePassword = () => alert("Kata sandi diubah!");
const saveAllChanges = () => alert("Semua perubahan disimpan!");
</script>