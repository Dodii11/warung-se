import { defineStore } from 'pinia'
import { ref, nextTick } from 'vue'
import axios from 'axios' // pastikan kamu punya file ini

export const useAuthStore = defineStore('auth', () => {
  const user = ref(JSON.parse(localStorage.getItem('user')) || null)
  const token = ref(localStorage.getItem('token') || null)
  const isAuthenticated = ref(!!token.value)
  const isLoading = ref(false)
  const error = ref(null)

  // ----------------------------
  // LOGIN
  // ----------------------------
  const login = async (credentials) => {
    isLoading.value = true
    error.value = null

    try {
      const res = await axios.post('/login', {
        email: credentials.email,
        password: credentials.password,
      })

      token.value = res.data.token
      user.value = res.data.user

      localStorage.setItem('token', token.value)
      localStorage.setItem('user', JSON.stringify(user.value))

      isAuthenticated.value = true

      return { success: true, user: user.value }
    } catch (err) {
      error.value = err.response?.data?.message || 'Login gagal'
      return { success: false, error: error.value }
    } finally {
      isLoading.value = false
    }
  }

  // ----------------------------
  // REGISTER
  // ----------------------------
  const register = async (data) => {
    isLoading.value = true
    error.value = null

    try {
      const res = await axios.post('/register', data)

      token.value = res.data.token
      user.value = res.data.user

      localStorage.setItem('token', token.value)
      localStorage.setItem('user', JSON.stringify(user.value))

      isAuthenticated.value = true

      return { success: true }
    } catch (err) {
      error.value = err.response?.data?.message || 'Registrasi gagal'
      return { success: false, error: error.value }
    } finally {
      isLoading.value = false
    }
  }

  // ----------------------------
  // LOGOUT
  // ----------------------------
  const logout = async () => {
    try {
      await axios.post('/logout')
    } catch (_) {}

    token.value = null
    user.value = null
    isAuthenticated.value = false

    localStorage.removeItem('token')
    localStorage.removeItem('user')

    await nextTick()
  }

  // ----------------------------
  // FETCH USER (optional)
  // ----------------------------
  const fetchUser = async () => {
    if (!token.value) return

    try {
      const res = await axios.get('/me')
      user.value = res.data
      localStorage.setItem('user', JSON.stringify(user.value))
    } catch {
      logout()
    }
  }

  return {
    user,
    token,
    isAuthenticated,
    isLoading,
    error,
    login,
    register,
    logout,
    fetchUser,
  }
})
