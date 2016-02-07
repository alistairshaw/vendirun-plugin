<?php namespace AlistairShaw\Vendirun\App\Http\Composers;

use AlistairShaw\Vendirun\App\Lib\CurrencyHelper;
use AlistairShaw\Vendirun\App\Lib\UnitHelper;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;
use App;
use Config;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Session;

class PropertyWidgetsViewComposer {

    /**
     * @param View $view
     */
    public function propertyCategories(View $view)
    {
        $viewData = $view->getData();
        $element_options = isset($viewData['element']->element_options) ? json_decode($viewData['element']->element_options, true) : ['layout' => '3 columns', 'show_images' => 'Yes', 'max' => 0];

        $categoryName = isset($viewData['categoryName']) ? urldecode($viewData['categoryName']) : '';

        $category = VendirunApi::makeRequest('property/getCategory', ['category' => $categoryName, 'max' => $element_options['max']])->getData();

        // translations
        if (isset($category->translations) && $category->translations)
        {
            $translations = json_decode($category->translations, true);
            if (isset($translations[App::getLocale()]['category'])) $category->category_name  = $translations[App::getLocale()]['category'];
            if (isset($translations[App::getLocale()]['description'])) $category->category_description  = $translations[App::getLocale()]['description'];
        }

        // translations for sub-categories
        $newSubCategories = [];
        foreach ($category->sub_categories as $cat)
        {
            $cat->link_name = $cat->category_name;
            if ($cat->translations)
            {
                $translations = json_decode($cat->translations, true);
                if (isset($translations[App::getLocale()]['category'])) $cat->category_name  = $translations[App::getLocale()]['category'];
                if (isset($translations[App::getLocale()]['description'])) $cat->category_description  = $translations[App::getLocale()]['description'];
            }

            $newSubCategories[] = $cat;
        }
        $category->sub_categories = $newSubCategories;

        $view->with('category', $category);

        switch ($element_options['layout'])
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
                $element_options['col_md'] = NULL;
        }

