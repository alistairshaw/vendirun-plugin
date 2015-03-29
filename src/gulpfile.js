var elixir = require('laravel-elixir');
var gulp = require("gulp");
var shell = require("gulp-shell");

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.sass('main.scss');
	mix.task('publish_assets', ['resources/assets/**/*.scss', 'resources/assets/**/*.js']);
});

gulp.task('publish_assets', function() {
	setTimeout(function() {
		shell.task([
			"php ../../../../artisan vendor:publish --tag=public --force"
		]);
	}, 2000);
});