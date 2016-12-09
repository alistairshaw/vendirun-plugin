<?php namespace AlistairShaw\Vendirun\App\Http\Controllers\Customer\Account;

use AlistairShaw\Vendirun\App\Entities\Customer\CustomerRepository;
use AlistairShaw\Vendirun\App\Entities\Customer\Helpers\CustomerHelper;
use AlistairShaw\Vendirun\App\Entities\Order\Aggregates\OrderStatus;
use AlistairShaw\Vendirun\App\Entities\Order\OrderRepository;
use AlistairShaw\Vendirun\App\Http\Controllers\VendirunAuthController;
use Illuminate\Pagination\LengthAwarePaginator;
use Redirect;
use Request;
use View;

class OrderController extends VendirunAuthController {

    /**
     * @param OrderRepository $orderRepository
     * @return \Illuminate\Contracts\View\View
     */
    public function index(OrderRepository $orderRepository)
    {
        $page = Request::get('page', 1);
        $limit = Request::get('limit', 5);
        $offset = ($page - 1) * $limit;
        $orderSearchResult = $orderRepository->search(CustomerHelper::checkLoggedinCustomer(), Request::get('search', ''), $limit, $offset);
        $pagination = ($orderSearchResult->getTotalRows() > 0) ? $pagination =
            new LengthAwarePaginator(
                $orderSearchResult->getOrders(),
                $orderSearchResult->getTotalRows(),
                $orderSearchResult->getLimit(),
                Request::get('page'),
                [
                    'path'  => Request::url(),
                    'query' => Request::query()
                ]
            ) : false;

        $data['pageTitle'] = trans('vendirun::product.orderHistory');

        $data['orders'] = $orderSearchResult->getOrders();
        $data['pagination'] = $pagination;

        return View::make('vendirun::customer.orders.index', $data);
    }

    /**
     * @param OrderRepository $orderRepository
     * @param CustomerRepository $customerRepository
     * @param $orderId
     * @return \Illuminate\Contracts\View\View
     */
    public function view(OrderRepository $orderRepository, CustomerRepository $customerRepository, $orderId)
    {
        $data['customer'] = $customerRepository->find();
        $data['order'] = $orderRepository->find($orderId);
        $data['defaultAddress'] = $data['order']->getBillingAddress();
        $data['pageTitle'] = trans('vendirun::product.viewOrder');

        return View::make('vendirun::customer.orders.view', $data);
    }

    /**
     * @param OrderRepository $orderRepository
     * @param $orderId
     * @param $fileId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function download(OrderRepository $orderRepository, $orderId, $fileId)
    {
        $url = $orderRepository->getDownloadUrl($orderId, $fileId);
        return Redirect::to($url);
    }
}