const elixir = require('laravel-elixir');


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
    Elixir.webpack.mergeConfig({
        // ensure we are using the version of Vue that supports templates
        resolve: {
            alias: {
                vue: 'vue/dist/vue.js'
            }
        },
        // use buble loader since it is the default in Elixir
        // vue: {
        //   loaders: {
        //     js: 'buble-loader'
        //   }
        // },
        module: {
            loaders: [
                {
                    test: /\.vue$/,
                    loader: 'vue-loader'
                },
                {
                    test: /\.(png|jpe?g|gif|svg)(\?.*)?$/,
                    loader: 'file-loader',
                    query: {
                        limit: 10000,
                        name: '../img/[name].[hash:7].[ext]'
                    }
                },
                {
                    test: /\.(woff2?|eot|ttf|otf)(\?.*)?$/,
                    loader: 'url-loader',
                    query: {
                        limit: 10000,
                        name: '../fonts/[name].[hash:7].[ext]'
                    }
                }
            ]
        }
    });

    mix.sass('app.scss','public/css/app.css')
        .copy('node_modules/uikit/dist/fonts','public/fonts')
        .copy('node_modules/slick-carousel/slick/fonts','public/fonts')
        .copy('node_modules/slick-carousel/slick/*.gif','public/images')
        .webpack('app.js')
        .webpack('vue.js')
        .less('uk.less','public/css/uikit.css')
        .version([
            'css/app.css','css/uikit.css','js/app.js','js/vue.js'
        ]);
});
