const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
if (!mix.inProduction()) {
	mix.webpackConfig({devtool: "source-map"});
}

mix.styles([
	'resources/css/global.css',
	'node_modules/jquery-typeahead/src/jquery.typeahead.css'
], 'public/css/global.css');
mix.js('resources/js/feed.js', 'public/js');
mix.js('resources/js/chat.js', 'public/js');
mix.js('resources/js/hash.js', 'public/js');
mix.js('resources/js/app.js', 'public/js')
	.extract(["jquery", "popper.js", "bootstrap", "socket.io-client", "laravel-echo", "jquery-typeahead", "mustache"]);
