import axios from "@/api/axios";

export const cartApi = {
  getAll: () => apiClient.get("/cart"),
  add: (data) => apiClient.post("/cart", data),
  delete: (id) => apiClient.delete(`/cart/${id}`),
  clear: () => apiClient.delete("/cart/clear"),
};

// Ambil cart user login
export const fetchCart = () => {
  return axios.get("/cart");
};

// Tambah ke cart
export const addToCart = (payload) => {
  return axios.post("/cart", payload);
};

// Hapus item cart (per menu)
export const deleteCartItem = (id_menu) => {
  return axios.delete(`/cart/${id_menu}`);
};

// Clear seluruh cart
export const clearCart = () => {
  return axios.delete("/cart");
};
