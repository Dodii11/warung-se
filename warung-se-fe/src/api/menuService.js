import api from "@/api/axios";

export function getLatestMenus(limit = 5) {
  return api.get(`/menu?limit=${limit}`);
}
