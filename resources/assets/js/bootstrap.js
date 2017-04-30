const WebFont = require('webfontloader');
WebFont.load({
  google: {
    families: ['Fira Sans:300,400,700']
  }
});

// Require Lodash
window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

// Globals
const $ = jQuery = window.$ = window.jQuery = require('jquery');

const UIKit = require('uikit');
require('../../../node_modules/uikit/dist/js/components/lightbox');
require('../../../node_modules/uikit/dist/js/components/notify');
require('../../../node_modules/uikit/dist/js/components/tooltip');
require('../../../node_modules/uikit/dist/js/components/grid');
require('../../../node_modules/uikit/dist/js/components/accordion');

// Front End Deps
require('jquery-ujs');
require('typed.js');

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
