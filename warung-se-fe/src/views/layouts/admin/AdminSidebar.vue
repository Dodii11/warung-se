<template>
  <aside
    class="bg-white border-r border-gray-100 flex flex-col h-full fixed inset-y-0 left-0 transition-all duration-300"
    :class="[
      collapsed ? 'w-20' : 'w-64',
      mobileOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0',
    ]"
  >
    <!-- LOGO AREA -->
    <div
      class="relative h-16 border-b border-gray-100 flex items-center transition-all duration-300"
    >
      <!-- Expanded mode -->
      <div v-if="!collapsed" class="flex items-center gap-3 px-4 w-full">
        <img
          src="@/assets/LogoDashboardAdmin.png"
          alt="Logo"
          class="w-8 h-8 rounded-md transition-all duration-300"
        />
        <h1 class="text-xl font-bold text-primary tracking-wide">WarungSE</h1>
      </div>

      <!-- Collapsed mode -->
      <div v-else class="absolute inset-0 flex items-center justify-center">
        <img
          src="@/assets/LogoDashboardAdmin.png"
          alt="Logo"
          class="w-6 h-6 rounded-md transition-all duration-300"
        />
      </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto p-4 space-y-1">
      <AdminSidebarItem
        v-for="item in filteredNavItems"
        :key="item.path"
        :item="item"
        :collapsed="collapsed"
      />
    </nav>

    <!-- Logout -->
    <div class="p-4 border-t border-gray-100">
      <BaseButton variant="outline-gray" class="w-full" @click="handleLogout">
        <template #icon-left>
          <LogOut class="w-5 h-5" />
        </template>
        <span v-if="!collapsed">Logout</span>
      </BaseButton>
    </div>

    <!-- Close button mobile -->
    <button
      v-if="mobileOpen"
      class="absolute top-4 right-4 md:hidden text-gray-700"
      @click="$emit('closeMobile')"
    >
      ✕
    </button>
  </aside>
</template>

<script setup>
import {
  LayoutDashboard,
  Receipt,
  Users,
  LogOut,
  Motorbike,
  UtensilsCrossed,
  UserRoundCog,
} from "lucide-vue-next";
import AdminSidebarItem from "./AdminSidebarItem.vue";
import BaseButton from "@/components/base/BaseButton.vue";
import { useRouter } from "vue-router";
import { useAuth } from "@/stores/auth";
import { computed } from "vue";

defineProps({
  collapsed: Boolean,
  mobileOpen: Boolean,
});

const navItems = [
  {
    label: "Dashboard",
    path: "/admin/dashboard",
    icon: LayoutDashboard,
    roles: ["admin", "super admin"],
  },
  { label: "Pesanan", path: "/admin/orders", icon: Receipt, roles: ["admin", "super admin"] },
  { label: "Menu", path: "/admin/menu", icon: UtensilsCrossed, roles: ["admin", "super admin"] },
  { label: "Pengguna", path: "/admin/user", icon: Users, roles: ["super admin"] },
  { label: "Driver", path: "/admin/driver", icon: Motorbike, roles: ["admin", "super admin"] },
  { label: "Admin", path: "/admin/managementAdmin", icon: UserRoundCog, roles: ["super admin"] },
];

const auth = useAuth();
const router = useRouter();

const handleLogout = async () => {
  await auth.logout();
  router.push("/login");
};

// Ambil role user
const userRole = computed(() => auth.user?.role?.role_name || auth.user?.role);

// Filter nav items berdasarkan role
const filteredNavItems = computed(() => {
  // Jika masih loading user data, kembalikan empty array
  if (auth.initializing) return [];
  if (!userRole.value) return [];
  return navItems.filter((item) => item.roles.includes(userRole.value));
});
</script>
