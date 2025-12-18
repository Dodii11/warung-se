import "./assets/main.css";

import { createApp } from "vue";
import { createPinia } from "pinia";

import { useAuth } from "./stores/auth";
import App from "./App.vue";
import router from "./router";

const app = createApp(App);
const pinia = createPinia();

app.use(pinia);

const authStore = useAuth(pinia);

// ✅ INIT AUTH SEKALI SAJA
await authStore.initializeAuth();

app.use(router);
app.mount("#app");
