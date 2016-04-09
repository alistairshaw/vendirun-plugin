<?php namespace AlistairShaw\Vendirun\App\Providers;

use App;
use Illuminate\Support\ServiceProvider;

/**
 * Class ComposerServiceProvider
 * @package AlistairShaw\Vendirun\App\Providers
 *
 */

class ComposerServiceProvider extends ServiceProvider {

    protected $app;

    public function register()
    {
        $this->registerPropertyComposers();
        $this->registerProductComposers();
        $this->registerCmsComposers();
        $this->registerCustomerComposers();
    }

    private function registerPropertyComposers()
    {
        $this->app->view->composer('vendirun::cms.widgets.property-categories', 'AlistairShaw\Vendirun\App\Http\Composers\PropertyWidgetsViewComposer@propertyCategories');
        $this->app->view->composer('vendirun::cms.widgets.property-locations', 'AlistairShaw\Vendirun\App\Http\Composers\PropertyWidgetsViewComposer@propertyLocations');
        $this->app->view->composer('vendirun::property.category', 'AlistairShaw\Vendirun\App\Http\Composers\PropertyWidgetsViewComposer@propertyCategories');
        $this->app->view->composer('vendirun::property.location', 'AlistairShaw\Vendirun\App\Http\Composers\PropertyWidgetsViewComposer@propertyLocations');
        $this->app->view->composer('vendirun::property.search-form', 'AlistairShaw\Vendirun\App\Http\Composers\PropertyWidgetsViewComposer@propertySearchForm');
        $this->app->view->composer('vendirun::property.partials.property-attributes', 'AlistairShaw\Vendirun\App\Http\Composers\PropertyWidgetsViewComposer@propertyAttributes');

        $this->app->view->composer('vendirun::property.result', 'AlistairShaw\Vendirun\App\Http\Composers\PropertyWidgetsViewComposer@propertyView');
        $this->app->view->composer('vendirun::property.view.type1', 'AlistairShaw\Vendirun\App\Http\Composers\PropertyWidgetsViewComposer@propertyView');
        $this->app->view->composer('vendirun::property.view.type2', 'AlistairShaw\Vendirun\App\Http\Composers\PropertyWidgetsViewComposer@propertyView');

        $this->app->view->composer('vendirun::property.favourite-properties', 'AlistairShaw\Vendirun\App\Http\Composers\PropertyWidgetsViewComposer@getFavourites');

        $this->app->view->composer('vendirun::property.partials.property-buttons', 'AlistairShaw\Vendirun\App\Http\Composers\PropertyWidgetsViewComposer@getFavourites');
        $this->app->view->composer('vendirun::property.partials.property-buttons', 'AlistairShaw\Vendirun\App\Http\Composers\PropertyWidgetsViewComposer@propertyButtons');
    }

    private function registerProductComposers()
    {
        $this->app->view->composer('vendirun::product.result', 'AlistairShaw\Vendirun\App\Http\Composers\ProductViewComposer@productView');
        $this->app->view->composer('vendirun::product.refine.category-list', 'AlistairShaw\Vendirun\App\Http\Composers\ProductViewComposer@categories');

        $this->app->view->composer('vendirun::product.partials.product-buttons', 'AlistairShaw\Vendirun\App\Http\Composers\ProductViewComposer@productButtons');
        $this->app->view->composer('vendirun::product.partials.cart.cart-widget', 'AlistairShaw\Vendirun\App\Http\Composers\ProductViewComposer@cart');

        $this->app->view->composer('vendirun::product.list', 'AlistairShaw\Vendirun\App\Http\Composers\ProductViewComposer@getFavourites');
        $this->app->view->composer('vendirun::product.recommend', 'AlistairShaw\Vendirun\App\Http\Composers\ProductViewComposer@getFavourites');
        $this->app->view->composer('vendirun::product.partials.related-products', 'AlistairShaw\Vendirun\App\Http\Composers\ProductViewComposer@getFavourites');
    }

    private function registerCmsComposers()
    {
        // menu
        $this->app->view->composer('vendirun::cms.menu', 'AlistairShaw\Vendirun\App\Http\Composers\CmsViewComposer@menu');
        $this->app->view->composer('vendirun::cms.menu.item', 'AlistairShaw\Vendirun\App\Http\Composers\CmsViewComposer@menuItem');
        $this->app->view->composer('vendirun::cms.menu.link', 'AlistairShaw\Vendirun\App\Http\Composers\CmsViewComposer@menuLink');

        // header and footer
        $this->app->view->composer('vendirun::common.footer', 'AlistairShaw\Vendirun\App\Http\Composers\CmsViewComposer@footer');
        $this->app->view->composer('vendirun::common.head', 'AlistairShaw\Vendirun\App\Http\Composers\CmsViewComposer@head');
        $this->app->view->composer('vendirun::cms.widgets.social-share', 'AlistairShaw\Vendirun\App\Http\Composers\CmsViewComposer@social');
        $this->app->view->composer('vendirun::common.language-select', 'AlistairShaw\Vendirun\App\Http\Composers\CmsViewComposer@languages');

        // widgets
        $this->app->view->composer('vendirun::cms.widgets.standard-social', 'AlistairShaw\Vendirun\App\Http\Composers\WidgetViewComposer@social');
        $this->app->view->composer('vendirun::cms.widgets.social-share', 'AlistairShaw\Vendirun\App\Http\Composers\WidgetViewComposer@socialShare');
        $this->app->view->composer('vendirun::cms.widgets.standard-staff', 'AlistairShaw\Vendirun\App\Http\Composers\WidgetViewComposer@staff');
    }

    private function registerCustomerComposers()
    {
        $this->app->view->composer('vendirun::cms.menu.login-button', 'AlistairShaw\Vendirun\App\Http\Composers\CustomerViewComposer@customerDetails');
    }

}