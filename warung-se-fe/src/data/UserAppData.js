// Konstanta untuk path gambar placeholder, agar konsisten dan mudah diubah
const PLACEHOLD_IMG = 'https://placehold.co/500x300/F8D849/B03B3B?text=';

// --- DATA KONTAK & PROFIL ---
export const contactInfo = {
    name: "Warung Serba Enak (WarungSE)",
    phone: "0812-0000-0000",
    email: "support@warungse.com",
    aboutUs: "Selamat datang di WarungSE, sensasi rasa ayam geprek bukan sekadar makanan, tetapi kebahagiaan dalam setiap suap yang tak terlupakan. Kami percaya bahwa setiap hidangan harus spesial. Karena itu, kami hanya menggunakan ayam segar pilihan yang digeprek hingga renyah sempurna, lalu disajikan dengan sambal dadakan yang pedas tetapi tetap menggugah selera Anda.",
    // Gambar Hero dan About tetap diimpor secara lokal di LandingPage.vue untuk menjaga aset asli.
};

// --- DATA KATEGORI ---
export const categories = ["Ayam", "Mie", "Minuman", "Paket Combo"];

// --- DATA MENU ---
// Menggunakan PLACEHOLD_IMG untuk konsistensi di Card Menu
export const menus = [
    {
        name: "Ayam Geprek Original",
        price: "15.000",
        img: `${PLACEHOLD_IMG}Ayam+Original`,
        category: "Ayam",
        stock: 15,
        descDetail: "Ayam geprek klasik dengan bumbu racikan rahasia WarungSE. Daging ayam yang renyah di luar dan juicy di dalam, disajikan dengan sambal bawang pedas yang legendaris. Pedasnya nampol, dijamin ketagihan!",
    },
    {
        name: "Ayam Geprek Sambal Matah",
        price: "20.000",
        img: `${PLACEHOLD_IMG}Ayam+Matah`,
        category: "Ayam",
        stock: 0, // Dibuat 0 untuk menguji ketersediaan
        descDetail: "Sensasi pedas segar dari sambal matah khas Bali berpadu sempurna dengan renyahnya ayam geprek. Sambal matah dibuat fresh setiap hari dengan irisan bawang merah, cabai rawit, dan serai yang berlimpah.",
    },
    {
        name: "Ayam Geprek Keju",
        price: "24.000",
        img: `${PLACEHOLD_IMG}Ayam+Keju`,
        category: "Ayam",
        stock: 8,
        descDetail: "Perpaduan unik antara pedasnya sambal geprek dan creamy-nya lelehan saus keju spesial. Cocok bagi Anda yang menyukai kombinasi rasa pedas manis dan gurih. Toping keju melimpah ruah!",
    },

    {
        name: "Mie Goreng Spesial",
        price: "12.000",
        img: `${PLACEHOLD_IMG}Mie+Goreng`,
        category: "Mie",
        stock: 25,
        descDetail: "Mie goreng dengan bumbu khas WarungSE, disajikan dengan telur, potongan ayam, dan sayuran segar. Porsi mantap untuk makan siang atau malam.",
    },
    {
        name: "Mie Rebus Bakso",
        price: "13.000",
        img: `${PLACEHOLD_IMG}Mie+Rebus`,
        category: "Mie",
        stock: 10,
        descDetail: "Mie kuah hangat dengan bakso sapi kenyal dan kuah kaldu yang gurih. Sangat cocok dinikmati saat cuaca dingin.",
    },

    {
        name: "Es Teh Manis",
        price: "3.000",
        img: `${PLACEHOLD_IMG}Es+Teh`,
        category: "Minuman",
        stock: 50,
        descDetail: "Minuman klasik yang selalu menyegarkan. Teh pilihan dengan tingkat kemanisan yang pas, menghilangkan dahaga setelah makan pedas.",
    },
    {
        name: "Es Jeruk Segar",
        price: "4.000",
        img: `${PLACEHOLD_IMG}Es+Jeruk`,
        category: "Minuman",
        stock: 40,
        descDetail: "Perasan jeruk asli yang kaya vitamin C. Segar, manis, dan sedikit asam untuk menyempurnakan hidangan Anda.",
    },

    {
        name: "Paket Hemat Ayam + Minuman",
        price: "25.000",
        img: `${PLACEHOLD_IMG}Paket+Ayam`,
        category: "Paket Combo",
        stock: 12,
        descDetail: "Paket hemat yang berisi satu porsi Ayam Geprek Original dan Es Teh Manis. Pilihan cerdas untuk makan kenyang dengan harga bersahabat.",
    },
    {
        name: "Paket Mie + Minuman",
        price: "22.000",
        img: `${PLACEHOLD_IMG}Paket+Mie`,
        category: "Paket Combo",
        stock: 7,
        descDetail: "Paket kombo Mie Goreng Spesial dengan Es Jeruk Segar. Kombinasi yang pas antara hidangan utama dan pelepas dahaga.",
    },
];
