// router/index.js
import { createRouter, createWebHistory } from "vue-router";
import { useAuthStore } from "@/stores/authStore";

// AUTH PAGES
import AdminLayout from "@/views/layouts/AdminLayout.vue";
import AdminDashboard from "@/views/Admin/AdminDashboard.vue";
import AdminOrders from "@/views/Admin/AdminOrders.vue";
import AdminMenu from "@/views/Admin/AdminMenu.vue";
import AdminUser from "@/views/Admin/AdminUser.vue";
import AdminDriver from "@/views/Admin/AdminDriver.vue";
import AdminAdmin from "@/views/Admin/AdminAdmin.vue";

import LoginPage from "@/views/LoginPage.vue";
import RegisterPage from "@/views/RegisterPage.vue";

// CUSTOMER PAGES
import CustomerLayout from "@/views/layouts/UserLayout.vue";
import LandingPage from "@/views/user/LandingPage.vue";
import MenuPage from "@/views/user/MenuPage.vue";
import DetailMenu from "@/views/user/DetailMenu.vue";
import CartPage from "@/views/user/CartPage.vue";
import FormDetailPesanan from "@/views/user/FormDetailPesanan.vue";
import DetailPesanan from "@/views/user/DetailPesanan.vue";
import ReceiptPage from "@/views/user/ReceiptPage.vue";
// Tambahkan import untuk AkunProfile
import AkunProfile from "@/views/user/AkunProfile.vue"; // Sesuaikan path jika berbeda

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    // ---- ADMIN AREA ----
    {
      path: "/admin",
      component: AdminLayout,
      meta: { requiresAuth: true, role: "admin" },
      children: [
        { path: "", redirect: "/admin/dashboard" },
        {
          path: "dashboard",
          name: "AdminDashboard",
          component: AdminDashboard,
        },
        {
          path: "orders",
          name: "AdminOrders",
          component: AdminOrders,
        },
        {
          path: "menu",
          name: "AdminMenu",
          component: AdminMenu,
          meta: {title: "Menu - Warung SE"}
        },
        {
          path: "user",
          name: "AdminUser",
          component: AdminUser,
          meta: {title: "User - Warung SE"}
        },
        {
          path: "driver",
          name: "AdminDriver",
          component: AdminDriver,
          meta: {title: "Driver - Warung SE"}
        },
        {
          path: "managementAdmin",
          name: "AdminAdmin",
          component: AdminAdmin,
          meta: {title: "ManagementAdmin - Warung SE"}
        },
      ],
    },

    // ---- CUSTOMER AREA ----
    {
      path: "/",
      component: CustomerLayout,
      children: [
        {
          path: "",
          name: "LandingPage",
          component: LandingPage,
          meta: { title: "Selamat Datang - Warung SE" },
        },
        {
          path: "menu",
          name: "MenuPage",
          component: MenuPage, // ✅ gunakan import statis
          meta: { title: "Menu - Warung SE" },
        },
        {
          path: "menu/:name",
          name: "DetailMenu",
          component: DetailMenu,
          props: true, // biar param route diteruskan ke props
        },
        {
          path: "cart",
          name: "CartPage",
          component: CartPage, // pastikan sudah import CartPage
          meta: { title: "Keranjang Belanja - Warung SE" },
        },
        {
          path: "checkout",
          name: "FormDetailPesanan",
          component: FormDetailPesanan, // pastikan sudah import DetailPesanan
          meta: { title: "Detail Pesanan - Warung SE" },  
        },
        {
          path: "detail-pesanan",
          name: "DetailPesanan",
          component: DetailPesanan,
          meta: { title: "Detail Pesanan - Warung SE" },
        },
        {
          path: "struk",
          name: "StrukPage",
          component: ReceiptPage,
          meta: { title: "Struk Pesanan - Warung SE" },
        },
        // Tambahkan rute untuk AkunProfile di sini
        {
          path: "akun-saya",
          name: "AkunProfile",
          component: AkunProfile,
          meta: { 
            title: "Akun Saya - Warung SE",
            requiresAuth: true // Tambahkan jika hanya untuk user yang login
          }
        }
      ],
    },

    // ---- AUTH PAGES ----
    {
      path: "/login",
      name: "Login",
      component: LoginPage,
      meta: { title: "Login - Warung SE" },
    },
    {
      path: "/register",
      name: "Register",
      component: RegisterPage,
      meta: { title: "Daftar - Warung SE" },
    },

    // ---- FALLBACK ----
    {
      path: "/:pathMatch(.*)*",
      redirect: "/",
    },
    {
  path: '/auth/google/success',
  name: 'GoogleSuccess',
  component: () => import('@/views/GoogleSuccess.vue')
}
  ],

  // ✅ Tambahkan scrollBehavior yang support hash & offset navbar
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) {
      return savedPosition;
    } else if (to.hash) {
      return {
        el: to.hash,
        behavior: "smooth",
        offset: { top: 72 }, // sesuaikan dengan tinggi navbar (60px + sedikit ruang)
      };
    } else {
      return { top: 0 };
    }
  },
});

// ---- NAVIGATION GUARDS ----
router.beforeEach((to, from, next) => {
  const auth = useAuthStore();

  document.title = to.meta.title || "Warung SE";

  // 🟩 1. Rute butuh login
  if (to.meta.requiresAuth && !auth.isAuthenticated) {
    return next({ name: "Login" });
  }

  if (auth.isAuthenticated && (to.path === "/login" || to.path === "/register")) {
    // biar user login gak bisa balik ke login/register
    return next("/admin/dashboard");
  }

  // jika route butuh role tertentu
  if (to.meta.role && auth.user?.role !== to.meta.role) {
    return next("/login");
  }

  next();
});

export default router;