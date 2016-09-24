<?php namespace AlistairShaw\Vendirun\App\Http\Controllers\Customer\Account;

use AlistairShaw\Vendirun\App\Entities\Customer\CustomerRepository;
use AlistairShaw\Vendirun\App\Http\Controllers\VendirunAuthController;
use View;

class AccountController extends VendirunAuthController  {

    /**
     * @param CustomerRepository $customerRepository
     * @return \Illuminate\Contracts\View\View
     */
    public function index(CustomerRepository $customerRepository)
    {
        $data['pageTitle'] = trans('vendirun::customer.account');
        $data['customer'] = $customerRepository->find();

        return View::make('vendirun::customer.account.index', $data);
    }

}