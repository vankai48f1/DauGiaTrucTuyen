const mix = require('laravel-mix');

mix.setPublicPath('public');
mix.setResourceRoot('../');

// Backend JS/CSS
mix.js('resources/js/app.js', 'public/js');
mix.js('resources/js/language.js', 'public/js');

mix.sass('resources/sass/app.scss','public/css');
mix.sass('resources/sass/components/core/menu-builder.scss', 'public/css');
