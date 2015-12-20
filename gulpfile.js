var elixir = require('laravel-elixir'),
    elixirClear = require('laravel-elixir-clear'),
    gzip = require('gulp-gzip'),
    rename = require('concur-gulp-rename'),
    webpack = require('webpack-stream')
    ;
var dust = require('gulp-dust');
var Task = elixir.Task;
elixir.config.sourcemaps = false;
elixir.config.versioning.buildFolder = "/";

var gulp = require("gulp");

process.env.NODE_ENV = process.env.NODE_ENV || "development";

gulp.task('copy', function () {
    console.log("begin copy task......");
    return [
        gulp.src("./resources/assets/images/**/*")
        .pipe(gulp.dest('public/assets/images')),
        gulp.src("./resources/templates/**/*.dust")
        .pipe(gulp.dest('public/assets/templates'))
    ];
});

gulp.task('watch-webpack', function() {
    console.log("begin watch webpack task......");
   return [
       gulp.watch(['./resources/assets/images/**', './resources/templates/**/*.dust'], ['copy'], function(event) {
           console.log('File ' + event.path + ' was ' + event.type + ', running tasks...');
       }),
       gulp.watch(['./resources/assets/!(vendor)/**/!(_)*.js', './resources/assets/!(vendor)/**/!(_)*.scss'], ['webpack'], function(event) {
           console.log('File ' + event.path + ' was ' + event.type + ', running tasks...');
       })
   ]
});

gulp.task('webpack', function () {
    console.log("begin webpack task......");
    return [
        gulp.src("webpack.config.js")
        .pipe(webpack(require('./webpack.config.js'), require('webpack')))
        .pipe(gulp.dest('public/assets/webpack'))
    ];
});

gulp.task('build', ['webpack', 'copy']);

gulp.task('build-gz', ['build'], function () {
    console.log("begin build-gz task......");
    return gulp.src('public/**/!(*.gz|*.png|*.jpg|*.jpeg|*.svg)') // png and jpg already very well compressed, might even make it larger
        .pipe(require('gulp-size')({showFiles: true}))
        .pipe(gzip({gzipOptions: {level: 9}}))
        .pipe(rename({extname: ".gz"}))
        .pipe(require('gulp-size')({showFiles: true}))
        .pipe(gulp.dest('public/assets/webpack'));
});

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.clear(["public/assets/images/**", "public/assets/webpack/**", "public/assets/**/*.gz"]);
    mix.task('build');
    mix.task('watch-webpack');
});
