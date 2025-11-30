import { UsersIcon, ShoppingCartIcon, DollarSignIcon, CarIcon } from "lucide-vue-next";

/**
 * Fungsi untuk memformat angka menjadi format Rupiah (IDR)
 * @param {number} amount
 * @returns {string}
 */
const formatRupiah = (amount) => {
  if (typeof amount !== "number" || isNaN(amount)) return "Rp 0";

  // Konversi ke string dan tambahkan pemisah ribuan
  const formatter = new Intl.NumberFormat("id-ID", {
    style: "currency",
    currency: "IDR",
    minimumFractionDigits: 0, // Tidak ada desimal untuk nilai bulat
    maximumFractionDigits: 0,
  });

  return formatter.format(amount);
};

// Stats untuk dashboard
export const stats = [
  {
    label: "Pengguna",
    value: 1289,
    valueDisplay: "1.289", // Tampilan yang diformat
    change: 12,
    icon: UsersIcon,
    color: { bg: "bg-indigo-100", text: "text-indigo-600" },
  },
  {
    label: "Pesanan",
    value: 457,
    valueDisplay: "457",
    change: -3,
    icon: ShoppingCartIcon,
    color: { bg: "bg-green-100", text: "text-green-600" },
  },
  {
    label: "Pendapatan",
    value: 750000,
    valueDisplay: formatRupiah(750000), // Menggunakan helper format IDR
    change: 8,
    icon: DollarSignIcon,
    color: { bg: "bg-yellow-100", text: "text-yellow-600" },
  },
  {
    label: "Driver",
    value: 19,
    valueDisplay: "19",
    change: -5,
    icon: CarIcon,
    color: { bg: "bg-red-100", text: "text-red-600" },
  },
];
