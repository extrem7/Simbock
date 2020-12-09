const mix = require('laravel-mix')
const config = require('./webpack.config')

require('laravel-mix-svg-vue')
require('laravel-mix-merge-manifest')

mix.webpackConfig({
    output: {chunkFilename: 'dist/js/chunks/[name].js?id=[chunkhash]'},
    ...config
})

mix.options({processCssUrls: false})

mix.sass('modules/Frontend/resources/scss/app.scss', 'public/dist/css').version().sourceMaps()

mix.copy('modules/Frontend/resources/layout/src/img', 'public/dist/img')

mix.copy('modules/Frontend/resources/layout/src/favicon', 'public/favicon')

mix.copy('modules/Frontend/resources/layout/src/fonts', 'public/dist/fonts')

mix.ts('modules/Frontend/resources/js/app.js', 'public/dist/js/').svgVue({
    svgPath: 'modules/Frontend/resources/layout/src/svg',
}).sourceMaps().version()

mix.mergeManifest()