        $view->with('element_options', $element_options);
    }

    /**
     * @param View $view
     */
    public function propertyLocations(View $view)
    {
        $viewData = $view->getData();
        $element_options = isset($viewData['element']->element_options) ? json_decode($viewData['element']->element_options, true) : ['layout' => '3 columns', 'show_images' => 'Yes', 'max' => 0];

        if (!isset($viewData['location']))
        {
            $locationName = isset($viewData['locationName']) ? urldecode($viewData['locationName']) : '';
            $location = VendirunApi::makeRequest('property/getLocation', ['location' => $locationName, 'max' => $element_options['max']])->getData();

            $view->with('location', $location);
        }

        switch ($element_options['layout'])
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
                $element_options['col_md'] = NULL;
        }

        $view->with('element_options', $element_options);
    }

    /**
     * @param View $view
     */
    public function propertyAttributes(View $view)
    {
        $viewData = $view->getData();
        $property = $viewData['property'];
        $final = [];

        if ($property->city) $final[trans('vendirun::property.city')] = $property->city;
        if ($property->location_name) $final[trans('vendirun::property.location')] = $property->location_name;
        if ($property->bedrooms) $final[trans('vendirun::property.bedrooms')] = $property->bedrooms;
        if ($property->bathrooms) $final[trans('vendirun::property.bathrooms')] = $property->bathrooms;
        if ($property->build_size) $final[trans('vendirun::property.buildSize')] = UnitHelper::formatArea($property->build_size);
        if ($property->terrace_size) $final[trans('vendirun::property.terraceSize')] = UnitHelper::formatArea($property->terrace_size);
        if ($property->garden_size) $final[trans('vendirun::property.gardenSize')] = UnitHelper::formatArea($property->garden_size);
        if ($property->total_plot_size) $final[trans('vendirun::property.totalPlotSize')] = UnitHelper::formatArea($property->total_plot_size);
        if ($property->reference) $final[trans('vendirun::property.reference')] = $property->reference;

        $view->with('attributes', $final);
    }

    /**
     * @param View $view
     */
    public function propertySearchForm(View $view)
    {
        $priceArray = [
            0 => trans('vendirun::property.any'),
            10000 => currencyHelper::formatWithCurrency(1000000, true),
            50000 => currencyHelper::formatWithCurrency(5000000, true),
            100000 => currencyHelper::formatWithCurrency(10000000, true),
            200000 => currencyHelper::formatWithCurrency(20000000, true),
            300000 => currencyHelper::formatWithCurrency(30000000, true),
            400000 => currencyHelper::formatWithCurrency(40000000, true),
            500000 => currencyHelper::formatWithCurrency(50000000, true),
            600000 => currencyHelper::formatWithCurrency(60000000, true),
            700000 => currencyHelper::formatWithCurrency(70000000, true),
            800000 => currencyHelper::formatWithCurrency(80000000, true),
            900000 => currencyHelper::formatWithCurrency(90000000, true),
            1000000 => currencyHelper::formatWithCurrency(100000000, true),
            1500000 => currencyHelper::formatWithCurrency(150000000, true),
            2000000 => currencyHelper::formatWithCurrency(200000000, true),
            2500000 => currencyHelper::formatWithCurrency(250000000, true),
            3000000 => currencyHelper::formatWithCurrency(300000000, true),
            3500000 => currencyHelper::formatWithCurrency(350000000, true),
            4000000 => currencyHelper::formatWithCurrency(400000000, true)
        ];

        $propertyTypeArray[''] = [trans('vendirun::property.any')];
        $categories = VendirunApi::makeRequest('property/getCategoryList', ['language' => App::getLocale()]);
        if ($categories->getSuccess())
        {
            foreach ($categories->getData() as $category) $propertyTypeArray[$category->id] = $category->category_name;
        }

        $view->with('priceArray', $priceArray)->with('propertyTypeArray', $propertyTypeArray);
    }

    /**
     * @param View $view
     */
    public function propertyView(View $view)
    {
        $viewData = $view->getData();
        $property = $viewData['property'];

        if (isset($property->translations) && $property->translations)
        {
            $translations = json_decode($property->translations, true);
            if (isset($translations[App::getLocale()]['title']) && $translations[App::getLocale()]['title']) $property->title = $translations[App::getLocale()]['title'];
            if (isset($translations[App::getLocale()]['short_description']) && $translations[App::getLocale()]['short_description']) $property->short_description = $translations[App::getLocale()]['short_description'];
            if (isset($translations[App::getLocale()]['long_description']) && $translations[App::getLocale()]['long_description']) $property->long_description = $translations[App::getLocale()]['long_description'];
        }

        $newAttributes = [];
        foreach ($property->attributes as $attribute)
        {
            if (isset($attribute->translations) && $attribute->translations)
            {
                $translations = json_decode($attribute->translations, true);
                if (isset($translations[App::getLocale()]['attribute'])) $attribute->property_attribute_name = $translations[App::getLocale()]['attribute'];
                if (isset($translations[App::getLocale()]['description'])) $attribute->property_attribute_description = $translations[App::getLocale()]['description'];
            }
            $newAttributes[] = $attribute;
        }
        $property->attributes = $newAttributes;

        $view->with('property', $property);
        $view->with('price', CurrencyHelper::formatWithCurrency($property->price, true));
        $view->with('propertySlug', Str::slug($property->title));
    }

    /**
     * @param View $view
     */
    public function propertyButtons(View $view)
    {
        $viewData = $view->getData();

        $validPropertyButtons = ['details', 'enquire', 'favourite', 'property-card', 'recommend'];
        if (!isset($viewData['propertyButtons']))
        {
            $propertyButtons = $validPropertyButtons;
        }
        else
        {
            $propertyButtons = [];
            foreach ($viewData['propertyButtons'] as $button)
            {
                if (in_array($button, $validPropertyButtons)) $propertyButtons[] = $button;
            }
        }

        $view->with('propertyButtons', $propertyButtons);
        if (!isset($viewData['abbreviatedButtons'])) $view->with('abbreviatedButtons', false);
        $view->with('propertyCardUrl', Config::get('vendirun.apiEndPoint') . '../../public_area/property_card/' . $viewData['property']->id . '/' . Config::get('vendirun.clientId') . '/single/A4/true/' . App::getLocale());
    }

    /**
     * @param View $view
     */
    public function getFavourites(View $view)
    {
        $favouritePropertiesArray = [];
        try
        {
            $favouriteProperties = VendirunApi::makeRequest('property/getFavourite', ['token' => Session::get('token')])->getData();
            foreach ($favouriteProperties as $favourite) $favouritePropertiesArray[] = $favourite->id;
        }
        catch (\Exception $e)
        {
            $favouriteProperties = NULL;
        }


        $view->with('favouriteProperties')->with('favouritePropertiesArray', $favouritePropertiesArray);
    }
}