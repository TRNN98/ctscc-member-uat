const mix = require("laravel-mix");
require("laravel-mix-polyfill");
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
const RemovePlugin = require("remove-files-webpack-plugin");
const TargetsPlugin = require("targets-webpack-plugin");

const removePlugin = new RemovePlugin({
    before: {
        test: [
            {
                folder: "public",
                method: filePath => {
                    return new RegExp(
                        /(?:.*\.js|.*\.map|mix-manifest\.json)$/,
                        "m"
                    ).test(filePath);
                }
            },
            {
                folder: "public/js",
                method: filePath => {
                    return new RegExp(/(?:.*\.js|.*\.map)$/, "m").test(
                        filePath
                    );
                },
                recursive: true
            },
            {
                folder: "public/css",
                method: filePath => {
                    return new RegExp(/(?:.*\.css|.*\.map)$/, "m").test(
                        filePath
                    );
                }
            }
        ]
    },

    after: {}
});

mix.webpackConfig({
    plugins: [
        removePlugin,
        new TargetsPlugin({
            browsers: ["last 2 versions", "chrome >= 41", "IE 11", "IE 7"]
        })
    ],

    node: {
        fs: "empty"
    }
});

mix.react("resources/js/app.js", "public/js")
    .sass("resources/sass/app.scss", "public/css")
    .styles(["resources/css/info/style.css"], "public/css/info.css")
    .styles(["resources/css/member/app.css"], "public/css/member.css")
    // .scripts([
    //     'public/js/admin.js',
    //     'public/js/dashboard.js'
    // ], 'public/js/info.js')
    .disableNotifications()
    .sourceMaps(false, "source-map")
    .version()
    .polyfill({
        enabled: true,
        useBuiltIns: "usage",
        targets: { firefox: "50", ie: 11 }
    });
