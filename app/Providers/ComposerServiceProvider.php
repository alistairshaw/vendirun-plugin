<?php namespace Ambitiousdigital\Vendirun\App\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider {

    public function register()
    {
        // widgets
        $this->app->view->composer('vendirun::cms.widgets.property-categories', 'Ambitiousdigital\Vendirun\App\Http\Composers\PropertyWidgetsViewComposer@propertyCategories');
        $this->app->view->composer('vendirun::cms.widgets.property-locations', 'Ambitiousdigital\Vendirun\App\Http\Composers\PropertyWidgetsViewComposer@propertyLocations');

        // cms page
        $this->app->view->composer('vendirun::cms.page', 'Ambitiousdigital\Vendirun\App\Http\Composers\CmsViewComposer');

        // menu
        $this->app->view->composer('vendirun::cms.menu', 'Ambitiousdigital\Vendirun\App\Http\Composers\CmsViewComposer@menu');
    }

}