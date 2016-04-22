<?php namespace AlistairShaw\Vendirun\App\Http\Controllers\Api;

use AlistairShaw\Vendirun\App\Http\Controllers\VendirunBaseController;

class ApiBaseController extends VendirunBaseController {

    /**
     * @param        $success
     * @param array  $data
     * @param string $message
     * @param array  $options
     * @return array
     */
    protected function respond($success, $data = [], $message = '', $options = [])
    {
        return [
            'success' => $success,
            'data' => $data,
            'message' => $message,
            'options' => $options
        ];
    }

}