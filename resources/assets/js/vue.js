window.onload = () => {
    Vue.component('gallery', require('./components/gallery.vue'));
    const app = new Vue({
        el: '#vue'
    });
};