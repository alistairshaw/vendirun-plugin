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

elixir(function (mix) {
	mix.sass('main.scss', 'resources/css');

	mix.styles([
		'../bower_components/font-awesome/css/font-awesome.css',
		'../bower_components/lightbox/css/lightbox.css',
		'../bower_components/select2/select2.css',
		'../bower_components/nivoslider/nivo-slider.css',
		'main.css'
	], 'public/css/production.css');

	mix.scripts([
			'../bower_components/jquery/dist/jquery.js',
			'../bower_components/jquery.smooth-scroll/jquery.smooth-scroll.js',
			'../bower_components/bootstrap-sass/assets/javascripts/bootstrap.js',
			'../bower_components/lightbox/js/lightbox.js',
			'../bower_components/select2/select2.js',
			'../bower_components/nivoslider/jquery.nivo.slider.js',
			'sliders.js',
			'main.js'
		], 'public/js/production.js');

	mix.task('publish_assets', ['public/**/*.css', 'public/**/*.js']);

	if (elixir.config.production)
	{
		mix.copy('resources/bower_components/font-awesome/fonts', 'public/fonts');
		mix.copy('resources/bower_components/select2/*.png', 'public/css');
		mix.copy('resources/bower_components/lightbox/img', 'public/img');
	}
});

gulp.task('publish_assets', shell.task([
	"php ../../../../artisan vendor:publish --tag=public --force"
]));