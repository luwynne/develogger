require('./bootstrap');
window.Vue = require('vue');

import Vue from 'vue'
import VueRouter from 'vue-router'
let App = require('./components/App.vue');
let Domain = require('./components/Domain.vue');
let Log = require('./components/Log.vue');

Vue.use(VueRouter);

const routes = [ 

    { path: '/', redirect: '/Domain' },
    {path:'/Domain',component: Domain},
    {path:'/Log',component: Log}

  ];

  const router = new VueRouter({
    routes: routes,
  })


const app = new Vue({
    el: '#app',
    router: router,
    components:{App,Domain,Log}
});
