<!--  eslint-disable vue/multi-word-component-names -->
<template>
  <div class="min-h-screen bg-bg flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden max-w-5xl w-full grid grid-cols-1 lg:grid-cols-2">

      <!-- Form Section -->
      <div class="p-8 md:p-12 flex flex-col justify-center">

        <div class="mb-8">
          <h1 class="heading-1 mb-2">Login</h1>
          <p class="text-gray-600 text-sm">Selamat datang, silakan masukkan detail Anda.</p>
        </div>

        <form @submit.prevent="handleLogin" class="space-y-5">

          <!-- Email/Username Input -->
          <BaseInput
            v-model="formData.username"
            label="Nama Pengguna atau Email"
            placeholder="Masukkan nama pengguna atau email"
          />

          <!-- Password -->
          <BaseInput
            v-model="formData.password"
            label="Kata Sandi"
            type="password"
            placeholder="Masukkan kata sandi"
          />

          <!-- Remember -->
          <div class="flex items-center justify-between text-sm">
            <label class="flex items-center cursor-pointer">
              <input
                v-model="formData.remember"
                type="checkbox"
                class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary cursor-pointer"
              />
              <span class="ml-2 text-gray-900">Ingat saya</span>
            </label>
            <a href="#" class="text-primary hover:underline">Lupa kata sandi?</a>
          </div>

          <!-- Login Button -->
          <BaseButton
            type="submit"
            :loading="isLoginLoading"
            :disabled="isGoogleLoading"
            class="w-full"
          >
            Login
          </BaseButton>

          <!-- Divider -->
          <div class="flex items-center gap-2 my-4">
            <div class="flex-1 h-px bg-gray-300"></div>
            <span class="text-gray-400 text-sm">atau</span>
            <div class="flex-1 h-px bg-gray-300"></div>
          </div>

          <!-- Google Button -->
          <BaseButton
            class="w-full"
            variant="google"
            :loading="isGoogleLoading"
            :disabled="isLoginLoading"
            @click="redirectToGoogle"
          >
            <template #icon-left>
              <img
                src="https://cdn.jsdelivr.net/npm/simple-icons@v9/icons/google.svg"
                alt="Google"
                class="w-5 h-5 filter invert"
              />
            </template>
            Login dengan Google
          </BaseButton>

        </form>

        <!-- Register Link -->
        <p class="text-center text-sm text-gray-600 mt-6">
          Belum punya akun?
          <RouterLink to="/register" class="text-primary font-medium hover:underline">
            Daftar
          </RouterLink>
        </p>

      </div>

      <!-- Image Section -->
      <div class="hidden lg:block relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-black/40 to-black/60"></div>
        <img
          src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?q=80&w=800"
          alt="Warung SE"
          class="w-full h-full object-cover"
        />
        <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
          <h2 class="text-2xl font-bold mb-2">Warung SE</h2>
          <p class="text-sm opacity-90">
            Temukan kenikmatan ayam terbaik, praktis dipesan, siap memanjakan lidahmu!
          </p>
        </div>
      </div>

    </div>
  </div>
</template>

<script setup>
import { reactive, ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import { useAuthStore } from "@/stores/authStore";
import BaseInput from "@/components/base/BaseInput.vue";
import BaseButton from "@/components/base/BaseButton.vue";
import axios from "axios";

const router = useRouter();
const auth = useAuthStore();

const formData = reactive({
  username: "",
  password: "",
});

const isLoginLoading = ref(false);
const isGoogleLoading = ref(false);

// Normal login
const handleLogin = async () => {
  isLoginLoading.value = true;
  try {
    const { data } = await axios.post("http://127.0.0.1:8000/api/login", {
      email: formData.username,
      password: formData.password
    });

    // simpan token dan role
    localStorage.setItem("token", data.data.token);
    localStorage.setItem("role", data.data.role);

    // redirect sesuai role
    if (data.data.role === "user") {
      router.push("/");
    } else if (data.data.role === "admin") {
      router.push("/admin/dashboard");
    } else if (data.data.role === "superadmin") {
      router.push("/admin/dashboard");
    }
  } catch (err) {
    alert(err.response?.data?.message || "Login gagal");
  } finally {
    isLoginLoading.value = false;
  }
};


// Google login redirect
const redirectToGoogle = () => {
  isGoogleLoading.value = true;
  window.location.href = "http://127.0.0.1:8000/auth/google/redirect";
};

// Auto redirect kalau sudah login

</script>

