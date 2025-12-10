// src/stores/auth.js
import { defineStore } from "pinia";
import apiClient from "@/api/axios";

export const useAuth = defineStore("auth", {
  state: () => ({
    user: null,
    token: localStorage.getItem("token") || null,
    isLoggedIn: !!localStorage.getItem("token"),
    loading: false,
    initializing: true, // Tetap gunakan flag ini
    error: null,
  }),

  actions: {
    // Fungsi untuk menunggu inisialisasi selesai
    // Fungsi ini akan resolve Promise ketika initializing = false
    async waitForInitialization() {
      // Jika sudah selesai, langsung resolve
      if (!this.initializing) {
        return;
      }

      // Jika masih initializing, buat promise yang resolve ketika initializing menjadi false
      // Gunakan $subscribe untuk memonitor perubahan state secara spesifik
      return new Promise((resolve) => {
        const unsubscribe = this.$subscribe((mutation, state) => {
          if (!state.initializing) {
            unsubscribe(); // Hentikan watcher setelah kondisi terpenuhi
            resolve();
          }
        });
      });
    },

    async fetchUser() {
      if (!this.token) {
        this.user = null;
        this.isLoggedIn = false;
        this.initializing = false;
        return;
      }

      this.loading = true;
      this.initializing = true;
      try {
        const res = await apiClient.get("/account/me");
        this.user = res.data;
        this.isLoggedIn = true;
        console.log("User data loaded after refresh:", this.user);
      } catch (err) {
        console.error("Gagal mengambil data user setelah refresh:", err);
        this.logout(); // Ini akan mengatur ulang state
      } finally {
        this.loading = false;
        this.initializing = false;
      }
    },

    async login({ email_user, password }) {
      this.loading = true;
      this.error = null;

      try {
        const res = await apiClient.post("/login", {
          email_user,
          password,
        });

        const token = res.data.access_token;
        const user = res.data.user;

        localStorage.setItem("token", token);

        this.token = token;
        this.user = user;
        this.isLoggedIn = true;

        return { success: true };
      } catch (err) {
        this.error = err.response?.data?.message || "Login gagal";
        return { success: false, error: this.error };
      } finally {
        this.loading = false;
      }
    },

    async register({ nama_user, email_user, no_telp, password }) {
      this.loading = true;
      this.error = null;

      try {
        await apiClient.post("/register", {
          nama_user,
          email_user,
          no_telp,
          password,
        });

        return { success: true };
      } catch (err) {
        this.error = err.response?.data?.message || "Pendaftaran gagal";
        return { success: false, error: this.error };
      } finally {
        this.loading = false;
      }
    },

    async logout() {
      try {
        if (this.token) {
          await apiClient.post("/logout");
        }
      } catch (err) {
        console.error("Logout API gagal:", err);
      }

      localStorage.removeItem("token");
      this.user = null;
      this.token = null;
      this.isLoggedIn = false;
      this.initializing = false;
    },
  },
});
