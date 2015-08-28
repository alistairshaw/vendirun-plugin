<?php namespace AlistairShaw\Vendirun\App\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider {

    public function register()
    {
        // property
        $this->app->view->composer('vendirun::cms.widgets.property-categories', 'AlistairShaw\Vendirun\App\Http\Composers\PropertyWidgetsViewComposer@propertyCategories');
        $this->app->view->composer('vendirun::cms.widgets.property-locations', 'AlistairShaw\Vendirun\App\Http\Composers\PropertyWidgetsViewComposer@propertyLocations');
        $this->app->view->composer('vendirun::property.search-form', 'AlistairShaw\Vendirun\App\Http\Composers\PropertyWidgetsViewComposer@propertySearchForm');
        $this->app->view->composer('vendirun::property.result', 'AlistairShaw\Vendirun\App\Http\Composers\PropertyWidgetsViewComposer@propertyView');
        $this->app->view->composer('vendirun::property.view', 'AlistairShaw\Vendirun\App\Http\Composers\PropertyWidgetsViewComposer@propertyView');
        $this->app->view->composer('vendirun::property.partials.property-attributes', 'AlistairShaw\Vendirun\App\Http\Composers\PropertyWidgetsViewComposer@propertyAttributes');

        // cms page
        $this->app->view->composer('vendirun::cms.page', 'AlistairShaw\Vendirun\App\Http\Composers\CmsViewComposer');

        // menu
        $this->app->view->composer('vendirun::cms.menu', 'AlistairShaw\Vendirun\App\Http\Composers\CmsViewComposer@menu');
        $this->app->view->composer('vendirun::cms.menu.item', 'AlistairShaw\Vendirun\App\Http\Composers\CmsViewComposer@menuItem');
        $this->app->view->composer('vendirun::cms.menu.link', 'AlistairShaw\Vendirun\App\Http\Composers\CmsViewComposer@menuLink');
    }

}