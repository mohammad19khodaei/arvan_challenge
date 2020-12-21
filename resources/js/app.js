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

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('app', require('./components/App.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router
});
