import { defineStore } from "pinia";
import { ref, nextTick } from "vue";

export const useAuthStore = defineStore("auth", () => {
  const user = ref(JSON.parse(localStorage.getItem("user")) || null);
  const isAuthenticated = ref(!!user.value);
  const isLoading = ref(false);
  const error = ref(null);

  // 🟩 DUMMY ADMIN
  const DUMMY_ADMIN = {
    email: "admin@warungse.com",
    password: "admin123",
    name: "Admin Warung SE",
    role: "admin",
  };

  // 🟩 DUMMY USER
  const DUMMY_USER = {
    email: "user@warungse.com",
    password: "user123",
    name: "User Dummy",
    role: "user",
  };

  // -----------------------------------------
  // 🟩 LOGIN FIX (dummy tetap, hanya diperbaiki)
  // -----------------------------------------
  const login = async (credentials) => {
    isLoading.value = true;
    error.value = null;

    try {
      await new Promise((resolve) => setTimeout(resolve, 300));

      let foundUser = null;

      if (
        credentials.email === DUMMY_ADMIN.email &&
        credentials.password === DUMMY_ADMIN.password
      ) {
        foundUser = DUMMY_ADMIN;
      }

      if (
        credentials.email === DUMMY_USER.email &&
        credentials.password === DUMMY_USER.password
      ) {
        foundUser = DUMMY_USER;
      }

      if (!foundUser) {
        throw new Error("Email atau kata sandi salah.");
      }

      user.value = foundUser;
      isAuthenticated.value = true;

      localStorage.setItem("user", JSON.stringify(foundUser));

      return { success: true, user: foundUser };
    } catch (err) {
      error.value = err.message;
      return { success: false, error: err.message };
    } finally {
      isLoading.value = false;
    }
  };

  // -----------------------------------------
  // 🟩 REGISTER (tetap original)
  // -----------------------------------------
  const register = async (data) => {
    isLoading.value = true;
    error.value = null;

    try {
      await new Promise((resolve) => setTimeout(resolve, 1000));

      user.value = {
        name: data.name,
        email: data.email,
        phone: data.phone,
        role: "user",
      };

      localStorage.setItem("user", JSON.stringify(user.value));
      isAuthenticated.value = true;

      return { success: true };
    } catch (err) {
      error.value = err.message;
      return { success: false, error: err.message };
    } finally {
      isLoading.value = false;
    }
  };

  // -----------------------------------------
  // 🟩 LOGOUT FIX
  // -----------------------------------------
  const logout = async () => {
    user.value = null;
    isAuthenticated.value = false;
    localStorage.removeItem("user");
    await nextTick();
  };

  return {
    user,
    isAuthenticated,
    isLoading,
    error,
    login,
    register,
    logout,
  };
});
