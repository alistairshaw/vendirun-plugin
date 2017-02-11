<?php namespace AlistairShaw\Vendirun\App\Entities\Slider\Slide;

interface SlideTransformer {

    /**
     * @param $id
     * @param $minHeight
     * @param $maxHeight
     * @param $background
     * @param $backgroundCover
     * @param $setAsBackground
     * @param $caption
     * @param $content
     * @param $alt
     * @param $link
     * @param $callToAction
     * @return mixed
     */
    public function getValues($id, $minHeight, $maxHeight, $background, $backgroundCover, $setAsBackground, $caption, $content, $alt, $link, $callToAction);

}