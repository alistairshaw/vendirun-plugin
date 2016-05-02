<?php namespace AlistairShaw\Vendirun\App\Http\Controllers\Customer\Account;

use AlistairShaw\Vendirun\App\Entities\Customer\CustomerRepository;
use AlistairShaw\Vendirun\App\Entities\Customer\Helpers\CustomerHelper;
use AlistairShaw\Vendirun\App\Entities\Order\OrderRepository;
use AlistairShaw\Vendirun\App\Http\Controllers\VendirunBaseController;
use Illuminate\Pagination\LengthAwarePaginator;
use Request;
use View;

class OrderController extends VendirunBaseController {

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

        return View::make('vendirun::customer.orders.index')
            ->with('orders', $orderSearchResult->getOrders())
            ->with('pagination', $pagination);
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

        return View::make('vendirun::customer.orders.view', $data);
    }

}