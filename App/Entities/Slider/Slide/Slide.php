<?php namespace AlistairShaw\Vendirun\App\Entities\Slider\Slide;

class Slide {

    /**
     * @var string
     */
    private $id;

    /**
     * Array of available images
     * @var array
     */
    private $background;

    /**
     * @var bool
     */
    private $backgroundCover;

    /**
     * @var bool
     */
    private $setAsBackground;

    /**
     * @var string
     */
    private $caption;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $alt;

    /**
     * @var string
     */
    private $link;

    /**
     * @var string
     */
    private $callToAction;

    /**
     * @var int
     */
    private $minHeight;

    /**
     * @var int
     */
    private $maxHeight;

    /**
     * Slide constructor.
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
     */
    public function __construct($id, $minHeight, $maxHeight, $background, $backgroundCover, $setAsBackground, $caption, $content, $alt, $link, $callToAction)
    {
        $this->id = $id;
        $this->background = $background;
        $this->backgroundCover = (bool)$backgroundCover;
        $this->setAsBackground = (bool)$setAsBackground;
        $this->caption = $caption;
        $this->content = $content;
        $this->alt = $alt;
        $this->link = $link;
        $this->callToAction = $callToAction;
        $this->minHeight = (int)$minHeight;
        $this->maxHeight = (int)$maxHeight;
    }

    /**
     * @param SlideTransformer $transformer
     * @return mixed
     */
    public function transform(SlideTransformer $transformer)
    {
        return $transformer->getValues(
            $this->id,
            $this->minHeight,
            $this->maxHeight,
            $this->background,
            $this->backgroundCover,
            $this->setAsBackground,
            $this->caption,
            $this->content,
            $this->alt,
            $this->link,
            $this->callToAction);
    }

}