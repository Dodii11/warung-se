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

  // Jangan otomatis redirect ke dashboard kalau baru buka /
  if ((to.path === "/login" || to.path === "/register") && auth.isAuthenticated) {
    return next("/admin/dashboard");
  }

  next();
});

export default router;
