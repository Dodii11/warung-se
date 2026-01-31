// Options/filter (diseragamkan dengan rows)
export const statusOptions = [
	"Status",
	"Selesai",
	"Diproses",
	"Tertunda",
	"Gagal",
	"Dikirim",
];

export const dateRangeOptions = [
	"Hari Ini",
	"Minggu Ini",
	"Bulan Ini",
];

export const customerOptions = [
	"Edi", "Yanto", "Yono", "Ferdi", "Sudar", "Maskun", "Udin",
];

// Kolom tabel pesanan (hanya kolom yang ditampilkan di tabel)
export const columns = [
	{ label: "ID Pesanan", key: "id" },
	{ label: "Pelanggan", key: "customer" },
	{ label: "Tanggal", key: "date" },
	{ label: "Total", key: "total" },
	{ label: "Status", key: "status" },
	{ label: "Driver", key: "driver" },
];

// Rows
export const rows = [
	{
        id: "#12345",
        customer: "Edi",
        date: "2024-01-15",
        total: "Rp 50.000",
        status: "Dikirim",
        driver: "Dodii",
        customerPhone: "081211112222",
        customerAddress: "Jl. Mawar No. 5, Jakarta Selatan",
        driverPhone: "081234567890",
        driverVehicle: "Honda Beat B 1234 ABC",
    },
	{
        id: "#12346",
        customer: "Yanto",
        date: "2024-01-16",
        total: "Rp 25.000",
        status: "Tertunda",
        driver: "Belum ditetapkan",
        customerPhone: "085633334444",
        customerAddress: "Jl. Melati No. 10, Bogor",
        driverPhone: "N/A",
        driverVehicle: "N/A",
    },
	{
        id: "#12347",
        customer: "Yono",
        date: "2024-01-17",
        total: "Rp 75.000",
        status: "Diproses",
        driver: "Bagas",
        customerPhone: "087855556666",
        customerAddress: "Komplek Anggrek Blok C, Bandung",
        driverPhone: "085678901234",
        driverVehicle: "Yamaha NMax B 9012 FG",
    },
	{
        id: "#12348",
        customer: "Ferdi",
        date: "2024-01-18",
        total: "Rp 100.000",
        status: "Gagal",
        driver: "Bagas",
        customerPhone: "081277778888",
        customerAddress: "Jl. Kenanga 45, Surabaya",
        driverPhone: "085678901234",
        driverVehicle: "Honda Beat B 1234 ABC",
    },
	{
        id: "#12349",
        customer: "Sudar",
        date: "2024-01-19",
        total: "Rp 50.000",
        status: "Selesai",
        driver: "Nopal",
        customerPhone: "085699990000",
        customerAddress: "Perumahan Tulip Kav. 12, Semarang",
        driverPhone: "087890123456",
        driverVehicle: "Yamaha NMax B 9012 FG",
    },
	{
        id: "#12350",
        customer: "Maskun",
        date: "2024-01-20",
        total: "Rp 25.000",
        status: "Tertunda",
        driver: "Belum ditetapkan",
        customerPhone: "087811112222",
        customerAddress: "Gedung A Lantai 5, Jakarta Pusat",
        driverPhone: "N/A",
        driverVehicle: "N/A",
    },
	{
        id: "#12351",
        customer: "Udin",
        date: "2024-01-21",
        total: "Rp 30.000",
        status: "Diproses",
        driver: "Supri",
        customerPhone: "081233334444",
        customerAddress: "Jl. Kamboja No. 99, Yogyakarta",
        driverPhone: "081122334455",
        driverVehicle: "Honda Beat B 1234 ABC",
    },
];
