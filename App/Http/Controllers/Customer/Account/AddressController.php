<?php namespace AlistairShaw\Vendirun\App\Http\Controllers\Customer\Account;

use AlistairShaw\Vendirun\App\Entities\Customer\CustomerRepository;
use AlistairShaw\Vendirun\App\Entities\Customer\Helpers\CustomerHelper;
use AlistairShaw\Vendirun\App\Http\Controllers\VendirunAuthController;
use AlistairShaw\Vendirun\App\Lib\ClientHelper;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;
use AlistairShaw\Vendirun\App\ValueObjects\Address;
use Redirect;
use Request;
use View;

class AddressController extends VendirunAuthController {

    public function add(CustomerRepository $customerRepository)
    {
        $data['pageTitle'] = trans('vendirun::customer.addAddress');

        $data['address']['countryId'] = CustomerHelper::getDefaultCountry($customerRepository);

        return View::make('vendirun::customer.account.address-add', $data);
    }

    /**
     * @param CustomerRepository $customerRepository
     * @param $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(CustomerRepository $customerRepository, $id)
    {
        $data['pageTitle'] = trans('vendirun::customer.editAddress');

        $customer = $customerRepository->find();

        $data['address'] = $customer->getAddressFromAddressId($id)->getArray();

        return View::make('vendirun::customer.account.address-edit', $data);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        VendirunApi::makeRequest('customer/deleteAddress', ['id' => $id]);

        return Redirect::route('vendirun.customer.account');
    }

    /**
     * @param CustomerRepository $customerRepository
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(CustomerRepository $customerRepository)
    {
        $customer = $customerRepository->find();

        $data = Request::all();
        $data['id'] = $data['addressId'];
        $customer->addAddress(new Address($data));

        $customerRepository->save($customer);

        return Redirect::route('vendirun.customer.account');
    }

}