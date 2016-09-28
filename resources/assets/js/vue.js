window.onload = () => {
    // Vue
    window.Vue = require('vue');

    // Vue  image loader
    const vueLazyLoad = require('vue-lazyload');
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