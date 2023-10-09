const { src, dest, watch, parallel } = require('gulp')
const sass = require('gulp-sass')(require('node-sass'))
const { readdir } = require('fs').promises
const { statSync } = require('fs')
const terser = require('gulp-terser')

const concat = require('gulp-concat')

function build (cb) {
  // place code for your default task here
  cb()
}

function compileSASS (cb) {
  src('./build/scss/styles.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(dest('./dist/assets/css/'))
  cb()
}

async function compileJS (cb) {
  src('./build/js/*.js')
    .pipe(concat('main.min.js'))
    .pipe(terser())
    .pipe(dest('dist/assets/js/'))

  const getDirList = async (dirName) => {
    const dirs = []
    const items = await readdir(dirName)

    for (const item of items) {
      if (statSync(`${dirName}/${item}`).isDirectory()) {
        dirs.push(item)
      }
    }

    return dirs
  }

  getDirList('./build/js/').then((dirs) => {
    dirs.forEach(dir => {
      src(`./build/js/${dir}/*.js`)
        .pipe(concat(`${dir}.min.js`))
      // .pipe(terser())
        .pipe(dest('dist/assets/js/'))
    })
  })
  cb()
}

exports.default = build
exports.css = compileSASS
exports.js = compileJS
exports.build = parallel(compileSASS, compileJS)

exports.default = function () {
  watch('./build/scss/**/*.scss', compileSASS)
  watch('./build/js/**/*.js', compileJS)
}
