import img1 from "@/assets/Geprek1.png"
import img2 from "@/assets/Geprek2.png"
import img3 from "@/assets/Geprek3.png"

// Kategori
export const categoryOptions = [
  "Kategori",
  "Ayam",
  "Mie",
  "Minuman",
];

// Data dummy menu
export const menuItems = [
  {
    id: 1,
    name: "Ayam Geprek Sambal Matah",
    description: "Ayam geprek dengan topping sambal matah",
    price: 14000,
    category: "Ayam",
    stock: 15,
    status: "Tidak Tersedia",
    image: img1,
  },
  {
    id: 2,
    name: "Ayam Geprek Lada Hitam",
    description: "Ayam geprek dengan sensasi lada hitam nikmat",
    price: 13000,
    category: "Ayam",
    stock: 10,
    status: "Tersedia",
    image: img2,
  },
  {
    id: 3,
    name: "Ayam Geprek Keju",
    description: "Ayam geprek dengan topping keju",
    price: 10000,
    category: "Ayam",
    stock: 20,
    status: "Tersedia",
    image: img3,
  },
];
