import apiClient from "./axios";

export const fetchStatistik = async () => {
  const res = await apiClient.get("/statistik");
  return res.data;
};
