<?php namespace Ambitiousdigital\Vendirun\App\Http\Composers;

use Ambitiousdigital\Vendirun\App\Lib\VendirunApi\propertyApi;
use Illuminate\View\View;

class PropertyWidgetsViewComposer {

    /**
     * @var object
     */
    private $propertyApi;

    public function __construct()
    {
        $this->propertyApi = new propertyApi();
    }

    /**
     * @param View $view
     */
    public function propertyCategories(View $view)
    {
        $viewData= $view->getData();
        $element_options = isset($viewData->element->element_options) ? json_decode($viewData->element->element_options, true) : ['layout' => '3 columns', 'show_images' => 'Yes', 'max' => 0];

        $view->with('categories', $this->propertyApi->getCategories())->with('element_options', $element_options);
    }

    /**
     * @param View $view
     */
    public function propertyLocations(View $view)
    {
        $viewData = $view->getData();
        $element_options = isset($viewData['element']->element_options) ? json_decode($viewData['element']->element_options, true) : ['layout' => '3 columns', 'show_images' => 'Yes', 'max' => 0];

        $locationName = isset($viewData['locationName']) ? urldecode($viewData['locationName']) : '';
        $locationData = $this->propertyApi->getLocation($locationName, $element_options['max']);
        $location = $locationData['success'] ? $locationData['data'] : [];

        switch($element_options['layout'])
        {
            case '2 columns':
                $element_options['col_md'] = 6;
                break;
            case '3 columns':
                $element_options['col_md'] = 4;
                break;
            case '4 columns':
                $element_options['col_md'] = 3;
                break;
            default:
                $element_options['col_md'] = null;
        }

        $view->with('location', $location)->with('element_options', $element_options);
    }

}