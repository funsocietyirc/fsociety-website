const vue = require('vue');
const vueLazyLoad = require('vue-lazyload');

window.onload = () => {
    // Vue
    window.Vue = vue;

    // Vue  image loader
    Vue.use(vueLazyLoad, {
        preLoad: 1.3,
        error: '/images/gallery-error.jpg',
        loading: '/images/gallery-loader.gif',
        attempt: 1
    });

    // Vue resource
    require('vue-resource');

    // Vue X-CSRF-TOKEN
    Vue.http.interceptors.push((request, next) => {
        request.headers['X-CSRF-TOKEN'] = document.querySelector("meta[name='csrf-token']").getAttribute('content');
        next();
    });

    Vue.component('gallery', require('./components/gallery.vue'));
    Vue.component('links', require('./components/links.vue'));
    Vue.component('alert', require('./components/alert.vue'));


    const app = new Vue({
        el: '#vue'
    });
};