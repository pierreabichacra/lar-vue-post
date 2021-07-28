import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import Login from "@/views/Login";
import PostDetails from "@/components/PostDetails";
Vue.use(VueRouter)

const routes = [{
  path: '/',
  name: 'Home',
  component: Home
},{
  path: '/login',
  name: 'Login',
  component: Login
},{
  path: '/Details',
  name: 'Details',
  component: PostDetails
}, ]

const router = new VueRouter({
  mode: 'history',
  routes
})

export default router