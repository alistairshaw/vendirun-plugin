<?php namespace AlistairShaw\Vendirun\App\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider {

    public function register()
    {
        // widgets
        $this->app->view->composer('vendirun::cms.widgets.property-categories', 'AlistairShaw\Vendirun\App\Http\Composers\PropertyWidgetsViewComposer@propertyCategories');
        $this->app->view->composer('vendirun::cms.widgets.property-locations', 'AlistairShaw\Vendirun\App\Http\Composers\PropertyWidgetsViewComposer@propertyLocations');

        // cms page
        $this->app->view->composer('vendirun::cms.page', 'AlistairShaw\Vendirun\App\Http\Composers\CmsViewComposer');

        // menu
        $this->app->view->composer('vendirun::cms.menu', 'AlistairShaw\Vendirun\App\Http\Composers\CmsViewComposer@menu');
    }

}