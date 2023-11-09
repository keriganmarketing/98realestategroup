const mix = require("laravel-mix")

mix.options({
    postCss: [
        require('autoprefixer')({
            grid: true,
            browsers: ['last 2 versions']
        })
    ]
});

mix
    .setResourceRoot("../")
    .setPublicPath("./")
    .sass('sass/style.scss', '')
    .js('js/app.js', '')
    .vue()
    .sourceMaps()
    .version()
