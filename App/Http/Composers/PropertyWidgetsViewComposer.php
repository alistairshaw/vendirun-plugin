<?php namespace AlistairShaw\Vendirun\App\Http\Composers;

use AlistairShaw\Vendirun\App\Lib\VendirunApi\PropertyApi;
use Illuminate\View\View;

class PropertyWidgetsViewComposer {

    /**
     * @var PropertyApi
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
        $viewData = $view->getData();
        $element_options = isset($viewData['element']->element_options) ? json_decode($viewData['element']->element_options, true) : ['layout' => '3 columns', 'show_images' => 'Yes', 'max' => 0];

        $categoryName = isset($viewData['categoryName']) ? urldecode($viewData['categoryName']) : '';
        $categoryData = $this->propertyApi->getCategory($categoryName, $element_options['max']);
        $category = $categoryData['success'] ? $categoryData['data'] : [];

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

        $view->with('category', $category)->with('element_options', $element_options);
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

    /**
     * @param View $view
     */
    public function propertySearchForm(View $view)
    {
        $priceArray = [
            0=>'Any',
            10000=>'10,000€',
            50000=>'50,000€',
            100000=>'100,000€',
            200000=>'200,000€',
            300000=>'300,000€',
            400000=>'400,000€',
            500000=>'500,000€',
            600000=>'600,000€',
            700000=>'700,000€',
            800000=>'800,000€',
            900000=>'900,000€',
            1000000=>'1000,000€',
            1500000=>'1500,000€',
            2000000=>'2000,000€',
            2500000=>'2500,000€',
            3000000=>'3000,000€',
            3500000=>'3500,000€',
            4000000=>'4000,000€'
        ];

        $categories = $this->propertyApi->getCategoryList();
        $propertyTypeArray[''] = ['Any'];
        foreach ($categories['data'] as $category)
        {
            $propertyTypeArray[$category->id] = $category->category_name;
        }

        $view->with('priceArray', $priceArray)->with('propertyTypeArray', $propertyTypeArray);
    }

}