import "./assets/main.css";

import { createApp } from "vue";
import { createPinia } from "pinia";

import { useAuth } from "./stores/auth";
import App from "./App.vue";
import router from "./router";

const pinia = createPinia();
const app = createApp(App);

app.use(pinia);
app.use(router);

const authStore = useAuth(pinia);
authStore.fetchUser();

app.mount("#app");
