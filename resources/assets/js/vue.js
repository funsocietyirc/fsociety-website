const vue = require('vue');
const vueLazyLoad = require('vue-lazyload');
const vueFilter = require('vue-filter');
const mintUI = require('mint-ui');
// Vue
const Vue = window.Vue = vue;

// Vue  image loader
Vue.use(vueLazyLoad, {
    preLoad: 1.3,
    error: '/images/gallery-error.jpg',
    loading: '/images/gallery-loader.gif',
    attempt: 1
});

// Vue Filters
Vue.use(vueFilter);

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

Vue.filter('Capitalize', function(value) {
    if(!value) return;
    return _.capitalize(value);
});

Vue.filter('uppercase', function(value) {
    if(!value) return;
    return _.toUpper(value);
});


window.onload = () => {
    const app = new Vue({
        el: '#vue'
    });
};