// router/index.js
import { createRouter, createWebHistory } from "vue-router";
import { useAuthStore } from "@/stores/authStore";

// ADMIN PAGES
import AdminLayout from "@/views/layouts/AdminLayout.vue";
import AdminDashboard from "@/views/admin/AdminDashboard.vue";
import AdminOrders from "@/views/admin/AdminOrders.vue";
import AdminMenu from "@/views/admin/AdminMenu.vue";
import AdminUser from "@/views/admin/AdminUser.vue";
import AdminDriver from "@/views/admin/AdminDriver.vue";
import AdminAdmin from "@/views/admin/AdminAdmin.vue";

// CUSTOMER PAGES
import UserLayout from "@/views/layouts/UserLayout.vue";
import LandingPage from "@/views/user/LandingPage.vue";
import MenuPage from "@/views/user/MenuPage.vue";
import DetailMenu from "@/views/user/DetailMenu.vue";
import CartPage from "@/views/user/CartPage.vue";
import FormDetailPesanan from "@/views/user/FormDetailPesanan.vue";
import DetailPesanan from "@/views/user/DetailPesanan.vue";
import ReceiptPage from "@/views/user/ReceiptPage.vue";
import AkunProfile from "@/views/user/AkunProfile.vue";

// PUBLIK PAGE
import LoginPage from "@/views/LoginPage.vue";
import RegisterPage from "@/views/RegisterPage.vue";

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
      component: UserLayout,
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
          component: MenuPage,
          meta: { title: "Menu - Warung SE" },
        },
        {
          path: "menu/:name",
          name: "DetailMenu",
          component: DetailMenu,
          props: true,
        },
        {
          path: "cart",
          name: "CartPage",
          component: CartPage,
          meta: { title: "Keranjang Belanja - Warung SE" },
        },
        {
          path: "checkout",
          name: "FormDetailPesanan",
          component: FormDetailPesanan,
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
  ],

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

  // 🟩 2. Jika sudah login, cegah buka login/register
  if (auth.isAuthenticated && (to.path === "/login" || to.path === "/register")) {
    if (auth.user?.role === "admin") {
      return next("/admin/dashboard");
    } else {
      return next("/");
    }
  }

  // 🟩 3. Cek role (admin/user)
  if (to.meta.role && auth.user?.role !== to.meta.role) {
    return next("/");
  }

  next();
});

export default router;
