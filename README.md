# 🍽️ Warung SE — Fullstack Web App (Laravel API + Vue)

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Vue.js](https://img.shields.io/badge/Vue.js-35495E?style=for-the-badge&logo=vue.js&logoColor=4FC08D)
![REST API](https://img.shields.io/badge/API-RESTful-blue?style=for-the-badge)
![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)

---

## 🧾 Deskripsi Proyek

**Warung SE** adalah aplikasi web yang dibangun menggunakan **Laravel** sebagai backend (API) dan **Vue.js** sebagai frontend.  
Tujuannya adalah untuk menyediakan sistem manajemen warung / toko sederhana — mulai dari pengelolaan produk, transaksi, hingga laporan penjualan — dengan antarmuka modern dan cepat.

---

## 🧑‍💻 Pengembang

| Nama | Role |
|------|------|
| **Dodii** | Fullstack Developer |
| **Laepher** | Back-End Developer  |

---

## ⚙️ Tech Stack

| Layer | Teknologi | Deskripsi |
|-------|------------|------------|
| 🖥️ Frontend | [Vue.js 3](https://vuejs.org/) + [Vite](https://vitejs.dev/) | SPA (Single Page Application) modern |
| ⚙️ Backend | [Laravel 12](https://laravel.com/) | RESTful API & business logic |
| 🗄️ Database | MySQL | Penyimpanan data utama |
| 🔐 Auth | Laravel Sanctum | Token-based authentication |
| 💅 Styling | TailwindCSS | Desain responsif dan ringan |

---

## 📂 Struktur Folder

```
warung-se/
├── backend/        # Laravel API (folder backend)
│   ├── app/
│   ├── routes/
│   └── ...
│
├── frontend/       # Vue.js app (folder frontend)
│   ├── src/
│   ├── public/
│   └── ...
│
└── README.md
```

---

## 🚀 Cara Menjalankan Proyek

### 🔧 1. Clone Repository
```bash
git clone https://github.com/Dodii11/warung-se.git
cd warung-se
```

### ⚙️ 2. Setup Backend (Laravel)
```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate

# Atur koneksi database di file .env
php artisan migrate --seed
php artisan serve
```

Backend akan berjalan di:  
👉 `http://127.0.0.1:8000`

---

### 🖥️ 3. Setup Frontend (Vue)
Buka terminal baru:
```bash
cd frontend
npm install
npm run dev
```

Frontend akan berjalan di:  
👉 `http://localhost:5173`

---

## 🔗 API Endpoint Contoh

| Method | Endpoint | Deskripsi |
|--------|-----------|-----------|
| `POST` | `/api/login` | Login user |
| `GET` | `/api/products` | Ambil daftar produk |
| `POST` | `/api/orders` | Tambah pesanan baru |

---

## 📸 Tampilan (Preview)
*(Tambahkan screenshot di sini jika sudah ada UI-nya)*  
```
![Preview](path/to/screenshot.png)
```

---

## 🤝 Kontribusi
1. Fork repo ini 🍴  
2. Buat branch baru: `feature/nama-fitur`  
3. Commit perubahan: `git commit -m "Tambah fitur X"`  
4. Push ke branch: `git push origin feature/nama-fitur`  
5. Buat Pull Request ✅

---

## 📄 Lisensi
Proyek ini dilisensikan di bawah [MIT License](LICENSE).

---

> 💬 _“Jangan lupa makan.”_
