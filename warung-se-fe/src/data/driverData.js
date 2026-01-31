
// Placeholder image function (using random colors for variation)
const getPlaceholderImage = (name) => {
  const seed = name.split(" ").join("");
  const colors = ["1D4ED8", "059669", "D97706", "DC2626"];
  const color = colors[seed.length % colors.length];
  return `https://placehold.co/600x400/${color}/FFFFFF?text=${name.split(" ")[0][0]}${
    name.split(" ")[1][0]
  }`;
};

export const driverColumns = [
  { label: "ID Driver", key: "id" },
  { label: "Nama", key: "name" },
  { label: "Nomor Telepon", key: "phone" },
  { label: "Kendaraan", key: "vehicleName" },
  { label: "Status", key: "status" },
];

export const driverRows = [
  {
    id: "#DRV-24680",
    name: "Yono Resink",
    phone: "+62812-345-6789",
    vehicleName: "Honda Beat B 1234 ABC",
    vehicleType: "Sepeda Motor",
    image: getPlaceholderImage("Yono Resink"),
    status: "Tidak Aktif",
  },
  {
    id: "#DRV-13579",
    name: "Edi Jumping",
    phone: "+62813-987-6543",
    vehicleName: "Toyota Avanza B 5678 DE",
    vehicleType: "Mobil",
    image: getPlaceholderImage("Edi Jumping"),
    status: "Tersedia",
  },
  {
    id: "#DRV-97531",
    name: "Ferdi Standing",
    phone: "+62819-111-2222",
    vehicleName: "Yamaha NMax B 9012 FG",
    vehicleType: "Sepeda Motor",
    image: getPlaceholderImage("Ferdi Standing"),
    status: "Sedang Pengiriman",
  },
  {
    id: "#DRV-67890",
    name: "Yanto Balap",
    phone: "+62817-444-5555",
    vehicleName: "Isuzu Traga L 3333 TI",
    vehicleType: "Truk Pick Up",
    image: getPlaceholderImage("Yanto Balap"),
    status: "Sedang Pengiriman",
  },
];
