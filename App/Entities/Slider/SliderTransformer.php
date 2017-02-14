<?php namespace AlistairShaw\Vendirun\App\Entities\Slider;

interface SliderTransformer {

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
    public function getValues($id, $css, $speed, $fullScreen, $maxHeight, $minHeight, $slides);

}