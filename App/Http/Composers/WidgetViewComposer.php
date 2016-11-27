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
        if (isset($slider->full_screen) && $slider->full_screen == 1)
        {
            $sliderStyles[] = 'height: 100%';
        }
        else
        {
            if ($slider->max_height == $slider->min_height)
            {
                $sliderStyles[] = 'height: ' . $slider->min_height . 'px';
            }
            else
            {
                if (isset($slider->max_height) && $slider->max_height > 0) $sliderStyles[] = 'max-height: ' . $slider->max_height . 'px';
                if (isset($slider->min_height) && $slider->min_height > 0) $sliderStyles[] = 'min-height: ' . $slider->min_height . 'px';
            }
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
            $minHeight = 0;
            $maxHeight = 0;
            if (isset($slider->min_height) && $slider->min_height > 0) $minHeight = $slider->min_height;
            if (isset($slider->max_height) && $slider->max_height > 0) $maxHeight = $slider->max_height;
            $actualHeight = ($minHeight == $maxHeight) ? $minHeight : 0;


            // if we have no min height and the slider is set as background, then we need to give it some height
            //    otherwise it's not visible
            if (!$minHeight && !$actualHeight && $slide->set_as_background == 1) $minHeight = 'calc(100vh)';

            $slideStyles[$index] = [];
            if ($minHeight) $slideStyles[$index][] = 'min-height: ' . $minHeight . 'px';
            if ($maxHeight) $slideStyles[$index][] = 'max-height: ' . $maxHeight . 'px';
            if ($actualHeight) $slideStyles[$index][] = 'height: ' . $actualHeight . 'px';

            if (isset($slide->set_as_background))
            {
                if ($slide->set_as_background == 1) $slideStyles[$index][] = 'background-position: center top';
                if ($slide->set_as_background == 1) $slideStyles[$index][] = 'background-image: url(' . $slide->background->hd . ')';
            }
            if (isset($slide->background_cover) && $slide->background_cover == 1) $slideStyles[$index][] = 'background-size: cover';

            $index++;
        }
        return $slideStyles;
    }
}