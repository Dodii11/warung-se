import apiClient from "@/api/axios";

export const getAlamatList = () => {
  return apiClient.get("/alamat");
};

export const createAlamat = (payload) => {
  return apiClient.post("/alamat", payload);
};

export const updateAlamat = (id, payload) => {
  return apiClient.put(`/alamat/${id}`, payload);
};

export const deleteAlamat = (id) => {
  return apiClient.delete(`/alamat/${id}`);
};
