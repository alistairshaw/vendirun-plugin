<?php namespace AlistairShaw\Vendirun\App\Http\Composers;

use AlistairShaw\Vendirun\App\Entities\Customer\Helpers\CustomerHelper;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;
use AlistairShaw\Vendirun\App\ValueObjects\Address;
use Illuminate\View\View;
use Request;
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
            'id' => '',
            'address1' => '',
            'address2' => '',
            'address3' => '',
            'city' => '',
            'state' => '',
            'postcode' => '',
            'countryId' => ''
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

    /**
     * @param $view
     * @return mixed
     */
    public function accountNav($view)
    {
        $nav_selected = 'account';

        if (strstr(Request::path(), 'customer/account/orders')) $nav_selected = 'orders';

        return $view->with('navSelected', $nav_selected);
    }

    /**
     * @param $view
     * @return mixed
     */
    public function addressSelect($view)
    {
        $viewData = $view->getData();

        $showSelector = isset($viewData['showSelector']) ? $viewData['showSelector'] : true;
        $prefix = isset($viewData['prefix']) ? $viewData['prefix'] : '';
        $defaultAddress = isset($viewData['defaultAddress']) ? $viewData['defaultAddress'] : new Address([]);

        return $view->with('prefix', $prefix)->with('defaultAddress', $defaultAddress)->with('showSelector', $showSelector);
    }
}