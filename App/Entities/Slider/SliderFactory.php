<?php namespace AlistairShaw\Vendirun\App\Entities\Slider;

use AlistairShaw\Vendirun\App\Entities\Slider\Slide\Slide;

class SliderFactory {

    /**
     * @param $slider
     * @return Slider
     */
    public static function fromApi($slider)
    {
        $slides = [];
        foreach ($slider->slides as $s)
        {
            $slides[] = new Slide(
                $s->id,
                $slider->min_height,
                $slider->max_height,
                $s->background,
                $s->background_cover,
                $s->set_as_background,
                $s->caption,
                $s->content,
                $s->alt,
                $s->link,
                $s->call_to_action
            );
        }

        return new Slider(
            $slider->id,
            $slider->slider_name,
            $slider->css,
            $slider->speed,
            $slider->full_screen,
            $slider->max_height,
            $slider->min_height,
            $slides
        );
    }

}