import { createRouter, createWebHashHistory } from "vue-router";
import Home from "@/pages/HomePage.vue";
import Login from "@/pages/Login.vue";
import Register from "@/pages/Register.vue";
import LayoutPage from "@/pages/Layout.vue";
import AuthLayout from "@/pages/Auth/AuthLayout.vue";
import DashbardLayout from "@/pages/dashboard/Layout.vue";
import Dashboard from "@/pages/dashboard/Dashboard.vue";
import Admin from "@/pages/Admin.vue";

const routes = [
  {
    path: "/",
    component: LayoutPage,
    children: [
      { path: "", component: Home },
    ],
  },
  {
    path: "/login",
    component: AuthLayout,
    children: [{ path: "", component: Login }],
  },
  {
    path: "/register",
    component: AuthLayout,
    children: [{ path: "", component: Register }],
  },
  {
    path: "/admin",
    component: AuthLayout,
    children: [{ path: "", component: Admin }],
  },
  {
    path: "/dashboard",
    component: DashbardLayout,
    children: [{ path: "", component: Dashboard }],
    meta: { requiresAuth: true }, // ✅ شرط المصادقة
  },

  // ✅ أي مسار غير موجود يرجع للصفحة الرئيسية
  {
    path: "/:pathMatch(.*)*",
    redirect: "/",
  },
];

const router = createRouter({
  history: createWebHashHistory(),
  routes,
});

// ✅ Navigation Guard
// ✅ Navigation Guard
router.beforeEach((to, from, next) => {
  const token = localStorage.getItem("api_token"); // خزّنه وقت تسجيل الدخول
  const isAuthenticated = !!token;

  // لو المستخدم Authenticated وحاول يروح للـ login أو register → رجعه للـ dashboard
  if (isAuthenticated && (to.path === "/login" || to.path === "/register")) {
    next({ path: "/dashboard" });
  }
  // لو الصفحة تتطلب Auth والمستخدم مش مسجل → رجعه للـ login
  else if (to.matched.some(record => record.meta.requiresAuth) && !isAuthenticated) {
    next({ path: "/login" });
  }
  // غير كذا → كمل عادي
  else {
    next();
  }
});


export default router;
