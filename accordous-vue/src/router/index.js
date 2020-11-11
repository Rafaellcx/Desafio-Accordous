import Vue from 'vue'
import VueRouter from 'vue-router'
// import Home from '../views/Home.vue'

import CadastrarContrato from '../pages/CadastrarContrato.vue'
import Contrato from '../pages/Contrato.vue'
import CadastrarPropriedade from '../pages/CadastrarPropriedade.vue'
import Inicio from '../pages/Inicio.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Inicio
  },
  {
    path: '/cadastrarpropriedade',
    name: 'CadastrarPropriedade',
    component: CadastrarPropriedade
  },
  {
    path: '/inicio',
    name: 'Início',
    component: Inicio
  },
  {
    path: '/cadastrarcontrato/:id/:enderecoCompleto',
    name: 'Cadastrar Contrato',
    component: CadastrarContrato
  },
  {
    path: '/contrato/:id/:enderecoCompleto',
    name: 'Contrato',
    component: Contrato
  },
  {
    path: '/about',
    name: 'About',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "about" */ '../views/About.vue')
  }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
