import { createRouter, createWebHistory } from "vue-router";
import { useAuthStore } from "@/stores/authStore";

import AdminLayout from "@/views/layouts/AdminLayout.vue";
import AdminDashboard from "@/views/Admin/AdminDashboard.vue";
import AdminOrders from "@/views/Admin/AdminOrders.vue";
import AdminMenu from "@/views/Admin/AdminMenu.vue";
import AdminUser from "@/views/Admin/AdminUser.vue";
import AdminDriver from "@/views/Admin/AdminDriver.vue";

import ProfileLayout from "@/views/layouts/user/ProfileLayout.vue";
import UserPesanan from "@/views/User/UserPesanan.vue";
import UserProfile from "@/views/User/UserProfile.vue";
import UserResi from "@/views/User/UserResi.vue";

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
      ],
    },

    {
      path: "/user",
      component: ProfileLayout,
      // meta: { requiresAuth: true, role: "user" },
      children: [
        { path: "", 
          redirect: "/user/profile" 
        },
        { path: "profile", 
          name: "UserProfile", 
          component: UserProfile, 
          meta: { title: "Profil - Warung SE" } 
        },
        { path: "pesanan", 
          name: "UserPesanan", 
          component: UserPesanan, 
          meta: { title: "Pesanan - Warung SE" } 
        },
        { 
          path: "pesanan/:pesananId/resi",
          name: "UserResi",
          component: UserResi,
          meta: { title: "Resi Pesanan - Warung SE" }
      },
      ]
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
  ],
  // --- AKHIR PENGGANTIAN 'routes' ---
  scrollBehavior: () => ({ top: 0 }),
});

// ---- Global Navigation Guard ----
router.beforeEach((to, from, next) => {
  const auth = useAuthStore();
  document.title = to.meta.title || "Warung SE";

  // if (to.meta.requiresAuth && !auth.isAuthenticated) {
  //  return next("/login");
  //} 

  //if (auth.isAuthenticated && (to.path === "/login" || to.path === "/register")) {
  //  if (auth.user?.role === "admin") {
  //    return next("/admin/dashboard");
  //  } else if (auth.user?.role === "user") {
  //    return next("/user/profile"); 
  // }
  //  return next("/login");
  //}

  // jika route butuh role tertentu
  //if (to.meta.role && auth.user?.role !== to.meta.role) {
  //  return next("/login");
  //}

  next();
});

export default router;
