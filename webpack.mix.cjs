const mix = require("laravel-mix");

mix.js("resources/js/app.js", "public/backend/assets/js")
    .css("resources/css/app.css", "public/backend/assets/css")
    .styles(
        [
            "node_modules/filepond/dist/filepond.css",
            "node_modules/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css",
        ],
        "public/backend/assets/css/filepond.css"
    )
    .styles(
        ["node_modules/summernote/dist/summernote-bs5.css"],
        "public/backend/assets/css/summernote.css"
    )
    .copy("node_modules/summernote/dist/font", "public/backend/assets/css/font")
    .copy("node_modules/summernote/dist/lang/summernote-vi-VN.js", "public/backend/assets/css/lang")
    .webpackConfig({
        resolve: {
            alias: {
                jquery: require.resolve("jquery"),
            },
        },
    })
    .version();
