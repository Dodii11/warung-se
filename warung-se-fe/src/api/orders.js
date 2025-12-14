import apiClient from "@/api/axios";

export const OrdersAPI = {
  // Ambil daftar pesanan
  getOrders() {
    return apiClient.get("/pesanan").then(res => res.data);
  },

  // Ambil detail pesanan (opsional)
  getOrder(id) {
    return apiClient.get(`/pesanan/${id}`).then(res => res.data);
  },

  // Update status pesanan
  updateStatus(id, status) {
    return apiClient.put(`/pesanan/${id}`, { status })
      .then(res => res.data);
  },

  // Assign driver (hanya jika status Dikirim)
  assignDriver(id, driverId) {
    return apiClient.put(`/pesanan/${id}/assign-driver`, { id_driver: driverId })
      .then(res => res.data);
  },

  // Ambil daftar driver
  getDrivers() {
    return apiClient.get("/driver").then(res => res.data);
  }

};

export const getPesananTerbaru = () =>
  apiClient.get("/pesanan-terbaru");

export const getStatusOptions = () =>
  apiClient.get("/pesanan/status-options");
