const dotenvExpand = require("dotenv-expand");
dotenvExpand(
    require("dotenv").config({ path: "../../.env" /*, debug: true*/ })
);

const mix = require("laravel-mix");
require("laravel-mix-merge-manifest");

mix.setPublicPath("../../public").mergeManifest();

mix.sass(
        __dirname + "/Resources/assets/sass/app.scss",
        "modules/Entertainment/style.css"
    );

if (mix.inProduction()) {
    mix.version();
}
