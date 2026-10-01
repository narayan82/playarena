// Load Gulp...of course
const { src, dest, task, watch, series, parallel } = require("gulp");
var log = require("fancy-log");
// CSS related plugins
var sass = require("gulp-sass")(require("sass"));
var autoprefixer = require("gulp-autoprefixer");

// JS related plugins
var uglify = require("gulp-uglify");
var babelify = require("babelify");
var browserify = require("browserify");
var source = require("vinyl-source-stream");
var buffer = require("vinyl-buffer");
var stripDebug = require("gulp-strip-debug");

// Utility plugins
var rename = require("gulp-rename");
var sourcemaps = require("gulp-sourcemaps");
var notify = require("gulp-notify");
var plumber = require("gulp-plumber");
var options = require("gulp-options");
var gulpif = require("gulp-if");
var wait = require("gulp-wait");

// Browers related plugins
var browserSync = require("browser-sync").create();

// Project related variables
var styleSRC = "./scss/**/*.scss";
var styleURL = "./css/";
var mapURL = "./css/";

var styleWatch = "./scss/**/*.scss";
var jsWatch = "./js/**/*.js";
var imgWatch = "./img/**/*.*";
var fontsWatch = "./fonts/**/*.*";
var htmlWatch = "./**/*.html";
var phpWatch = "./**/*.php";

var blockWatch = "./blocks/**/scss/*.scss";
var blockSRC = "./blocks/**/scss/*.scss";

// Tasks
function browser_sync() {
  browserSync.init({
    open: false,
    port: 8000,
    https: true,
    host: "dev.matsio.com",
  });
}

function reload(done) {
  browserSync.reload();
  done();
}

function css(done) {
  src([styleSRC])
    .pipe(sourcemaps.init())
    .pipe(
      sass({
        errLogToConsole: true,
        outputStyle: "compressed",
      })
    )
    .on("error", console.error.bind(console))
    .pipe(autoprefixer())
    .pipe(
      rename(function (path) {
        if (path.dirname != ".") {
          path.dirname = path.dirname.replace("/", "-");
          path.basename = path.dirname + "-" + path.basename;
          path.dirname = ".";
        }
        path.extname = ".min.css";
      })
    )
    .pipe(sourcemaps.write(mapURL))
    .pipe(dest(styleURL))
    .pipe(browserSync.stream())
    .pipe(wait(1500));
  done();
}

function blocks(done) {
  var blockURL = "/blocks/dir.pathname/css/";
  src([blockSRC])
    .pipe(sourcemaps.init())
    .pipe(
      sass({
        errLogToConsole: true,
        outputStyle: "compressed",
      })
    )
    .on("error", console.error.bind(console))
    .pipe(autoprefixer())
    .pipe(
      rename(function (path) {
        if (path.dirname != ".") {
          path.dirname = blockURL.replace("dir.pathname", path.dirname);
          path.dirname = path.dirname.replace("/scss", "");
        }
        path.extname = ".min.css";
      })
    )
    .pipe(sourcemaps.write(mapURL))
    .pipe(dest("."))
    .pipe(browserSync.stream())
    .pipe(wait(1500));
  done();
}

function triggerPlumber(src_file, dest_file) {
  return src(src_file).pipe(plumber()).pipe(dest(dest_file));
}

function watch_files() {
  watch(styleWatch, series(css, reload));
  watch(jsWatch, series(reload));
  watch(imgWatch, reload);
  watch(fontsWatch, reload);
  watch(htmlWatch, reload);
  watch(phpWatch, reload);
  watch(blockWatch, series(blocks, reload));
}

task("css", parallel(css, blocks));
task("blocks", blocks);
task("default", parallel(css));
task("watch", parallel(browser_sync, watch_files));
