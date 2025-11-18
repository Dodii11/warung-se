import { createRouter, createWebHistory } from "vue-router";
import { useAuthStore } from "@/stores/authStore";
import AdminLayout from "@/views/layouts/AdminLayout.vue";
import AdminDashboard from "@/views/admin/AdminDashboard.vue";
import AdminOrders from "@/views/admin/AdminOrders.vue";
import LoginPage from "@/views/LoginPage.vue";
import RegisterPage from "@/views/RegisterPage.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/admin",
      component: AdminLayout,
      meta: { requiresAuth: true, role: "admin" },
      children: [
        {
          path: "",
          redirect: "/admin/dashboard",
        },
        {
          path: "dashboard",
          name: "AdminDashboard",
          component: AdminDashboard,
          meta: { title: "Dashboard - Warung SE" },
        },
        {
          path: "orders",
          name: "AdminOrders",
          component: AdminOrders,
          meta: { title: "Pesanan - Warung SE" },
        },
      ],
    },

    // --- GRUP HALAMAN PUBLIK/AUTH ---
    {
      path: "/login",
      name: "Login",
      component: LoginPage,
      meta: { title: "Login - Warung SE", requiresAuth: false },
    },
    {
      path: "/register",
      name: "Register",
      component: RegisterPage,
      meta: { title: "Daftar - Warung SE", requiresAuth: false },
    },

    // --- FALLBACK/REDIRECT ---
    {
      path: "/",
      redirect: "/login",
    },
    {
      path: "/:pathMatch(.*)*",
      redirect: "/login",
    },
    {
  path: '/auth/google/success',
  name: 'GoogleSuccess',
  component: () => import('@/views/GoogleSuccess.vue')
}
  ],
  // --- AKHIR PENGGANTIAN 'routes' ---
  scrollBehavior: () => ({ top: 0 }),
});

// ---- Global Navigation Guard ----
router.beforeEach((to, from, next) => {
  const auth = useAuthStore();
  document.title = to.meta.title || "Warung SE";

  if (to.meta.requiresAuth && !auth.isAuthenticated) {
    return next("/login");
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
