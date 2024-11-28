// webpack.mix.cjs
const mix = require('laravel-mix');

mix.js('resources/js/frontend.js', 'public/js')
   .css('resources/css/frontend.css', 'public/css');

