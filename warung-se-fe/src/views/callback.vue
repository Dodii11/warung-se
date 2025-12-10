<script>
import { useAuth } from "@/stores/auth";
import { useRouter } from "vue-router";

const router = useRouter();
const auth = useAuth();

const params = new URLSearchParams(window.location.search);
const token = params.get("token");

if (token) {
  auth.setToken(token);
  router.push("/");
} else {
  router.push("/login");
}
</script>