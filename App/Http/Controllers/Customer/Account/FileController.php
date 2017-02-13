<?php namespace AlistairShaw\Vendirun\App\Http\Controllers\Customer\Account;

use AlistairShaw\Vendirun\App\Entities\Order\OrderRepository;
use AlistairShaw\Vendirun\App\Http\Controllers\VendirunBaseController;
use Redirect;

class FileController extends VendirunBaseController {

    /**
     * @param OrderRepository $orderRepository
     * @param $orderId
     * @param $fileId
     * @param null $oneTimeToken
     * @return mixed
     */
    public function download(OrderRepository $orderRepository, $orderId, $fileId, $oneTimeToken = null)
    {
        $url = $orderRepository->getDownloadUrl($orderId, $fileId, $oneTimeToken);
        return Redirect::to($url);
    }
}