import Vue from 'vue'
import App from './App.vue'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

import axios from 'axios'
import VueAxios from 'vue-axios'

import VueRouter from 'vue-router'
import router from './router'

import mask from 'vuejs-mask'
Vue.use(mask)

Vue.use(BootstrapVue, IconsPlugin, VueAxios, axios, VueRouter)

Vue.config.productionTip = false

new Vue({
  router,

  render: h => h(App)
}).$mount('#app')
