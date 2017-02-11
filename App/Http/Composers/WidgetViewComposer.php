<?php namespace AlistairShaw\Vendirun\App\Http\Composers;

use AlistairShaw\Vendirun\App\Entities\Slider\SliderRepository;
use AlistairShaw\Vendirun\App\Entities\Slider\SliderViewTransformer;
use AlistairShaw\Vendirun\App\Lib\CountryHelper;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\Exceptions\FailResponseException;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;
use App;
use Cache;
use Config;
use Illuminate\View\View;
use Thujohn\Twitter\Facades\Twitter;
use URL;

class WidgetViewComposer {

    /**
     * Social media buttons
     * @param View $view
     */
    public function social($view)
    {
        $data = $view->getData();

        if (isset($data['element']) && $data['element']->content == 'standard-social')
        {
            $socialOptions = json_decode($data['element']->element_options);

            $final = [
                'facebook' => null,
                'twitter' => null,
                'google_plus' => null,
                'linkedin' => null,
                'blog' => null
            ];
            foreach ($socialOptions as $key => $option)
            {
                if (!$option) continue;
                $final[str_replace('social_', '', $key)] = $option;
            }

            $view->with('social', (object)$final);
        }
        else if ($clientInfo = Config::get('clientInfo'))
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
    public function twitterFeed($view)
    {
        $viewData = $view->getData();
        $elementOptions = json_decode($viewData['element']->element_options);

        $tweets = [];
        $twitterHandle = '?';
        try
        {
            if (isset($elementOptions->name) && $elementOptions->name)
            {
                $twitterHandle = $elementOptions->name;

                if (!Cache::has('twitterFeed' . $twitterHandle))
                {
                    $tweets = json_decode(Twitter::getUserTimeline(['screen_name' => $elementOptions->name, 'count' => 8, 'format' => 'json']));
                    Cache::put('twitterFeed' . $twitterHandle, $tweets, 3);
                }
                else
                {
                    $tweets = Cache::get('twitterFeed' . $twitterHandle);
                }
            }
        }
        catch (\Exception $e)
        {
            // ignore any exceptions when retrieving tweets
        }

        $view->with('tweets', $tweets)->with('twitterHandle', $twitterHandle);
    }

    /**
     * @param View $view
     */
    public function slider($view)
    {
        $viewData = $view->getData();

        if (!isset($viewData['options'])) $viewData['options'] = json_decode($viewData['element']->element_options, true);
        $slider_id = $viewData['options']['id'];

        $cacheKey = 'vrSlider' . $slider_id;

        if (Cache::has($cacheKey))
        {
            $slider = Cache::get($cacheKey);
        }
        else
        {
            try
            {
                $sliderRepository = App::make(SliderRepository::class);
                $slider = $sliderRepository->find($slider_id);
            }
            catch (FailResponseException $e)
            {
                $slider = false;
            }

            Cache::put($cacheKey, $slider, 1);
        }

        $sliderData = $slider->transform(New SliderViewTransformer());

        $view->with('slider', $sliderData);
    }
}