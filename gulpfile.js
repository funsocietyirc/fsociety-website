const elixir = require('laravel-elixir');

require('laravel-elixir-vue');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(mix => {
    mix.sass('app.scss','public/css/app.css')
        .copy('node_modules/uikit/dist/fonts','public/fonts')
        .copy('node_modules/slick-carousel/slick/fonts','public/fonts')
        .copy('node_modules/slick-carousel/slick/*.gif','public/images')
        .webpack('app.js')
        .webpack('vu.js')
        .less('uk.less','public/css/uikit.css')
        .version([
            'css/app.css','css/uikit.css','js/app.js','js/vu.js'
        ]);
});
