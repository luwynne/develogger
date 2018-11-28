require('./bootstrap');
window.Vue = require('vue');

import Vue from 'vue'
import VueRouter from 'vue-router'
let App = require('./components/App.vue');
let Domain = require('./components/Domain.vue');
let Log = require('./components/Log.vue');
let EditLog = require('./components/EditLog.vue');
let AddLog = require('./components/AddLog.vue');

Vue.use(VueRouter);

const routes = [ 

    { path: '/', redirect: '/Domain' },
    {path:'/Domain',component: Domain},
    {path:'/Log',component: Log},
    {
      name: 'EditLog',
      path: '/edit-log/:id',
      component: EditLog
    },
    {
      name: 'AddLog',
      path: '/addlog',
      component: AddLog
    },

  ];

  const router = new VueRouter({
    routes: routes,
  })


const app = new Vue({
    el: '#app',
    router: router,
    components:{App,Domain,Log,EditLog,AddLog}
});
