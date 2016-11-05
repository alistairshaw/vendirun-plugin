<?php namespace AlistairShaw\Vendirun\App\Providers;

use AlistairShaw\Vendirun\App\Entities\Cart\ApiCartRepository;
use AlistairShaw\Vendirun\App\Entities\Cart\CartRepository;
use AlistairShaw\Vendirun\App\Entities\Cart\Helpers\TaxCalculator;
use AlistairShaw\Vendirun\App\Entities\Cart\Transformers\CartValuesTransformer;
use AlistairShaw\Vendirun\App\Entities\Cart\Transformers\CartValuesVATExcludedTransformer;
use AlistairShaw\Vendirun\App\Entities\Cart\Transformers\CartValuesVATIncludedTransformer;
use AlistairShaw\Vendirun\App\Entities\Customer\ApiCustomerRepository;
use AlistairShaw\Vendirun\App\Entities\Customer\CustomerRepository;
use AlistairShaw\Vendirun\App\Entities\Customer\Helpers\CustomerHelper;
use AlistairShaw\Vendirun\App\Entities\Order\ApiOrderRepository;
use AlistairShaw\Vendirun\App\Entities\Order\OrderRepository;
use AlistairShaw\Vendirun\App\Entities\Product\ApiProductRepository;
use AlistairShaw\Vendirun\App\Entities\Product\ProductCategory\ApiProductCategoryRepository;
use AlistairShaw\Vendirun\App\Entities\Product\ProductCategory\ProductCategoryRepository;
use AlistairShaw\Vendirun\App\Entities\Product\ProductRepository;
use AlistairShaw\Vendirun\App\Lib\ClientHelper;
use AlistairShaw\Vendirun\App\Lib\CountryHelper;
use AlistairShaw\Vendirun\App\Lib\CurrencyHelper;
use AlistairShaw\Vendirun\App\Lib\LocaleHelper;
use AlistairShaw\Vendirun\App\Lib\Social\SocialLinks;
use AlistairShaw\Vendirun\App\Lib\Social\SocialLinksStandard;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class VendirunServiceProvider extends ServiceProvider {

    //protected $defer = true;

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

        $clientInfo = ClientHelper::getClientInfo();

        if ($clientInfo->business_settings->tax->price_includes_tax)
        {
            $this->app->bind(CartValuesTransformer::class, CartValuesVATIncludedTransformer::class);
        }
        else
        {
            $this->app->bind(CartValuesTransformer::class, CartValuesVATExcludedTransformer::class);
        }

        $this->app->bind(CartRepository::class, function() {
            $clientInfo = ClientHelper::getClientInfo();
            $transformer = $clientInfo->business_settings->tax->price_includes_tax ? new CartValuesVATExcludedTransformer() : new CartValuesVATIncludedTransformer();
            return new ApiCartRepository($transformer);
        });
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
        $this->app->bind(SocialLinks::class, SocialLinksStandard::class);
        $this->app->bind(OrderRepository::class, ApiOrderRepository::class);
        $this->app->bind(CustomerRepository::class, ApiCustomerRepository::class);
        $this->app->bind(ProductRepository::class, ApiProductRepository::class);
        $this->app->bind(ProductCategoryRepository::class, ApiProductCategoryRepository::class);

		// aliases
		$loader = AliasLoader::getInstance();
		$loader->alias('LocaleHelper', LocaleHelper::class);
		$loader->alias('CurrencyHelper', CurrencyHelper::class);
		$loader->alias('CountryHelper', CountryHelper::class);
		$loader->alias('ClientHelper', ClientHelper::class);
		$loader->alias('TaxCalculator', TaxCalculator::class);
		$loader->alias('CustomerHelper', CustomerHelper::class);
	}
}
