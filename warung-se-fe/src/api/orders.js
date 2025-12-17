// src/api/orders.js
import apiClient from "@/api/axios";

export const OrdersAPI = {
  // =====================
  // USER
  // =====================
  getUserOrders() {
    return apiClient.get("/user/pesanan").then(res => res.data);
  },

  // =====================
  // ADMIN
  // =====================
  getAdminOrders() {
    return apiClient.get("/admin/pesanan").then(res => res.data);
  },

  getOrder(id) {
    return apiClient.get(`/pesanan/${id}`).then(res => res.data);
  },

  updateStatus(id, status) {
    return apiClient.put(`/pesanan/${id}`, { status })
      .then(res => res.data);
  },

  assignDriver(id, id_driver) {
    return apiClient.put(`/pesanan/${id}/assign-driver`, {
      id_driver
    }).then(res => res.data);
  },

  getDrivers() {
    return apiClient.get("/driver").then(res => res.data);
  }
};
