<template>
  <div class="space-y-10">
    <!-- Section 1: Informasi Pribadi & Alamat -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

      <!-- Kolom Kiri: Informasi Pribadi -->
      <UserAppCard>
        <div class="flex items-center gap-3 mb-6">
          <User class="w-6 h-6 text-red-600" />
          <h2 class="text-xl font-bold text-gray-800">Informasi Pribadi</h2>
        </div>

        <div class="space-y-5">
          <!-- Menggunakan localProfile untuk menghindari mutasi langsung pada prop -->
          <UserAppInput label="Nama Lengkap" placeholder="Edi Geyming" v-model="localProfile.name" />
          <UserAppInput label="Email" placeholder="edi@example.com" v-model="localProfile.email" type="email" />
          <UserAppInput label="Nomor Telepon" placeholder="+62..." v-model="localProfile.phone" type="tel" />
        </div>

        <div class="mt-8">
          <!-- Mengirimkan data lokal saat disimpan -->
          <UserAppButton class="w-full" @click="emitSaveProfile">
            Simpan Profil
          </UserAppButton>
        </div>
      </UserAppCard>

      <!-- Kolom Kanan: Alamat Rumah -->
      <UserAppCard>
        <div class="flex items-center gap-3 mb-6">
          <MapPin class="w-6 h-6 text-red-600" />
          <h2 class="text-xl font-bold text-gray-800">Alamat Pengiriman Default</h2>
        </div>

        <div class="space-y-5">
          <!-- Menggunakan localAddress -->
           <UserAppInput label="Detail Lokasi / Ciri-ciri Alamat" placeholder="" v-model="localAddress.details" />
          <UserAppInput label="Alamat Jalan" placeholder="Jl. Pandawa RT18 RW05" v-model="localAddress.street" />
          <div class="grid grid-cols-2 gap-4">
            <UserAppInput label="Kecamatan/Kota" placeholder="Jepara" v-model="localAddress.district" />
            <UserAppInput label="Kabupaten" placeholder="Jepara" v-model="localAddress.regency" />
          </div>
          <div class="grid grid-cols-2 gap-4">
          </div>
        </div>

        <div class="mt-8">
          <UserAppButton class="w-full" @click="emitSaveAddress" variant="secondary">
            Simpan Alamat
          </UserAppButton>
        </div>
      </UserAppCard>
    </div>

    <!-- Section 2: Ubah Kata Sandi -->
    <div class="max-w-xl">
      <UserAppCard>
        <div class="flex items-center gap-3 mb-6">
          <Lock class="w-6 h-6 text-red-600" />
          <h2 class="text-xl font-bold text-gray-800">Ubah Kata Sandi</h2>
        </div>

        <div class="space-y-5">
          <!-- Menggunakan localPassword -->
          <UserAppInput label="Kata Sandi Saat Ini" type="password" placeholder="********" v-model="localPassword.current" />
          <UserAppInput label="Kata Sandi Baru" type="password" placeholder="********" v-model="localPassword.new" />
          <UserAppInput label="Konfirmasi Kata Sandi Baru" type="password" placeholder="********" v-model="localPassword.confirm" />
        </div>

        <div class="mt-8">
          <UserAppButton class="w-full" @click="emitSavePassword" variant="outline-gray">
            Ubah Kata Sandi
          </UserAppButton>
        </div>
      </UserAppCard>
    </div>
  </div>
</template>

<script setup>
import { reactive, watch } from 'vue';
import { User, MapPin, Lock } from "lucide-vue-next";
import UserAppCard from '@/components/baseUser/UserAppCard.vue';
import UserAppInput from '@/components/baseUser/UserAppInput.vue';
import UserAppButton from '@/components/baseUser/UserAppButton.vue';

const props = defineProps({
  profileData: { type: Object, required: true },
  addressData: { type: Object, required: true },
  passwordData: { type: Object, required: true },
});

const emit = defineEmits(['saveProfile', 'saveAddress', 'savePassword']);

// Ini adalah cara aman untuk melakukan mutasi data lokal tanpa melanggar aturan Vue.
const localProfile = reactive({ ...props.profileData });
const localAddress = reactive({ ...props.addressData });
const localPassword = reactive({ ...props.passwordData });

// Ini memastikan jika parent component (UserProfil) mengubah props, form juga terupdate.
watch(() => props.profileData, (newVal) => {
    Object.assign(localProfile, newVal);
}, { deep: true });

watch(() => props.addressData, (newVal) => {
    Object.assign(localAddress, newVal);
}, { deep: true });

watch(() => props.passwordData, (newVal) => {
    Object.assign(localPassword, newVal);
}, { deep: true });


// Fungsi emit yang mengirimkan data lokal kembali ke parent (UserProfil.vue)
const emitSaveProfile = () => {
    emit('saveProfile', localProfile);
};
const emitSaveAddress = () => {
    emit('saveAddress', localAddress);
};
const emitSavePassword = () => {
    emit('savePassword', localPassword);
};


</script>
