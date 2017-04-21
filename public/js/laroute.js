(function () {

    var laroute = (function () {

        var routes = {

            absolute: false,
            rootUrl: 'https://irony.fsociety.guru',
            routes : [{"host":null,"methods":["GET","HEAD"],"uri":"\/","name":"home","action":"Fsociety\Http\Controllers\HomeController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"chat","name":"chat","action":"Fsociety\Http\Controllers\HomeController@chat"},{"host":null,"methods":["GET","HEAD"],"uri":"gallery","name":"gallery","action":"Fsociety\Http\Controllers\HomeController@gallery"},{"host":null,"methods":["GET","HEAD"],"uri":"links\/{search?}","name":"links","action":"Fsociety\Http\Controllers\HomeController@links"},{"host":null,"methods":["GET","HEAD"],"uri":"channel\/{channel}\/{nick?}","name":"channel","action":"Fsociety\Http\Controllers\HomeController@channel"},{"host":null,"methods":["GET","HEAD"],"uri":"channels","name":"irc-channels","action":"Fsociety\Http\Controllers\HomeController@ircChannels"},{"host":null,"methods":["GET","HEAD"],"uri":"watch-youtube","name":"watch-youtube","action":"Fsociety\Http\Controllers\HomeController@watchYoutube"},{"host":null,"methods":["GET","HEAD"],"uri":"episodes","name":"episodes","action":"Fsociety\Http\Controllers\EpisodeController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"episodes\/season\/{season}","name":"season","action":"Fsociety\Http\Controllers\EpisodeController@season"},{"host":null,"methods":["GET","HEAD"],"uri":"episodes\/show\/{slug}","name":"episode","action":"Fsociety\Http\Controllers\EpisodeController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"arg\/capture\/{arg}","name":"arg.capture","action":"Fsociety\Http\Controllers\ArgController@capture"},{"host":null,"methods":["PATCH"],"uri":"arg\/watch\/{arg}","name":"arg.watch","action":"Fsociety\Http\Controllers\ArgController@watch"},{"host":null,"methods":["POST"],"uri":"arg\/connect\/{arg}","name":"arg.connect","action":"Fsociety\Http\Controllers\ArgController@connect"},{"host":null,"methods":["GET","HEAD"],"uri":"arg","name":"arg.index","action":"Fsociety\Http\Controllers\ArgController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"arg\/create","name":"arg.create","action":"Fsociety\Http\Controllers\ArgController@create"},{"host":null,"methods":["POST"],"uri":"arg","name":"arg.store","action":"Fsociety\Http\Controllers\ArgController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"arg\/{arg}","name":"arg.show","action":"Fsociety\Http\Controllers\ArgController@show"},{"host":null,"methods":["GET","HEAD"],"uri":"arg\/{arg}\/edit","name":"arg.edit","action":"Fsociety\Http\Controllers\ArgController@edit"},{"host":null,"methods":["PUT","PATCH"],"uri":"arg\/{arg}","name":"arg.update","action":"Fsociety\Http\Controllers\ArgController@update"},{"host":null,"methods":["DELETE"],"uri":"arg\/{arg}","name":"arg.destroy","action":"Fsociety\Http\Controllers\ArgController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"login","name":"login","action":"Fsociety\Http\Controllers\Auth\LoginController@showLoginForm"},{"host":null,"methods":["POST"],"uri":"login","name":null,"action":"Fsociety\Http\Controllers\Auth\LoginController@login"},{"host":null,"methods":["POST"],"uri":"logout","name":null,"action":"Fsociety\Http\Controllers\Auth\LoginController@logout"},{"host":null,"methods":["GET","HEAD"],"uri":"auth\/github","name":null,"action":"Fsociety\Http\Controllers\Auth\GithubController@redirectToProvider"},{"host":null,"methods":["GET","HEAD"],"uri":"auth\/github\/callback","name":null,"action":"Fsociety\Http\Controllers\Auth\GithubController@handleProviderCallback"},{"host":null,"methods":["GET","HEAD"],"uri":"register","name":"register","action":"Fsociety\Http\Controllers\Auth\RegisterController@showRegistrationForm"},{"host":null,"methods":["POST"],"uri":"register","name":null,"action":"Fsociety\Http\Controllers\Auth\RegisterController@register"},{"host":null,"methods":["GET","HEAD"],"uri":"password\/reset","name":"reset","action":"Fsociety\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm"},{"host":null,"methods":["POST"],"uri":"password\/email","name":null,"action":"Fsociety\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail"},{"host":null,"methods":["GET","HEAD"],"uri":"password\/reset\/{token}","name":"form","action":"Fsociety\Http\Controllers\Auth\ResetPasswordController@showResetForm"},{"host":null,"methods":["POST"],"uri":"password\/reset","name":null,"action":"Fsociety\Http\Controllers\Auth\ResetPasswordController@reset"},{"host":null,"methods":["GET","HEAD"],"uri":"api\/user","name":null,"action":"Closure"}],
            prefix: '',

            route : function (name, parameters, route) {
                route = route || this.getByName(name);

                if ( ! route ) {
                    return undefined;
                }

                return this.toRoute(route, parameters);
            },

            url: function (url, parameters) {
                parameters = parameters || [];

                var uri = url + '/' + parameters.join('/');

                return this.getCorrectUrl(uri);
            },

            toRoute : function (route, parameters) {
                var uri = this.replaceNamedParameters(route.uri, parameters);
                var qs  = this.getRouteQueryString(parameters);

                if (this.absolute && this.isOtherHost(route)){
                    return "//" + route.host + "/" + uri + qs;
                }

                return this.getCorrectUrl(uri + qs);
            },

            isOtherHost: function (route){
                return route.host && route.host != window.location.hostname;
            },

            replaceNamedParameters : function (uri, parameters) {
                uri = uri.replace(/\{(.*?)\??\}/g, function(match, key) {
                    if (parameters.hasOwnProperty(key)) {
                        var value = parameters[key];
                        delete parameters[key];
                        return value;
                    } else {
                        return match;
                    }
                });

                // Strip out any optional parameters that were not given
                uri = uri.replace(/\/\{.*?\?\}/g, '');

                return uri;
            },

            getRouteQueryString : function (parameters) {
                var qs = [];
                for (var key in parameters) {
                    if (parameters.hasOwnProperty(key)) {
                        qs.push(key + '=' + parameters[key]);
                    }
                }

                if (qs.length < 1) {
                    return '';
                }

                return '?' + qs.join('&');
            },

            getByName : function (name) {
                for (var key in this.routes) {
                    if (this.routes.hasOwnProperty(key) && this.routes[key].name === name) {
                        return this.routes[key];
                    }
                }
            },

            getByAction : function(action) {
                for (var key in this.routes) {
                    if (this.routes.hasOwnProperty(key) && this.routes[key].action === action) {
                        return this.routes[key];
                    }
                }
            },

            getCorrectUrl: function (uri) {
                var url = this.prefix + '/' + uri.replace(/^\/?/, '');

                if ( ! this.absolute) {
                    return url;
                }

                return this.rootUrl.replace('/\/?$/', '') + url;
            }
        };

        var getLinkAttributes = function(attributes) {
            if ( ! attributes) {
                return '';
            }

            var attrs = [];
            for (var key in attributes) {
                if (attributes.hasOwnProperty(key)) {
                    attrs.push(key + '="' + attributes[key] + '"');
                }
            }

            return attrs.join(' ');
        };

        var getHtmlLink = function (url, title, attributes) {
            title      = title || url;
            attributes = getLinkAttributes(attributes);

            return '<a href="' + url + '" ' + attributes + '>' + title + '</a>';
        };

        return {
            // Generate a url for a given controller action.
            // laroute.action('HomeController@getIndex', [params = {}])
            action : function (name, parameters) {
                parameters = parameters || {};

                return routes.route(name, parameters, routes.getByAction(name));
            },

            // Generate a url for a given named route.
            // laroute.route('routeName', [params = {}])
            route : function (route, parameters) {
                parameters = parameters || {};

                return routes.route(route, parameters);
            },

            // Generate a fully qualified URL to the given path.
            // laroute.route('url', [params = {}])
            url : function (route, parameters) {
                parameters = parameters || {};

                return routes.url(route, parameters);
            },

            // Generate a html link to the given url.
            // laroute.link_to('foo/bar', [title = url], [attributes = {}])
            link_to : function (url, title, attributes) {
                url = this.url(url);

                return getHtmlLink(url, title, attributes);
            },

            // Generate a html link to the given route.
            // laroute.link_to_route('route.name', [title=url], [parameters = {}], [attributes = {}])
            link_to_route : function (route, title, parameters, attributes) {
                var url = this.route(route, parameters);

                return getHtmlLink(url, title, attributes);
            },

            // Generate a html link to the given controller action.
            // laroute.link_to_action('HomeController@getIndex', [title=url], [parameters = {}], [attributes = {}])
            link_to_action : function(action, title, parameters, attributes) {
                var url = this.action(action, parameters);

                return getHtmlLink(url, title, attributes);
            }

        };

    }).call(this);

    /**
     * Expose the class either via AMD, CommonJS or the global object
     */
    if (typeof define === 'function' && define.amd) {
        define(function () {
            return laroute;
        });
    }
    else if (typeof module === 'object' && module.exports){
        module.exports = laroute;
    }
    else {
        window.laroute = laroute;
    }

}).call(this);

