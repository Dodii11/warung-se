/* eslint-disable no-unused-vars */
// src/stores/auth.js
import { defineStore } from "pinia";
import apiClient from "@/api/axios";

export const useAuth = defineStore("auth", {
  state: () => ({
    user: null,
    token: localStorage.getItem("token") || null,
    isLoggedIn: !!localStorage.getItem("token"),
    loading: false,
    error: null,
  }),

  actions: {
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
        await apiClient.post("/logout");
      } catch (err) {
        /* abaikan error */
      }

      localStorage.removeItem("token");
      this.user = null;
      this.token = null;
      this.isLoggedIn = false;
    },
  },
});
