var gulp = require('gulp');
var autoprefixer = require('gulp-autoprefixer');
var less = require('gulp-less');
var path = require('path');
var useref = require('gulp-useref');
var uglify = require('gulp-uglify');
var gulpIf = require('gulp-if');
var cssnano = require('gulp-cssnano');

// Default task
gulp.task('default', ['css', 'js']);

// Watch
gulp.task('watch', function(){
    gulp.watch('content/less/**/*.less', ['less']);
    gulp.watch('content/js/**/*.js', ['js']);
});

// Styles
gulp.task('less', function(){
    return gulp.src('content/less/**/*.less')
        .pipe(less()) // Using gulp-less
        .pipe(autoprefixer({
            cascade: false
        }))
        .pipe(gulp.dest('content/css'))
});

gulp.task('useref', function(){
    return gulp.src('content/*.html')
        .pipe(useref())
        // Minifies only if it's a JavaScript file
        .pipe(gulpIf('*.js', uglify()))
        // Minifies only if it's a CSS file
        .pipe(gulpIf('*.css', cssnano()))
        .pipe(gulp.dest('dist'))
});