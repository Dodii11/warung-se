import axios from "@/api/axios";

// Checkout / buat pesanan
export const checkoutPesanan = (payload) => {
  return axios.post("/pesanan", payload);
};

// Ambil detail pesanan
export const fetchPesananDetail = (id) => {
  return axios.get(`/pesanan/${id}`);
};
