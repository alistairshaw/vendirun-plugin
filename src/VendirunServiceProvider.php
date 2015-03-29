<?php namespace Ambitiousdigital\Vendirun;

use Illuminate\Support\ServiceProvider;

class VendirunServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->loadViewsFrom(__DIR__.'/resources/views', 'vendirun');

		// use artisan vendor:publish to copy views to standard view folder
		$this->publishes([
			__DIR__.'/resources/views' => base_path('resources/views/vendor/vendirun'),
		]);

		// use artisan vendor:publish to copy config
		$this->publishes([
			__DIR__.'/config/vendirun.php' => config_path('vendirun.php'),
		]);

		// use artisan vendor:publish to copy public assets
		// use artisan vandor:publish --tag=public --force   to force overwrite of assets tagged as "public"
		$this->publishes([
			__DIR__.'/public' => public_path('vendor/vendirun'),
		], 'public');

		// include my package custom routes
		include __DIR__.'/routes.php';
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->mergeConfigFrom(
			__DIR__.'/config/vendirun.php', 'vendirun'
		);
	}

}
