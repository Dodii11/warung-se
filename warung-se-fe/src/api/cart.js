import axios from "@/api/axios";

// Ambil cart user login
export const fetchCart = () => {
  return axios.get("/cart");
};

// Tambah ke cart
export const addToCart = (payload) => {
  return axios.post("/cart", payload);
};

export const updateCartQty = (id_menu, jumlah) => {
  return axios.put(`/cart/${id_menu}`, { jumlah });
};

// Hapus item cart (per menu)
export const deleteCartItem = (id_menu) => {
  return axios.delete(`/cart/${id_menu}`);
};

// Clear seluruh cart
export const clearCart = () => {
  return axios.delete("/cart");
};
