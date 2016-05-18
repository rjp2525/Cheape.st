var gulp = require('gulp');
var browserify = require('browserify');
var source = require('vinyl-source-stream');
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');
var plumber = require('gulp-plumber');

gulp.task('scss', function() {
	gulp.src('./resources/assets/sass/app.scss')
		.pipe(plumber({
		  errorHandler: function(error) {
		    console.log(error.message);
		    this.emit('end')
		  }
		}))
		.pipe(sass())
		.pipe(autoprefixer('last 2 versions'))
		.pipe(gulp.dest('./public/css'));
});

gulp.task('lib', function() {
	return gulp.src('./node_modules/jquery/dist/jquery.min.js')
		.pipe(gulp.dest('./public/js'))
})

gulp.task('js', function() {
    return browserify('./resources/assets/js/app.js')
        .bundle()
        .pipe(source('app.js'))
        .pipe(gulp.dest('./public/js'));
});

gulp.task('views', function() {
	return gulp.src('./resources/assets/views/**/*.html')
		.pipe(gulp.dest('./public/views'));
});

gulp.task('default', ['scss', 'lib', 'js', 'views'], function() {
	gulp.watch('./resources/assets/sass/**/*.scss', ['scss']);
	gulp.watch('./resources/assets/js/**/*.js', ['js']);
	gulp.watch('./resources/assets/views/**/*.html', ['views']);
});