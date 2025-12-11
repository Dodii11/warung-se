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
      'Content-Type': 'multipart/form-data'
    }
  }),

  // UPDATE EXISTING MENU (Super Admin Only)
  update: (id, data) => apiClient.post(`/menu/${id}`, data, { // Gunakan PUT
    headers: {
      'Content-Type': 'multipart/form-data'
    }
  }),

  // DELETE MENU (Super Admin Only)
  delete: (id) => apiClient.delete(`/menu/${id}`),
};
