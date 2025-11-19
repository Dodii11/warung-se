import { defineStore } from "pinia";
import { ref, nextTick } from "vue";
import axios from "axios";

axios.defaults.baseURL = "http://127.0.0.1:8000/api";
axios.defaults.withCredentials = true; // penting untuk sanctum

export const useAuthStore = defineStore("auth", () => {
  const user = ref(JSON.parse(localStorage.getItem("user")) || null);
  const token = ref(localStorage.getItem("token") || null);
  const isAuthenticated = ref(!!token.value);
  const isLoading = ref(false);
  const error = ref(null);

  const setToken = (newToken) => {
    token.value = newToken;
    isAuthenticated.value = true;
    localStorage.setItem("token", newToken);
    axios.defaults.headers.common["Authorization"] = `Bearer ${newToken}`;
  };

  const login = async (credentials) => {
    isLoading.value = true;
    error.value = null;
    try {
      const res = await axios.post("/login", credentials);
      setToken(res.data.token);
      user.value = res.data.user;
      localStorage.setItem("user", JSON.stringify(user.value));
      return { success: true };
    } catch (err) {
      error.value = err.response?.data?.message || "Login gagal";
      return { success: false, error: error.value };
    } finally {
      isLoading.value = false;
    }
  };

  const fetchUser = async () => {
    if (!token.value) return;
    try {
      const res = await axios.get("/me");
      user.value = res.data;
      localStorage.setItem("user", JSON.stringify(user.value));
    } catch {
      logout();
    }
  };

  const logout = async () => {
    try {
      await axios.post("/logout");
    } catch (_) {}
    token.value = null;
    user.value = null;
    isAuthenticated.value = false;
    localStorage.removeItem("token");
    localStorage.removeItem("user");
    await nextTick();
  };

  return {
    user,
    token,
    isAuthenticated,
    isLoading,
    error,
    login,
    fetchUser,
    logout,
    setToken,
  };
});
