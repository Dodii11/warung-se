import apiClient from "@/api/axios";

export const updateProfile = (payload) => {
  return apiClient.put("/account/me", payload);
};

export const updatePassword = (payload) => {
  return apiClient.put("/account/password", payload);
};

export const fetchCheckoutProfile = () => {
  return apiClient.get("/account/me/checkout");
};
