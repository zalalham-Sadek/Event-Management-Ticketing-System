import { createRouter, createWebHashHistory } from "vue-router";
import Home from "@/pages/HomePage.vue";
import Login from "@/pages/Login.vue";
import Register from "@/pages/Register.vue";
import LayoutPage from "@/pages/Layout.vue";
import AuthLayout from "@/pages/Auth/AuthLayout.vue";
import DashbardLayout from "@/pages/dashboard/Layout.vue";
import Dashboard from "@/pages/dashboard/Dashboard.vue";
import Admin from "@/pages/Admin.vue";
import Users from "@/pages/dashboard/users/Users.vue";
import AddUser from "@/pages/dashboard/users/AddUser.vue";
import EditUser from "@/pages/dashboard/users/EditUser.vue";
import Events from "@/pages/dashboard/events/Events.vue";
import AddEvent from "@/pages/dashboard/events/AddEvent.vue";
import EventDetails from "@/pages/dashboard/events/EventDetails.vue";
import EditEvent from "@/pages/dashboard/events/EditEvent.vue";
import Tickets from "@/pages/dashboard/tickets/Tickets.vue";
import AddTicket from "@/pages/dashboard/tickets/AddTicket.vue";
import EditTicket from "@/pages/dashboard/tickets/EditTicket.vue";
import Orders from "@/pages/dashboard/orders/Orders.vue";
import TicketBooking from "@/pages/TicketBooking.vue";
import PaymentPage from "@/pages/PaymentPage.vue";
import ProfilePage from "@/pages/ProfilePage.vue";

const routes = [
  {
    path: "/",
    component: LayoutPage,
    children: [
      { path: "", component: Home },
        {
    path: "/events/:eventId/book",
    component: TicketBooking,
  },
  {
    path: "/events/:eventId/payment",
    component: PaymentPage,
  },
  {
    path: "/profile",
    component: ProfilePage,
  },
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
    children:
    [
      { path: "", component: Dashboard },
      {path:"/users",component: Users},
      {path:"/users/create",component: AddUser},
      {path:"/users/edit/:id",component: EditUser},
      {path:"/events",component:Events},
      {path:"/events/:id",component:EventDetails},
      {path:"/events/create",component: AddEvent},
      {path:"/events/edit/:id",component: EditEvent},
      {path:"/events/tickets",component: Tickets},
      {path:"/events/:eventId/tickets/create",component: AddTicket},
      {path:"/events/:eventId/tickets/edit/:ticketId",component: EditTicket},
      {path:"/orders",component: Orders},
    ],
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
  const userData = localStorage.getItem("user");
  const user = JSON.parse(userData);
  // لو المستخدم Authenticated وحاول يروح للـ login أو register → رجعه للـ dashboard
  
if (isAuthenticated) {
  if (user?.role === "Admin" || user?.role === "Organizer") {
    // Admin or Organizer
    if (to.path === "/login" || to.path === "/register" || to.path === "/profile") {
      next({ path: "/dashboard" });
    } else {
      next();
    }
  } else if (user?.role === "Attendee") {
    // Attendee
    if (to.path === "/login" || to.path === "/register" || to.path === "/dashboard") {
      next({ path: "/profile" });
    } else {
      next();
    }
  } else {
    next(); // unknown role
  }
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
