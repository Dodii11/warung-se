// src/main.js
import "./assets/main.css";

import { createApp } from "vue";
import { createPinia } from "pinia";

import App from "./App.vue";
import router from "./router";
import { useAuth } from "@/stores/auth";

const app = createApp(App);
const pinia = createPinia();

app.use(pinia);

const auth = useAuth(pinia);

// 🔥 INIT AUTH SEKALI SAJA
auth.initializeAuth().finally(() => {
  app.use(router);
  app.mount("#app");
});
