/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

import App from './App.vue';
import VueAxios from 'vue-axios';
import VueRouter from 'vue-router';
import axios from 'axios';
import router from './Router/index';
import store from './Store/index';
import mixin from './Mixins/index';
import DefaultLayout from './layout/DefaultLayout';
import TheFooter from './global/TheFooter';
// import { routes } from './Router/routes';
axios.interceptors.response.use(function(response) {
    console.log("my response interceptor")
    return response
}, function(error) {
    // const { config, response: { status } } = error
    const { config, response } = error
    const originalRequest = config
    if (response && response.status === 401) {
        //notication or redirection
        // this.$vs.notify({
        //     title: 'Error',
        //     text: response.data['message'],
        //     iconPack: 'feather',
        //     icon: 'icon-check-circle',
        //     color: 'danger'
        // })
    }
    return Promise.reject(error)
});

function getToken() {
    return localStorage.getItem("access_token");
}
axios.interceptors.request.use(req => {
    // `req` is the Axios request config, so you can modify
    // the `headers`.
    const token = getToken();
    if (!router.currentRoute.path.includes("/pages/login")) {
        console.log("my request interceptor ==>> ", localStorage.getItem("access_token"))
        req.headers.authorization = "Bearer " + localStorage.getItem("access_token");
        return req;
    }
});
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.component("default-layout", DefaultLayout);
Vue.component("the-footer", TheFooter);
Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.use(VueRouter);
Vue.use(VueAxios, axios);
Vue.mixin(mixin);

// const router = new VueRouter({
//     mode: 'history',
//     routes: routes
// });

const app = new Vue({
    el: '#app',
    router,
    store,
    render: h => h(App),
});