// src/api/menu.js
import apiClient from "@/api/axios";

export const menuApi = {
  // GET ALL MENUS
  getAll: () => apiClient.get("/menu"),

  // GET SINGLE MENU BY ID
  getById: (id) => apiClient.get(`/menu/${id}`),

  // CREATE NEW MENU (Super Admin Only)
  create: (data) => apiClient.post("/menu", data, {
    headers: {
      'Content-Type': 'multipart/form-data' // Penting!
    }
  }),

  // UPDATE EXISTING MENU (Super Admin Only)
  update: (id, data) => apiClient.put(`/menu/${id}`, data, { // Gunakan PUT
    headers: {
      'Content-Type': 'multipart/form-data' // Penting!
    }
  }),

  // DELETE MENU (Super Admin Only)
  delete: (id) => apiClient.delete(`/menu/${id}`),
};
