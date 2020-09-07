const mix = require('laravel-mix')
const config = require('./webpack.config')

require('laravel-mix-svg-vue')
require('laravel-mix-merge-manifest')

mix.webpackConfig({
    output: {chunkFilename: 'admin/js/chunks/[name].js?id=[chunkhash]'},
    ...config
})

mix.options({processCssUrls: false})

mix.sass('modules/Admin/resources/scss/app.scss', 'public/admin/css').version().sourceMaps()

mix.js('modules/Admin/resources/js/app.js', 'public/admin/js').svgVue({svgPath: 'modules/Admin/resources/assets/svg'}).version().sourceMaps()

mix.copy('node_modules/pace-js/themes/blue/pace-theme-minimal.css', 'public/admin/css/pace.css')
mix.copy('node_modules/pace-js/pace.min.js', 'public/admin/js/pace.js')

mix.copy('modules/Admin/resources/assets/img', 'public/admin/img')

mix.copy('node_modules/@fortawesome/fontawesome-free/webfonts', 'public/admin/webfonts')

mix.mergeManifest()
