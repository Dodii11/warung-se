import { defineStore } from "pinia";
import apiClient from "@/api/axios";

export const adminApi = defineStore("adminApi", {
  state: () => ({
    admins: [],
    loading: false,
  }),

  actions: {
    async fetchAdmins() {
      this.loading = true;
      try {
        const res = await apiClient.get("/admins");
        this.admins = res.data;
      } finally {
        this.loading = false;
      }
    },

    async createAdmin(payload) {
      try {
        const form = new FormData();
        form.append("nama_user", payload.nama_user);
        form.append("email_user", payload.email_user);
        form.append("password", payload.password);
        form.append("id_role", 2);
        form.append("status", "aktif");

        await apiClient.post("/admins", form);
        await this.fetchAdmins();
      } catch (err) {
        if (err.response?.status === 422) {
          throw err.response.data.errors;
        }
        throw err;
      }
    },

    async updateAdmin(id, payload) {
      const form = new FormData();
      form.append("nama_user", payload.nama_user);
      form.append("email_user", payload.email_user);
      form.append("status", payload.status);

      if (payload.password) {
        form.append("password", payload.password);
      }

      await apiClient.post(`/admins/${id}`, form);
      await this.fetchAdmins();
    },

    async deleteAdmin(id) {
      await apiClient.delete(`/admins/${id}`);
      this.admins = this.admins.filter((a) => a.id_user !== id);
    },
  },
});
