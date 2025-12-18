<script setup>
import { useAuth } from "@/stores/auth";
import { useRouter } from "vue-router";

const auth = useAuth();
const router = useRouter();

const token = new URLSearchParams(window.location.search).get("token");

(async () => {
  if (token) {
    auth.setAuth(token);
    await auth.fetchUser(); // sekarang aman
    router.replace("/");
  } else {
    router.replace("/login");
  }
})();
</script>


