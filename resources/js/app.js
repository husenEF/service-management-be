
require('./bootstrap');
// window.Vue = require('vue');

import Vue from 'vue'
import VueRouter from 'vue-router'
import Vuex from 'vuex'

import { routes } from "./routes"
import MainApp from './components/MainApp.vue'


Vue.use(VueRouter)
Vue.use(Vuex)

const router = new VueRouter({
    routes,
    node: 'history'
})

const app = new Vue({
    el: '#app',
    router,
    components: {
        MainApp,
    }
});
