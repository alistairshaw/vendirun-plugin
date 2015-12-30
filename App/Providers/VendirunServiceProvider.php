<?php namespace AlistairShaw\Vendirun\App\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Response;

class VendirunServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->loadViewsFrom(__DIR__.'/../../resources/views', 'vendirun');

		// use artisan vendor:publish to copy views to standard view folder
		// commented out since generally we don't want to publish all the views
		/*$this->publishes([
			__DIR__.'/../../resources/views' => base_path('resources/views/vendor/vendirun'),
		]);*/

		// use artisan vendor:publish to copy config
		$this->publishes([
			__DIR__.'/../../config/vendirun.php' => config_path('vendirun.php'),
		]);

		// use artisan vendor:publish to copy public assets
		// use artisan vendor:publish --tag=public --force   to force overwrite of assets tagged as "public"
		$this->publishes([
			__DIR__.'/../../public' => public_path('vendor/vendirun'),
		], 'public');

		// include my package custom routes
		include __DIR__.'/../../routes.php';

		// load translation files
		$this->loadTranslationsFrom(__DIR__.'/../../resources/lang', 'vendirun');
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->mergeConfigFrom(
			__DIR__.'/../../config/vendirun.php', 'vendirun'
		);

		// register providers we need
		$this->app->register('AlistairShaw\Vendirun\App\Providers\ComposerServiceProvider');
		$this->app->register('Illuminate\Html\HtmlServiceProvider');

		// aliases
		$loader = AliasLoader::getInstance();
		$loader->alias('Form', 'Illuminate\Html\FormFacade');
		$loader->alias('HTML', 'Illuminate\Html\HtmlFacade');
	}
}
