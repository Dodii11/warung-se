/* eslint-disable no-unused-vars */
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
    // 🔹 TAMBAHKAN INI
    setToken(token, user = null) {
      localStorage.setItem("token", token);
      this.token = token;
      this.isLoggedIn = true;

      if (user) {
        this.user = user;
      }
    },

     async fetchUser() {
        try {
          const res = await apiClient.get("/me");
          this.user = res.data;
        } catch (e) {
          this.logout();
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

        // pakai helper
        this.setToken(token, user);

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

        const token = res.data.access_token;
        const user = res.data.user;

        // 🔥 AUTO LOGIN
        this.setToken(token, user);

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
