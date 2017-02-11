<?php namespace AlistairShaw\Vendirun\App\Entities\Slider;

class Slider {

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $sliderName;

    /**
     * @var string
     */
    private $css;

    /**
     * @var int
     */
    private $speed;

    /**
     * @var bool
     */
    private $fullScreen;

    /**
     * @var int
     */
    private $maxHeight;

    /**
     * @var int
     */
    private $minHeight;

    /**
     * Array of Slide objects
     * @var array
     */
    private $slides;

    /**
     * Slider constructor.
     * @param $id
     * @param $sliderName
     * @param $css
     * @param $speed
     * @param $fullScreen
     * @param $maxHeight
     * @param $minHeight
     * @param $slides
     */
    public function __construct($id, $sliderName, $css, $speed, $fullScreen, $maxHeight, $minHeight, $slides)
    {
        $this->id = $id;
        $this->sliderName = $sliderName;
        $this->css = $css;
        $this->speed = (int)$speed;
        $this->fullScreen = (bool)$fullScreen;
        $this->maxHeight = (int)$maxHeight;
        $this->minHeight = (int)$minHeight;
        $this->slides = (array)$slides;
    }

    /**
     * @param SliderTransformer $transformer
     * @return mixed
     */
    public function transform(SliderTransformer $transformer)
    {
        return $transformer->getValues($this->id, $this->css, $this->speed, $this->fullScreen, $this->maxHeight, $this->minHeight, $this->slides);
    }

}