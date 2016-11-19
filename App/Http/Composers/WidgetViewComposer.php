<?php namespace AlistairShaw\Vendirun\App\Http\Composers;

use AlistairShaw\Vendirun\App\Lib\CountryHelper;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\Exceptions\FailResponseException;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;
use App;
use Config;
use Illuminate\View\View;
use URL;

class WidgetViewComposer {

    /**
     * Social media buttons
     * @param View $view
     */
    public function social($view)
    {
        if ($clientInfo = Config::get('clientInfo'))
        {
            $view->with('social', $clientInfo->social);
        }
        $view->with('socialType', Config::get('socialType', 'light'));
    }

    public function staff($view)
    {
        $staff = VendirunApi::makeRequest('client/staff')->getData();
        $view->with('staff', $staff);
    }

    /**
     * @param View        $view
     */
    public function socialShare($view)
    {
        $viewData = $view->getData();

        $socialLinks = App::make('AlistairShaw\Vendirun\App\Lib\Social\SocialLinks');

        // get page title, description and image
        switch (true)
        {
            case (isset($viewData['productDisplay'])):
                $pageTitle = $viewData['productDisplay']['productName'];
                $pageText = $viewData['productDisplay']['shortDescription'];
                $pageImage = $viewData['productDisplay']['images'][0]->mediumsq;
                break;
            default:
                $pageTitle = '';
                $pageText = '';
                $pageImage = '';
        }

        $social = $socialLinks->getLinks(URL::full(), $pageTitle, $pageText, $pageImage);
        $view->with('socialLinks', $social);
    }

    /**
     * @param $view
     */
    public function regions($view)
    {
        $regions = CountryHelper::getRegions();
        $view->with('regions', $regions);
    }

    /**
     * @param View $view
     */
    public function slider($view)
    {
        $viewData = $view->getData();
        if (!isset($viewData['options'])) $viewData['options'] = json_decode($viewData['element']->element_options, true);
        $slider_id = $viewData['options']['id'];

        try
        {
            $slider = VendirunApi::makeRequest('cms/slider', ['id' => $slider_id])->getData();
            $sliderStyles = $this->getSliderStyles($slider);
            $slideStyles = $this->getSlideStyles($slider);
        }
        catch (FailResponseException $e)
        {
            $slider = false;
            $sliderStyles = [];
            $slideStyles = [];
        }
        $view->with('slider', $slider)->with('sliderStyles', $sliderStyles)->with('slideStyles', $slideStyles);
    }

    /**
     * @param $slider
     * @return array
     */
    private function getSliderStyles($slider)
    {
        $sliderStyles = [];
        if ($slider->full_screen == 1)
        {
            $sliderStyles[] = 'height: 100%';
        }
        else
        {
            if ($slider->max_height > 0) $sliderStyles[] = 'max-height: ' . $slider->max_height . 'px';
            if ($slider->min_height > 0) $sliderStyles[] = 'min-height: ' . $slider->min_height . 'px';
        }

        if (count($sliderStyles)) $sliderStyles[] = 'overflow: hidden;';

        return $sliderStyles;
    }

    /**
     * @param $slider
     * @return array
     */
    private function getSlideStyles($slider)
    {
        $slideStyles = [];
        $index = 0;
        foreach ($slider->slides as $slide)
        {
            $slideStyles[$index] = [];
            if ($slide->set_as_background == 1) $slideStyles[$index][] = 'min-height: calc(100vh)';
            if ($slide->set_as_background == 1) $slideStyles[$index][] = 'background-position: center top';
            if ($slide->set_as_background == 1) $slideStyles[$index][] = 'background-image: url(' . $slide->background->hd . ')';
            if ($slide->background_cover == 1) $slideStyles[$index][] = 'background-size: cover';

            $index++;
        }
        return $slideStyles;
    }
}