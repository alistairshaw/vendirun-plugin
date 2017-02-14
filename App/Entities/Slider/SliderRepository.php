<?php namespace AlistairShaw\Vendirun\App\Entities\Slider;

interface SliderRepository {

    /**
     * @param $id
     * @return Slider
     */
    public function find($id);

}