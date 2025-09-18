import { createRouter,createWebHashHistory } from "vue-router";
import Home from "@/pages/HomePage.vue";
import Login from "@/pages/Login.vue";
import Register from "@/pages/Register.vue";
import LayoutPage from "@/pages/Layout.vue";
import AuthLayout from "@/pages/Auth/AuthLayout.vue";
import DashbardLayout from "@/pages/dashboard/Layout.vue"
import Dashboard from "@/pages/dashboard/Dashboard.vue";
const routes = [
  {path:'/',
    component: LayoutPage,
    children:[
      {path:'',component:Home},
      


    ]
  },
  {
    path:'/login',
    component:AuthLayout,
    children:[
      {path:'',component:Login}
    ]
  },
        {
    path:'/register',
    component:AuthLayout,
    children:[
      {path:'',component:Register}
    ]
  },
  {
    path:'/dashboard',
    component:DashbardLayout,
    children:[
      {path:'',component:Dashboard}
    ]

  }

    
  ];

  
const router = createRouter({
    history:createWebHashHistory(),
    routes
});

// ✅ Navigation Guard
// router.beforeEach(async (to, from, next) => {
//   const isAuthenticated = localStorage.getItem('user') !== null

//   // Allow access to setup, login and register pages
//   if (to.path === '/setup' || to.path === '/login' || to.path === '/register') {
//     // For setup page, check if admin already exists
//     if (to.path === '/setup') {
//       try {
//         const response = await services.AuthService.checkSetup()
//         const data = response.data
//         if (data.hasAdmin) {
//           // If admin exists, redirect to login
//           next({ path: '/login' })
//           return
//         }
//       } catch (err) {
//         console.error('Setup check error:', err)
//         // If it's a 409 conflict, it means admin exists
//         if (err.response && err.response.status === 409) {
//           next({ path: '/login' })
//           return
//         }
//         // If check fails, allow access to setup
//       }
//     }
//     next()
//   } else if (!isAuthenticated) {
//     // Check if setup is needed before redirecting to login
//     try {
//       const response = await services.AuthService.checkSetup()
//       console.log('Setup check response:', response.data)
//       const data = response.data
//       if (!data.hasAdmin) {
//         // If no admin exists, redirect to setup
//         console.log('No admin found, redirecting to setup')
//         next({ path: '/setup' })
//         return
//       } else {
//         console.log('Admin exists, redirecting to login')
//       }
//     } catch (err) {
//       console.error('Setup check error:', err)
//       // If it's a 409 conflict, it means admin exists
//       if (err.response && err.response.status === 409) {
//         console.log('409 conflict - admin exists, redirecting to login')
//         // Admin exists, continue to login redirect
//       } else {
//         // If check fails, assume no admin and redirect to setup
//         console.log('Check failed, assuming no admin, redirecting to setup')
//         next({ path: '/setup' })
//         return
//       }
//     }
//     // Only redirect to login if admin exists and user is not authenticated
//     next({ path: '/login' })
//   } else {
//     next()
//   }
// })


export default router;