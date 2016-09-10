<?php namespace AlistairShaw\Vendirun\App\Providers;

use AlistairShaw\Vendirun\App\Lib\CurrencyHelper;
use AlistairShaw\Vendirun\App\Lib\LocaleHelper;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

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

        // this publishes the error views
        $this->publishes([
            __DIR__.'/../../resources/views/errors' => base_path('resources/views/errors'),
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
		$this->app->register('AlistairShaw\Vendirun\App\Providers\EventServiceProvider');

        // middleware
        $this->app['router']->middleware('localization', 'AlistairShaw\Vendirun\App\Http\Middleware\Localization');

        // helpers
        $this->app->bind('LocaleHelper', function()
        {
            return new LocaleHelper();
        });

        $this->app->bind('LocaleHelper', function()
        {
            return new CurrencyHelper();
        });

        // dependency injection
        $this->app->bind('AlistairShaw\Vendirun\App\Lib\Social\SocialLinks', 'AlistairShaw\Vendirun\App\Lib\Social\SocialLinksStandard');
        $this->app->bind('AlistairShaw\Vendirun\App\Entities\Cart\CartRepository', 'AlistairShaw\Vendirun\App\Entities\Cart\ApiCartRepository');
        $this->app->bind('AlistairShaw\Vendirun\App\Entities\Order\OrderRepository', 'AlistairShaw\Vendirun\App\Entities\Order\ApiOrderRepository');
        $this->app->bind('AlistairShaw\Vendirun\App\Entities\Customer\CustomerRepository', 'AlistairShaw\Vendirun\App\Entities\Customer\ApiCustomerRepository');
        $this->app->bind('AlistairShaw\Vendirun\App\Entities\Product\ProductRepository', 'AlistairShaw\Vendirun\App\Entities\Product\ApiProductRepository');
        $this->app->bind('AlistairShaw\Vendirun\App\Entities\Product\ProductCategory\ProductCategoryRepository', 'AlistairShaw\Vendirun\App\Entities\Product\ProductCategory\ApiProductCategoryRepository');

		// aliases
		$loader = AliasLoader::getInstance();
		$loader->alias('LocaleHelper', 'AlistairShaw\Vendirun\App\Lib\LocaleHelper');
		$loader->alias('CurrencyHelper', 'AlistairShaw\Vendirun\App\Lib\CurrencyHelper');
		$loader->alias('CountryHelper', 'AlistairShaw\Vendirun\App\Lib\CountryHelper');
		$loader->alias('ClientHelper', 'AlistairShaw\Vendirun\App\Lib\ClientHelper');
		$loader->alias('TaxCalculator', 'AlistairShaw\Vendirun\App\Entities\Cart\Helpers\TaxCalculator');
		$loader->alias('CustomerHelper', 'AlistairShaw\Vendirun\App\Entities\Customer\Helpers\CustomerHelper');
	}
}
