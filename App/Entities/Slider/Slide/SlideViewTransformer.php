<?php namespace AlistairShaw\Vendirun\App\Entities\Slider\Slide;

class SlideViewTransformer implements SlideTransformer {

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
    public function getValues($id, $minHeight, $maxHeight, $background, $backgroundCover, $setAsBackground, $caption, $content, $alt, $link, $callToAction)
    {
        return [
            'id' => $id,
            'background' => $background,
            'backgroundCover' => $backgroundCover,
            'setAsBackground' => $setAsBackground,
            'caption' => $caption,
            'content' => $content,
            'alt' => $alt,
            'link' => $link,
            'callToAction' => $callToAction,
            'slideStyles' => $this->getSlideStyles($minHeight, $maxHeight, $setAsBackground, $backgroundCover, $background->hd),
        ];
    }

    /**
     * @param $minHeight
     * @param $maxHeight
     * @param $setAsBackground
     * @param $backgroundCover
     * @param $imageUrl
     * @return array
     */
    private function getSlideStyles($minHeight, $maxHeight, $setAsBackground, $backgroundCover, $imageUrl)
    {
        $slideStyles = [];

        $actualHeight = ($minHeight == $maxHeight) ? $minHeight : 0;

        // if we have no min height and the slider is set as background, then we need to give it some height
        //    otherwise it's not visible
        if (!$minHeight && !$actualHeight && $setAsBackground == 1) $slideStyles[] = 'height: calc(100vh)';

        if ($minHeight) $slideStyles[] = 'min-height: ' . $minHeight . 'px';
        if ($maxHeight) $slideStyles[] = 'max-height: ' . $maxHeight . 'px';
        if ($actualHeight) $slideStyles[] = 'height: ' . $actualHeight . 'px';

        if (isset($setAsBackground))
        {
            if ($setAsBackground == 1) $slideStyles[] = 'background-position: center top';
            if ($setAsBackground == 1) $slideStyles[] = 'background-image: url(' . $imageUrl . ')';
        }
        if (isset($backgroundCover) && $backgroundCover == 1) $slideStyles[] = 'background-size: cover';

        return $slideStyles;
    }
}