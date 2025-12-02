import { defineStore } from 'pinia'
import { ref, nextTick } from 'vue'

export const useAuthStore = defineStore('auth', () => {
  const user = ref(JSON.parse(localStorage.getItem('user')) || null)
  const isAuthenticated = ref(!!user.value)
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
        localStorage.setItem('user', JSON.stringify(user.value))
        return { success: true, user: user.value }
      } else {
        throw new Error('Email atau kata sandi salah.')
      }
    } catch (err) {
      error.value = err.message
      return { success: false, error: err.message }
    } finally {
      isLoading.value = false;
    }
  }

  const register = async (data) => {
    isLoading.value = true
    error.value = null
    try {
      await new Promise((resolve) => setTimeout(resolve, 1000))
      user.value = {
        name: data.name,
        email: data.email,
        phone: data.phone,
        role: 'user',
      }
      localStorage.setItem('user', JSON.stringify(user.value))
      isAuthenticated.value = true
      return { success: true }
    } catch (err) {
      error.value = err.message
      return { success: false, error: err.message }
    } finally {
      isLoading.value = false
    }
  };

  // -----------------------------------------
  // 🟩 LOGOUT FIX
  // -----------------------------------------
  const logout = async () => {
    user.value = null
    isAuthenticated.value = false
    localStorage.removeItem('user')
    await nextTick()
  }

  return { user, isAuthenticated, isLoading, error, login, register, logout }
})
