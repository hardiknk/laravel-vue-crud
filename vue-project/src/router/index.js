import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";
import RegisterView from "@/views/Auth/RegisterView.vue";
import { useAuthStore } from "@/stores/auth";
import Show from "@/views/Post/Show.vue";


const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "home",
      component: HomeView,
      meta: { auth: true },
    },
    {
      path: "/register",
      name: "register",
      component: RegisterView,
      meta: { guest: true },
    },
    {
      path: "/about",
      name: "about",
      component: () => import("../views/AboutView.vue"),
      meta: { auth: true },
    },
    {
      path: "/login",
      name: "login",
      component: () => import("../views/Auth/LoginView.vue"),
      meta: { guest: true },
    },
    {
      path: "/create-post",
      name: "create_post",
      component: () => import("../views/Post/CreateView.vue"),
      meta: { auth: true },
    },
    {
      path: "/posts/:id",
      name: "show",
      component: () => Show,
      meta: { auth: true },
    },
  ],
});

router.beforeEach(async (to, from) => {
  console.log("to", to);
  
  const authStore = useAuthStore();
  await authStore.getUser();

  if (authStore.user && to.meta.guest) {
    return { name: "home" };
  }
  if (!authStore.user && to.meta.auth) {
    return { name: "login" };
  }
});
export default router;
