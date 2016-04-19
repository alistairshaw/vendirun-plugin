<?php namespace AlistairShaw\Vendirun\App\Http\Composers;

use AlistairShaw\Vendirun\App\Entities\Customer\Helpers\CustomerHelper;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;
use Illuminate\View\View;
use Session;

class CustomerViewComposer {

    /**
     * @param View $view
     */
    public function customerDetails($view)
    {
        // check if token exists and confirm login
        if ($token = CustomerHelper::checkLoggedinCustomer())
        {
            $loggedIn = VendirunApi::makeRequest('customer/tokenAuth', ['token' => $token]);
            if ($loggedIn->getSuccess())
            {
                $data = $loggedIn->getData();
                $view->with('loggedInName', $data->name);
                $view->with('loggedInEmail', $data->name);
            }
            else
            {
                Session::remove('token');
            }
        }
    }

    /**
     * @param View $view
     */
    public function address($view)
    {
        $viewData = $view->getData();

        $address = [
            'address1' => '',
            'address2' => '',
            'address3' => '',
            'city' => '',
            'state' => '',
            'postcode' => '',
            'country_id' => ''
        ];

        if (isset($viewData['address']) && $viewData['address'])
        {
            foreach ($viewData['address'] as $key => $value)
            {
                $address[$key] = $value;
            }
        }

        $view->with('address', $address);
        if (!isset($viewData['prefix'])) $view->with('prefix', '');
    }
}