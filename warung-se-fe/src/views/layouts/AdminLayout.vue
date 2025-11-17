<template>
  <div class="flex min-h-screen bg-bg-base text-gray-900">

    <!-- Mobile Drawer Overlay -->
    <div
      v-if="isMobileSidebarOpen"
      class="fixed inset-0 bg-black/40 backdrop-blur-sm z-40 md:hidden"
      @click="closeMobile"
    ></div>

    <!-- Sidebar -->
    <AdminSidebar
      :collapsed="isCollapsed"
      :mobile-open="isMobileSidebarOpen"
      @closeMobile="closeMobile"
      class="z-50"
    />

    <!-- Main -->
    <div
      class="flex-1 flex flex-col transition-all duration-300"
      :class="isCollapsed ? 'md:ml-20' : 'md:ml-64'"
    >
      <AdminHeader
        :collapsed="isCollapsed"
        @toggleCollapse="toggleCollapse"
        @openMobile="openMobile"
      />

      <main class="flex-1 p-6">
        <RouterView />
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import AdminSidebar from "./admin/AdminSidebar.vue";
import AdminHeader from "./admin/AdminHeader.vue";

// Desktop collapse
const isCollapsed = ref(false);
const toggleCollapse = () => (isCollapsed.value = !isCollapsed.value);

// Mobile drawer
const isMobileSidebarOpen = ref(false);
const openMobile = () => (isMobileSidebarOpen.value = true);
const closeMobile = () => (isMobileSidebarOpen.value = false);
</script>
