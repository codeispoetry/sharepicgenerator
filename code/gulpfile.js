const { src, dest } = require("gulp");
const sass = require('gulp-sass')(require('node-sass'));

function build(cb) {
    // place code for your default task here
    cb();
}

function compileSASS(cb) {
    src('./build/scss/styles.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(dest('./dist/assets/css/'));
    cb();  
}

exports.default = build;
exports.css = compileSASS;
