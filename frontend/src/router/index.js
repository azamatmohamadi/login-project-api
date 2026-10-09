import { createRouter, createWebHistory } from "vue-router";

import Login from "../views/Login.vue";
import Dashboard from "../views/Dashboard.vue";
import ChangePassword from "../views/ChangePassword.vue";

const router = createRouter({
  history: createWebHistory(),

  routes: [
    {
      path: "/",
      redirect: "/login",
    },

    {
      path: "/login",
      name: "login",
      component: Login,
    },

    {
      path: "/dashboard",
      name: "dashboard",
      component: Dashboard,
    },

    {
      path: "/change-password",
      name: "change-password",
      component: ChangePassword,
    },
  ],
});

export default router;
