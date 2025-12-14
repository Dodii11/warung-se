import { defineStore } from "pinia";
import apiClient from "@/api/axios";

export const userApi = defineStore("user", {
  state: () => ({
    users: [],
    loading: false,
    error: null,
  }),

  actions: {
    async fetchUsers() {
      this.loading = true;
      this.error = null;
      try {
        // Ambil semua user customer beserta alamat
        const res = await apiClient.get("/users/customer");
        this.users = res.data.map(user => ({
          ...user,
          alamat: user.alamat ?? [], // pastikan ada array
        }));
      } catch (err) {
        this.error = err.response?.data?.message || "Gagal mengambil data user";
      } finally {
        this.loading = false;
      }
    },
  },
});
