var gulp = require('gulp');
var sass = require('gulp-sass');
var sourcemaps = require('gulp-sourcemaps');
var uglify = require('gulp-uglify');
var pump = require('pump');
var autoprefixer = require('gulp-autoprefixer');
var babel = require('gulp-babel');

// compile SASS file to CSS with Compressed
gulp.task('sass', function(){
    return gulp.src('public/assets/dev/sass/*.scss')
            .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
            .pipe(autoprefixer())
            .pipe(gulp.dest('public/assets/build/css/'))
})

// genarate source map for the SASS file
gulp.task('sm', function(){
    return gulp.src('public/assets/dev/sass/*.scss')
            .pipe(sourcemaps.init())
            .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
            .pipe(autoprefixer())
            .pipe(sourcemaps.write('../maps'))
            .pipe(gulp.dest('public/assets/build/css/'))
})

// transpile ES6 code to ES5
gulp.task('transpile', function(){
    return gulp.src('public/assets/dev/js/*.js')
            .pipe(babel({presets: ['@babel/env']}))
            .pipe(gulp.dest('public/assets/dev/es5/'))
})

// uglify the JS file
gulp.task('script', ['transpile'], function(){
    pump([
        gulp.src('public/assets/dev/es5/*.js'),
        uglify(),
        gulp.dest('public/assets/build/js/')
    ])
});

// watch the sass and script task
gulp.task('watch', function(){
    gulp.watch('public/assets/dev/sass/**/*.scss', ['sass']);
    gulp.watch('public/assets/dev/js/**/*.js', ['script']);
});

// create a build task
gulp.task('build', ['sass', 'script']);