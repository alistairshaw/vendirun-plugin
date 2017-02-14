<?php namespace AlistairShaw\Vendirun\App\Entities\Slider;

use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;

class ApiSliderRepository implements SliderRepository {

    /**
     * @param $id
     * @return Slider
     */
    public function find($id)
    {
        $slider = VendirunApi::makeRequest('cms/slider', ['id' => $id])->getData();
        return SliderFactory::fromApi($slider);
    }
}