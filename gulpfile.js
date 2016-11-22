const elixir = require('laravel-elixir');
require('laravel-elixir-webpack-official');
require('laravel-elixir-vue-2');

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
        .webpack('app.js')
        .webpack('vue.js')
        // Hack until I figure buble thing out
        .copy('node_modules/vue-infinite-loading/dist/vue-infinite-loading.js', 'public/js/infinite.js')
        .less('uk.less','public/css/uikit.css')
        .version([
            'css/app.css','css/uikit.css','js/app.js','js/vue.js'
        ]);
});
