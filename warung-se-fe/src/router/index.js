import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '@/stores/authStore'

// Import halaman
import HomeView from '@/views/Home.vue'
import LoginView from '@/views/Login.vue'
import Admin from '@/views/Admin.vue'
import Orders from '@/views/Orders.vue'

const routes = [
  { path: '/', name: 'Home', component: HomeView },
  { path: '/login', name: 'Login', component: LoginView },
  {
    path: '/admin',
    name: 'Admin',
    component: Admin,
    meta: { role: 'admin' } // Tandai: HANYA untuk admin
  },
  {
    path: '/orders',
    name: 'Orders',
    component: Orders,
    meta: { role: 'user' } // Tandai: HANYA untuk user
  }
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes
})

// NAVIGASI
router.beforeEach((to, from, next) => {
  const auth = useAuthStore()

  if (to.meta.role && auth.user.role !== to.meta.role) {
    next({ name: 'Home' })
  } else {
    next()
  }
})

export default router
