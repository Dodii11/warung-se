// src/api/axios.js
import axios from 'axios';

// Buat instance axios
const apiClient = axios.create({
  baseURL: import.meta.env.VITE_API_BASE_URL,
  withCredentials: true, // PENTING! Agar cookie (untuk login) bisa dikirim
});

// (Opsional tapi disarankan)
// Panggil endpoint ini sebelum request login/register
// untuk mendapatkan cookie CSRF dari Sanctum
export const getCsrfCookie = () => apiClient.get('/sanctum/csrf-cookie');

export default apiClient;
