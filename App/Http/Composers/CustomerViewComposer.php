<?php namespace AlistairShaw\Vendirun\App\Http\Composers;

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
        if (Session::has('token'))
        {
            $token = Session::get('token');

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

}