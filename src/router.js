import Vue from 'vue'
import Router from 'vue-router'
import Login from "./components/Login.vue"
import Register from "./components/Register.vue"
import Home from "./components/Home.vue"
import Sidebar from "./components/Sidebar.vue"
import Dashboard from "./components/Dashboard.vue"
import Products from "./components/Products.vue"
import Procure from "./components/Procure.vue"
import Sell from "./components/Sell.vue"
import DashboardNavigation from "./components/DashboardNavigation.vue"
import ProductTable from "./components/ProductTable.vue"

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'home',
      components :{
        default : Home
        , sidebar : Sidebar
      }
    },
    {
      path : "/sell/:active"
      , name : "sell"
      , components : {
        default : Sell,
        nav : DashboardNavigation,
        left : Sidebar
      }
    },
    {
      path: '/dashboard/:active',
      components: {
        default: Dashboard,
        left : Sidebar,
        nav : DashboardNavigation,
        content : Products
      }
    },
    {
      path: '/products/:active',
      components: {
        default: Dashboard,
        left : Sidebar,
        nav : DashboardNavigation,
        content : ProductTable
      }
    }
    , {
      path: '/procure',
      components: {
        default: Procure,
        left : Sidebar,
        content : Products
      }
    }
    
    , { path: '/a', redirect: '/' }
    , {
      path: '/login',
      name: 'login',
      component: Login
    }
    , {
      path: '/register',
      name: 'register',
      component: Register
    }
  ]
})