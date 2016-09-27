window.onload = () => {
    Vue.component('gallery', require('./components/gallery.vue'));
    Vue.component('links', require('./components/links.vue'));
    const app = new Vue({
        el: '#vue'
    });
};