import { defineStore } from 'pinia'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    // DATA DUMMY
    isLoggedIn: true,
    user: {
      id: 1,
      name: "Admin Dummy",
      email: "admin@dummy.com",
      role: "admin" // <-- GANTI INI JADI "user" UNTUK TES
    }

  }),
  actions: {
  }
})
