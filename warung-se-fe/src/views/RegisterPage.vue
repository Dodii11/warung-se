<!--  eslint-disable vue/multi-word-component-names -->
<template>
  <div class="bg-bg min-h-screen flex justify-center items-center py-12 px-4">
    <div
      class="bg-white w-full max-w-5xl rounded-2xl shadow-lg grid md:grid-cols-2 overflow-hidden"
    >
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

          <!-- FORM RECAPTCHA -->
           <div id="recaptcha-container" class="form-group"></div>
           <div v-if="captchaError" class="alert alert-error">{{captchaError}}</div>

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

//TAMBAH ONMOUNTED
import { reactive, ref, onMounted} from "vue";

import { useRouter } from "vue-router";
import BaseInput from "@/components/base/BaseInput.vue";
import BaseButton from "@/components/base/BaseButton.vue";
import { useAuth } from "@/stores/auth";

const router = useRouter();
const auth = useAuth();

/* Form tetap sesuai file asli */
const formData = reactive({
  name: "",
  email: "",
  phone: "",
  password: "",
  confirmPassword: "",
});

// TAMBAHAN
const error = ref('');
const successMessage = ref('');
const captchaError = ref('');
const widgetId = ref(null);
// SAMPE SINI

/* Loading state */
const isLoading = ref(false);
const isGoogleLoading = ref(false);

// SKRIP RECAPTCHA V2
const loadRecaptcha = () => {

  // Check if script is already loaded
  if (window.grecaptcha && window.grecaptcha.render) {

    // Wait slightly to ensure DOM is ready
    setTimeout(renderWidget, 100)
    return
  }

  // Define callback for when script loads
  window.onRecaptchaLoad = () => {
    setTimeout(renderWidget, 100)
  }

  if (!document.getElementById('recaptcha-script')) {
    const script = document.createElement('script')
    script.id = 'recaptcha-script'
    script.src = 'https://www.google.com/recaptcha/api.js?onload=onRecaptchaLoad&render=explicit'
    script.async = true
    script.defer = true
    document.head.appendChild(script)
  }
}

const renderWidget = () => {
  const container = document.getElementById('recaptcha-container')
  
  // If widget already rendered or container missing, stop
  if (widgetId.value !== null || !container) {
    if (!container) {
      console.warn('reCAPTCHA container not found, retrying...')
      setTimeout(renderWidget, 500) // Retry if container missing
    }
    return
  }
  
  try {
    widgetId.value = window.grecaptcha.render('recaptcha-container', {
      'sitekey': import.meta.env.VITE_RECAPTCHA_SITE_KEY,
      'callback': () => {
        captchaError.value = ''
      },
      'expired-callback': () => {
        captchaError.value = 'CAPTCHA expired. Please check the box again.'
      }
    })
  } catch (e) {
    console.error('Failed to render reCAPTCHA', e)
  }
}

onMounted(() => {

  // Ensure DOM is fully mounted before loading
  setTimeout(loadRecaptcha, 100)
})
// SAMPE SINI

/* Integrasi API */
const handleRegister = async () => {
  try {
    isLoading.value = true;

    if (formData.password !== formData.confirmPassword) {
      alert("Password tidak sama.");
      return;
    }

    const payload = {
      nama_user: formData.name,
      email_user: formData.email,
      no_telp: formData.phone,
      password: formData.password,
    };

    const res = await auth.register(payload);

  // SKRIP RECAPTCHA V2
  error.value = ''
  captchaError.value = ''
  successMessage.value = ''
  
  if (formData.password !== formData.confirmPassword) {
    error.value = 'Passwords do not match'
    return
  }

  const recaptchaToken = window.grecaptcha.getResponse(widgetId.value)
  if (!recaptchaToken) {
    captchaError.value = 'Please complete the CAPTCHA'
    return
  }
  // SAMPE SINI

    if (!res.success) {
      return;
    }

    router.push("/login");
  } finally {
    isLoading.value = false;
  }
};

/* Dummy Google tetap */
const handleGoogleRegister = async () => {
  isGoogleLoading.value = true;
  await new Promise((resolve) => setTimeout(resolve, 1500));
  isGoogleLoading.value = false;
};
</script>
