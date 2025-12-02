<!--  eslint-disable vue/multi-word-component-names -->
<template>
  <div class="bg-bg min-h-screen flex justify-center items-center py-12 px-4">
    <div class="bg-white w-full max-w-5xl rounded-2xl shadow-lg grid md:grid-cols-2 overflow-hidden">
      <!-- Left Form Section -->
      <div class="p-8 md:p-12 flex flex-col justify-center">
        <h2 class="heading-1 mb-2">Buat Akun</h2>
        <p class="text-sm text-gray-600 mb-8">
          Bergabunglah dengan kami dan mulai nikmati kemudahan memesan makanan favorit Anda.
        </p>

        <!-- Form -->
        <form @submit.prevent="handleRegister" class="space-y-4">
          <BaseInput label="Nama" v-model="formData.name" placeholder="Nama lengkap" />
          <BaseInput label="Email" type="email" v-model="formData.email" placeholder="Email" />
          <BaseInput label="Nomor Telepon" v-model="formData.phone" placeholder="Nomor Telepon" />
          <BaseInput
            label="Kata Sandi"
            type="password"
            v-model="formData.password"
            placeholder="Kata sandi"
          />
          <BaseInput
            label="Konfirmasi Kata Sandi"
            type="password"
            v-model="formData.confirmPassword"
            placeholder="Konfirmasi kata sandi"
          />

          <BaseButton
            variant="primary"
            :loading="isLoading"
            :disabled="isGoogleLoading"
            class="w-full"
          >
            Daftar
          </BaseButton>

          <div class="flex items-center gap-2 my-4">
            <div class="flex-1 h-px bg-gray-300"></div>
            <span class="text-gray-400 text-sm">atau</span>
            <div class="flex-1 h-px bg-gray-300"></div>
          </div>

          <BaseButton
            type="button"
            variant="google"
            class="w-full"
            @click="handleGoogleRegister"
            :loading="isGoogleLoading"
            :disabled="isLoading"
          >
            <template #icon-left>
              <img
                src="https://cdn.jsdelivr.net/npm/simple-icons@v9/icons/google.svg"
                alt="Google"
                class="w-5 h-5 filter invert"
              />
            </template>
            Daftar dengan Google
          </BaseButton>
        </form>

        <p class="text-center text-sm text-gray-600 mt-6">
          Sudah punya akun?
          <RouterLink to="/login" class="text-primary font-medium hover:underline">
            Login
          </RouterLink>
        </p>
      </div>

      <!-- Right Image Section -->
      <div class="hidden md:block relative">
        <img
          src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?q=80&w=800"
          alt="Warung SE"
          class="w-full h-full object-cover"
        />
        <div class="absolute inset-0 bg-black/30 flex flex-col justify-end p-8 text-white">
          <h3 class="text-xl font-semibold">Warung SE</h3>
          <p class="text-sm">
            Temukan kenikmatan ayam terbaik, praktis dipesan, siap memanjakan lidahmu!
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { reactive, ref } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
import BaseInput from "@/components/base/BaseInput.vue";
import BaseButton from "@/components/base/BaseButton.vue";


const router = useRouter();

const formData = reactive({
  name: "",
  email: "",
  phone: "",
  password: "",
  confirmPassword: "",
});

const isLoading = ref(false);

const handleRegister = async () => {
  if (formData.password !== formData.confirmPassword) {
    alert("Kata sandi tidak sama!");
    return;
  }

  isLoading.value = true;

  try {
    await axios.post("http://127.0.0.1:8000/api/register/user", {
      email_user: formData.email,
      nama_user: formData.name,
      no_telp: formData.phone,
      password: formData.password,
    });

    alert("Register berhasil!");
    router.push("/login");

  } catch (error) {
    console.log(error);
    alert(error.response?.data?.message || "Terjadi kesalahan");
  }

  isLoading.value = false;
};
</script>

