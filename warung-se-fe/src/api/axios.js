// src/api/axios.js
import axios from "axios";

const apiClient = axios.create({
  baseURL: import.meta.env.VITE_API_BASE_URL + "/api",
  // Jangan sertakan "Content-Type" di sini secara default
  // karena FormData akan mengaturnya sendiri
  headers: {
    Accept: "application/json",
  },
});

// Attach token sebelum request
apiClient.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem("token");
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    // Biarkan FormData mengatur Content-Type untuk request dengan file
    // Jika config.data adalah FormData, biarkan browser menetapkan boundary
    if (!(config.data instanceof FormData)) {
      // Hanya set Content-Type ke JSON jika bukan FormData
      config.headers["Content-Type"] = "application/json";
    }
    // Jika config.data adalah FormData, browser akan otomatis menetapkan
    // Content-Type ke multipart/form-data; boundary=....
    return config;
  },
  (error) => {
    return Promise.reject(error);
  }
);

// Jika token expired → auto logout
apiClient.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response?.status === 401) {
      localStorage.removeItem("token");
      window.location.href = "/login";
    }
    return Promise.reject(error);
  }
);

export default apiClient;
