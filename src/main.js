// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import FastClick from 'fastclick'
import MintUI from 'mint-ui'
import 'mint-ui/lib/style.css'
import VueRouter from 'vue-router'
import axios from 'axios'
import App from './App'
import Home from './components/Home.vue'
import Nearby from './components/Nearby.vue'
import Cart from './components/Cart.vue'
import PersonCenter from './components/PersonCenter.vue'
import Detail from './components/Detail.vue'
import Main from './components/Main.vue'
import Login from './components/Login.vue'
import Search from './components/Search.vue'
import MyAccount from './components/MyAccount.vue'
import Address from './components/Address.vue'
import addAddress from './components/addAddress.vue'
import editAddress from './components/editAddress.vue'
import './js/cookie.js'

Vue.use(VueRouter)
Vue.use(MintUI)

const routes = [
  // {
  //   path: '/main',
  //   component: Main,
  //   children: [
  //     {path: 'home', component: Home},
  //     {path: 'nearby', component: Nearby},
  //     // {path: 'cart', component: Cart},
  //     {path: 'personCenter', component: PersonCenter},
  //   ]
  // },
  {path:'/main/home',component:Home},
  {path:'/main/nearby',component:Nearby},
  {path:'/main/cart',component:Cart},
  {path:'/main/personCenter',component:PersonCenter},
  // {path: '/main/cart', component: Cart},
  {path: '/main/home/detail/:id', component: Detail},
  {path:'/login',component:Login},
  {path:'/main/home/search',component:Search},
  {path:'/main/personCenter/myAccount',component:MyAccount},
  {path:'/main/personCenter/myAccount/address',component:Address},
  {path:'/main/personCenter/myAccount/address/addAddress',component:addAddress},
  {path:'/main/personCenter/myAccount/address/editAddress:aid',component:editAddress},
  {path: '*', redirect: '/main/home'}
]

const router = new VueRouter({
	//mode: 'history', //切换路径模式，变成history模式
	//scrollBehavior: () => ({ y: 0 }),// 滚动条滚动的行为，不加这个默认就会记忆原来滚动条的位置
  mode:'history',
    scrollBehavior (to, from, savedPosition) {
  if (savedPosition) {
    return savedPosition
  } else {
    return { x: 0, y: 0 }
  }
},
  routes,
})
/*release*/
//axios.defaults.baseURL = '/project/static/data';
//
/*调试*/
axios.defaults.baseURL = 'http://192.168.31.128/project/static/data';
//axios.defaults.headers.common['Authorization'] = AUTH_TOKEN;
//axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';

Vue.prototype.$http = axios  //其他页面在使用axios的时候直接  this.$http就可以了

FastClick.attach(document.body)

/* eslint-disable no-new */
new Vue({
  router,
  render: h => h(App)
}).$mount('#app')
