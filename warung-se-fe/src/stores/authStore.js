import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useAuthStore = defineStore('auth', () => {
  const user = ref(null)
  const isAuthenticated = ref(false)
  const isLoading = ref(false)
  const error = ref(null)

  const DUMMY_ADMIN = {
    email: 'admin@warungse.com',
    password: 'admin123',
    name: 'Admin Warung SE',
    role: 'admin',
  }

  const login = async (credentials) => {
    isLoading.value = true
    error.value = null
    try {
      await new Promise((resolve) => setTimeout(resolve, 800))
      if (
        credentials.email === DUMMY_ADMIN.email &&
        credentials.password === DUMMY_ADMIN.password
      ) {
        user.value = DUMMY_ADMIN
        isAuthenticated.value = true
        console.log('✅ Login sukses:', user.value)
        return { success: true, user: user.value }
      } else {
        throw new Error('Email atau kata sandi salah.')
      }
    } catch (err) {
      error.value = err.message
      console.error('Login gagal:', err)
      return { success: false, error: err.message }
    } finally {
      isLoading.value = false
    }
  }

  const register = async (data) => {
    isLoading.value = true
    error.value = null
    try {
      await new Promise((resolve) => setTimeout(resolve, 1000))
      // Simulasi register berhasil
      user.value = {
        name: data.name,
        email: data.email,
        phone: data.phone,
        role: 'user',
      }
      console.log('✅ Register sukses:', user.value)
      return { success: true }
    } catch (err) {
      error.value = err.message
      console.error('Register gagal:', err)
      return { success: false, error: err.message }
    } finally {
      isLoading.value = false
    }
  }

  const logout = () => {
    user.value = null
    isAuthenticated.value = false
  }

  return {
    user,
    isAuthenticated,
    isLoading,
    error,
    login,
    register,
    logout,
  }
})
