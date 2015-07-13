<?php namespace Ambitiousdigital\Vendirun\App\Http\Composers;

use Ambitiousdigital\Vendirun\App\Lib\VendirunApi\propertyApi;

class PropertyWidgetsViewComposer {

    /**
     * @var object
     */
    private $propertyApi;

    public function __construct()
    {
        $this->propertyApi = new propertyApi();
    }

    public function propertyCategories($view)
    {
        $view->with('categories', $this->propertyApi->getCategories());
    }

    public function propertyLocations($view)
    {
        $viewData = $view->getData();

        $locationName = isset($viewData['locationName']) ? urldecode($viewData['locationName']) : '';
        $locationData = $this->propertyApi->getLocation($locationName);
        $location = $locationData['success'] ? $locationData['data'] : [];

        $view->with('location', $location);
    }

}