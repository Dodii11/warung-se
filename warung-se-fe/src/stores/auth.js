/* eslint-disable no-unused-vars */
import { defineStore } from "pinia";
import apiClient from "@/api/axios";

export const useAuth = defineStore("auth", {
  state: () => ({
    user: null,
    token: localStorage.getItem("token"),
    isLoggedIn: false,
    loading: false,
    initializing: true,
    error: null,
  }),

  getters: {
    role: (state) => state.user?.role || null,
    isAdmin: (state) => state.user?.role === "admin",
    isSuperAdmin: (state) =>
      state.user?.role === "super admin" || state.user?.role === "superadmin",
  },

  actions: {
    // =========================
    // INIT (TANPA API CALL)
    // =========================
    async initializeAuth() {
      const token = localStorage.getItem("token");

      if (!token) {
        this.token = null;
        this.user = null;
        this.isLoggedIn = false;
        this.initializing = false;
        return;
      }

      // token ada, tapi JANGAN fetch user di sini
      this.token = token;
      this.isLoggedIn = true; // asumsi sementara
      this.initializing = false;
    },

    async waitForInitialization() {
      if (!this.initializing) return;

      return new Promise((resolve) => {
        const unsubscribe = this.$subscribe((_, state) => {
          if (!state.initializing) {
            unsubscribe();
            resolve();
          }
        });
      });
    },

    // =========================
    // LOAD USER (ON DEMAND)
    // =========================
    async ensureUserLoaded() {
      if (this.user || !this.token) return;

      this.loading = true;
      try {
        const res = await apiClient.get("/account/me");
        this.user = res.data;
        this.isLoggedIn = true;
      } catch (err) {
        this.clearAuth();
      } finally {
        this.loading = false;
      }
    },

    // =========================
    // AUTH HELPERS
    // =========================
    setAuth(token, user) {
      localStorage.setItem("token", token);
      this.token = token;
      this.user = user;
      this.isLoggedIn = true;
    },

    clearAuth() {
      localStorage.removeItem("token");
      this.token = null;
      this.user = null;
      this.isLoggedIn = false;
    },

    // =========================
    // LOGIN / REGISTER
    // =========================
    async login({ email_user, password }) {
      this.loading = true;
      this.error = null;

      try {
        const res = await apiClient.post("/login", {
          email_user,
          password,
        });

        this.setAuth(res.data.access_token, res.data.user);
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
        const res = await apiClient.post("/register", {
          nama_user,
          email_user,
          no_telp,
          password,
        });

        this.setAuth(res.data.access_token, res.data.user);
        return { success: true };
      } catch (err) {
        this.error = err.response?.data?.message || "Pendaftaran gagal";
        return { success: false, error: this.error };
      } finally {
        this.loading = false;
      }
    },

    // =========================
    // LOGOUT
    // =========================
    async logout() {
      try {
        if (this.token) {
          await apiClient.post("/logout");
        }
      } catch (err) {
        console.warn("Logout API gagal:", err);
      }

      this.clearAuth();
    },
  },
});
