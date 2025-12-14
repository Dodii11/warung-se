import { defineStore } from "pinia";
import { fetchStatistik } from "./statistikService";

export const useStatistikStore = defineStore("statistik", {
  state: () => ({
    loading: false,
    error: null,
    data: {
      total_user: 0,
      total_pesanan: 0,
      total_pendapatan: 0,
      total_driver: 0,
    },
  }),

  actions: {
    async loadStatistik() {
      this.loading = true;
      this.error = null;

      try {
        this.data = await fetchStatistik();
      } catch (err) {
        this.error = err;
        console.error("Gagal load statistik:", err);
      } finally {
        this.loading = false;
      }
    },
  },
});
