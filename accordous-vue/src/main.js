import Vue from 'vue'
import App from './App.vue'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

import axios from 'axios'
import VueAxios from 'vue-axios'

import VueRouter from 'vue-router'
import router from './router'
// import VueMask from 'v-mask'

import { VueMaskDirective } from "v-mask";
Vue.directive("mask", VueMaskDirective);


Vue.use(BootstrapVue, IconsPlugin, VueAxios, axios, VueRouter)
// Vue.use(VueMask)

Vue.config.productionTip = false

new Vue({
  router,

  // router,
  render: h => h(App)
}).$mount('#app')
