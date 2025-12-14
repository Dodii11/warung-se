import {
  Users,
  ShoppingCart,
  Wallet,
  Truck,
} from "lucide-vue-next";

export const buildDashboardStats = (statistik) => [
  {
    label: "Total User",
    value: statistik.total_user,
    icon: Users,
    color: { bg: "bg-blue-100", text: "text-blue-600" },
    change: 0,
  },
  {
    label: "Total Pesanan",
    value: statistik.total_pesanan,
    icon: ShoppingCart,
    color: { bg: "bg-green-100", text: "text-green-600" },
    change: 0,
  },
  {
    label: "Pendapatan",
    value: statistik.total_pendapatan,
    valueDisplay: `Rp ${Number(statistik.total_pendapatan).toLocaleString("id-ID")}`,
    icon: Wallet,
    color: { bg: "bg-yellow-100", text: "text-yellow-600" },
    change: 0,
  },
  {
    label: "Total Driver",
    value: statistik.total_driver,
    icon: Truck,
    color: { bg: "bg-purple-100", text: "text-purple-600" },
    change: 0,
  },
];
