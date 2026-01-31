import axios from "axios";

const api = axios.create({
  baseURL: import.meta.env.VITE_API_BASE_URL + "/api",
  headers: {
    Accept: "application/json",
  },
});

// Interceptor token + FormData
api.interceptors.request.use((config) => {
  const token = localStorage.getItem("token");
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }

  // JANGAN set Content-Type kalau FormData
  if (!(config.data instanceof FormData)) {
    config.headers["Content-Type"] = "application/json";
  }

  return config;
});

export default {
  getAll() {
    return api.get("/driver");
  },

  create(data) {
    return api.post("/driver", data);
  },

  update(id, data) {
    return api.post(`/driver/${id}?_method=PUT`, data);
  },

  remove(id) {
    return api.delete(`/driver/${id}`);
  },
};
