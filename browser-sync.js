const browserSync = require("browser-sync").create();

browserSync.init({
    proxy: "http://localhost:10290",
    files: [
        "templates/**/*.twig",
        "assets/js/**/*.js",
        "assets/css/**/*.css",
        "src/**/*.php"
    ],
    port: 3000,
    open: true
});
