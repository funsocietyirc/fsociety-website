window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

// Globals
const $ = jQuery = window.$ = window.jQuery = require('jquery');
const token = document.querySelector("meta[name='csrf-token']").getAttribute('content');

// Front End Deps
require('jquery-ujs');
require('uikit');
require('typed.js');
require('slick-carousel');

// Vue
window.Vue = require('vue');

// Vue resource
require('vue-resource');

// Vue X-CSRF-TOKEN
Vue.http.interceptors.push((request, next) => {
    request.headers['X-CSRF-TOKEN'] = token;
    next();
});

// Pusher
const Pusher = require('pusher-js');
window.socket = new Pusher('9d0bcd17badf5ab7cc79', {
    encrypted: true,
    auth: {
        headers: { "X-CSRF-Token": token }
    }
});

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from "laravel-echo"
//
// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: '9d0bcd17badf5ab7cc79'
// });
