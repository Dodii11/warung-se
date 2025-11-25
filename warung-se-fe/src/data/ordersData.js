// Dummy options/filter
export const statusOptions = ["Status", "Selesai", "Diproses", "Tertunda", "Gagal", "Dikirim"];
export const dateRangeOptions = ["Hari Ini", "Minggu Ini", "Bulan Ini"];
export const customerOptions = ["Edi", "Yanto", "Yono", "Ferdi", "Sudar", "Maskun"];

// Table columns
export const columns = [
  { label: "ID Pesanan", key: "id" },
  { label: "Pelanggan", key: "customer" },
  { label: "Tanggal", key: "date" },
  { label: "Total", key: "total" },
  { label: "Status", key: "status" },
  { label: "Driver", key: "driver" },
];

// Dummy rows (nanti bisa pakai api)
export const rows = [
  { id: "#12345", customer: "Edi", date: "2024-01-15", total: "Rp 50.000", status: "Dikirim", driver: "Dodii" },
  { id: "#12346", customer: "Yanto", date: "2024-01-16", total: "Rp 25.000", status: "Tertunda", driver: "Belum ditetapkan" },
  { id: "#12347", customer: "Yono", date: "2024-01-17", total: "Rp 75.000", status: "Diproses", driver: "Belum ditetapkan" },
  { id: "#12348", customer: "Ferdi", date: "2024-01-18", total: "Rp 100.000", status: "Gagal", driver: "Bagas" },
  { id: "#12349", customer: "Sudar", date: "2024-01-19", total: "Rp 50.000", status: "Selesai", driver: "Nopal" },
  { id: "#12350", customer: "Maskun", date: "2024-01-20", total: "Rp 25.000", status: "Tertunda", driver: "Belum ditetapkan" },
  { id: "#12351", customer: "Udin", date: "2024-01-21", total: "Rp 30.000", status: "Diproses", driver: "Belum ditetapkan" },
];
