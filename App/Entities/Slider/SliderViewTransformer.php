<?php namespace AlistairShaw\Vendirun\App\Entities\Slider;

use AlistairShaw\Vendirun\App\Entities\Slider\Slide\Slide;
use AlistairShaw\Vendirun\App\Entities\Slider\Slide\SlideViewTransformer;

class SliderViewTransformer implements SliderTransformer {

    /**
     * @param $id
     * @param $css
     * @param $speed
     * @param $fullScreen
     * @param $maxHeight
     * @param $minHeight
     * @param $slides
     * @return mixed
     */
    public function getValues($id, $css, $speed, $fullScreen, $maxHeight, $minHeight, $slides)
    {
        $finalSlides = [];
        foreach ($slides as $slide)
        {
            /* @var $slide Slide */
            $finalSlides[] = $slide->transform(new SlideViewTransformer());
        }

        return [
            'id' => $id,
            'css' => $css,
            'speed' => $speed,
            'fullScreen' => $fullScreen,
            'maxHeight' => $maxHeight,
            'minHeight' => $minHeight,
            'slides' => $finalSlides,
            'sliderStyles' => $this->getSliderStyles($fullScreen, $maxHeight, $minHeight)
        ];
    }

    /**
     * @param $fullScreen
     * @param $maxHeight
     * @param $minHeight
     * @return array
     */
    private function getSliderStyles($fullScreen, $maxHeight, $minHeight)
    {
        $sliderStyles = [];
        if ($fullScreen)
        {
            $sliderStyles[] = 'height: 100%';
        }
        else
        {
            if ($maxHeight == $minHeight)
            {
                $sliderStyles[] = 'height: ' . $minHeight . 'px';
            }
            else
            {
                if (isset($maxHeight) && $maxHeight > 0) $sliderStyles[] = 'max-height: ' . $maxHeight . 'px';
                if (isset($minHeight) && $minHeight > 0) $sliderStyles[] = 'min-height: ' . $minHeight . 'px';
            }
        }

        if (count($sliderStyles)) $sliderStyles[] = 'overflow: hidden;';

        return $sliderStyles;
    }
}