/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
import Toasted from 'vue-toasted';

Vue.use(VueRouter);
Vue.use(Toasted, {
    duration: 5000,
    position: 'top-center',
    action: {
        text: 'Okay',
        onClick: (e, toastObject) => {
            toastObject.goAway(0);
        }
    }
});

// routes
import addCode from './pages/AddCode';
import checkPhone from './pages/CheckPhone';
import codeList from './pages/CodeList';
import home from './pages/Home';

const routes = [
    { path: '/', component: home, name: 'home' },
    { path: '/code/add', component: addCode, name: 'addCode' },
    { path: '/phone/check', component: checkPhone, name: 'phoneCheck' },
    { path: '/winner/list', component: codeList, name: 'winnerList' }
]

const router = new VueRouter({
    routes
})

Vue.component('app', require('./components/App.vue').default);

const app = new Vue({
    el: '#app',
    router
});
