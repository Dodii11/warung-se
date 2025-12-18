// router/index.js
import { createRouter, createWebHistory } from "vue-router";
import { useAuth } from "@/stores/auth";

// ADMIN PAGES
import AdminLayout from "@/views/layouts/AdminLayout.vue";
import AdminDashboard from "@/views/Admin/AdminDashboard.vue";
import AdminOrders from "@/views/Admin/AdminOrders.vue";
import AdminMenu from "@/views/Admin/AdminMenu.vue";
import AdminUser from "@/views/Admin/AdminUser.vue";
import AdminDriver from "@/views/Admin/AdminDriver.vue";
import AdminAdmin from "@/views/Admin/AdminAdmin.vue";

// CUSTOMER PAGES
import UserLayout from "@/views/layouts/UserLayout.vue";
import LandingPage from "@/views/user/LandingPage.vue";
import MenuPage from "@/views/user/MenuPage.vue";
import DetailMenu from "@/views/user/DetailMenu.vue";
import CartPage from "@/views/user/CartPage.vue";
import FormDetailPesanan from "@/views/user/FormDetailPesanan.vue";
import DetailPesanan from "@/views/user/DetailPesanan.vue";
import ReceiptPage from "@/views/user/ReceiptPage.vue";
import UserProfile from "@/views/user/ProfilePage/UserProfile.vue";

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
      meta: { requiresAuth: true, role: ["admin", "superadmin", "super admin"]  },
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
          path: "profile",
          name: "UserProfile",
          component: UserProfile,
          meta: {
            title: "Profile Saya - Warung SE",
            requiresAuth: true
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
    {
  path: "/auth/google/callback",
  name: "GoogleCallback",
  component: () => import("@/views/callback.vue"),
  meta: { title: "Login Google - Warung SE", public: true, }
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


//Navigasi Guard
router.beforeEach(async (to, from, next) => {
  const auth = useAuth();

  // ⏳ tunggu auth init dari main.js
  await auth.waitForInitialization();

  // public route
  if (to.meta.public) return next();

  // butuh login
  if (to.meta.requiresAuth && !auth.isLoggedIn) {
    return next({ name: "Login" });
  }

  // cegah login/register kalau sudah login
  if (auth.isLoggedIn && ["Login", "Register"].includes(to.name)) {
    if (["admin", "superadmin", "super admin"].includes(auth.user?.role)) {
      return next("/admin/dashboard");
    }
    return next("/");
  }

  // force admin ke dashboard
  if (to.path === "/" && auth.isLoggedIn) {
    if (["admin", "superadmin", "super admin"].includes(auth.user?.role)) {
      return next("/admin/dashboard");
    }
  }

  // role-based access
  if (to.meta.role) {
    const userRole = auth.user?.role;
    const allowedRoles = Array.isArray(to.meta.role)
      ? to.meta.role
      : [to.meta.role];

    if (
      userRole !== "super admin" &&
      userRole !== "superadmin" &&
      !allowedRoles.includes(userRole)
    ) {
      return next("/");
    }
  }

  next();
});


export default router;
