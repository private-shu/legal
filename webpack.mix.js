const mix = require('laravel-mix');
const CompressionPlugin = require('compression-webpack-plugin'); //サイズ圧縮するため
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

mix.js('resources/js/app.js', 'public/js')
    .js('resources/fontawesome/js/all.js', 'public/fontawesome/js')
    .sass('resources/sass/app.scss', 'public/css')
    // .sass('resources/fontawesome/css/all.css', 'public/fontawesome/css')
    .copyDirectory('resources/fontawesome/webfonts', 'public/fontawesome/webfonts')
    .sourceMaps();

mix.webpackConfig({
    stats: {
        children: true,
    },
    plugins: [
        new CompressionPlugin({
          filename: '[path].gz[query]',
          algorithm: 'gzip',
          test: /\.js$|\.css$|\.html$|\.svg$/,
          threshold: 10240,
          minRatio: 0.8,
        })
    ],
});