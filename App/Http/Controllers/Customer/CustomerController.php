<?php

namespace AlistairShaw\Vendirun\App\Http\Controllers\Customer;

use AlistairShaw\Vendirun\App\Http\Controllers\VendirunBaseController;
use AlistairShaw\Vendirun\App\Lib\LocaleHelper;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\Exceptions\FailResponseException;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;
use App;
use Input;
use Mail;
use Redirect;
use Request;
use Illuminate\Http\Request as IlRequest;
use Session;
use View;

class CustomerController extends VendirunBaseController {

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Login customer
     * @param IlRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function doLogin(IlRequest $request)
    {
        $this->validate($request, [
            'email_login' => 'required|email',
            'password' => 'required'
        ]);

        return $this->login(Input::get('email_login'), Input::get('password'));
    }

    /**
     * Register a customer
     * @param IlRequest $request
     * @return mixed
     */
    public function doRegister(IlRequest $request)
    {
        $this->validate($request, [
            'full_name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:5|confirmed',
            'password_confirmation' => 'required|min:5'
        ]);

        try
        {
            VendirunApi::makeRequest('customer/store', Input::all());
            return $this->login(Input::get('email'), Input::get('password'));
        }
        catch (FailResponseException $e)
        {
            return Redirect::route(LocaleHelper::getLanguagePrefixForLocale(App::getLocale()) . 'vendirun.register')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * @param $email
     * @param $password
     * @return \Illuminate\Http\RedirectResponse
     */
    private function login($email, $password)
    {
        try
        {
            $login = VendirunApi::makeRequest('customer/login', ['email' => $email, 'password' => $password]);

            Session::flash('vendirun-alert-success', 'Login Successful');
            Session::put('token', $login->getData()->token);

            if (Session::has('action'))
            {
                $redirect = Session::get('action');

                return Redirect::to($redirect);
            }

            return Redirect::route(LocaleHelper::getLanguagePrefixForLocale(App::getLocale()) . 'vendirun.register');
        }
        catch (\Exception $e)
        {
            return Redirect::route(LocaleHelper::getLanguagePrefixForLocale(App::getLocale()) . 'vendirun.register')->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Recommend a Friend
     * @param IlRequest $request
     * @return mixed
     */
    public function recommendAFriend(IlRequest $request)
    {
        $this->validate($request, [
            'fullName' => 'required',
            'emailAddress' => 'required|email',
            'fullNameFriend' => 'required',
            'emailAddressFriend' => 'required|email',
        ]);

        $data = Input::all();
        $params['property_id'] = isset($data['propertyId']) ? $data['propertyId'] : NULL;

        $params['full_name'] = $data['fullName'];
        $params['email'] = $data['emailAddress'];

        $params['receiver_full_name'] = $data['fullNameFriend'];
        $params['receiver_email'] = $data['emailAddressFriend'];

        $params['recommend_a_friend'] = true;
        $params['recommend_a_friend_link'] = Route('vendirun.propertyView', ['id' => Request::input('propertyId'), 'propertyName' => Request::input('propertyName')]);
        $params['recommend_a_friend_link'] .= '/' . urlencode(Request::input('property'));

        $params['form_id'] = 'Recommend a Friend Form';

        try
        {
            VendirunApi::makeRequest('customer/store', $params);
        }
        catch (\Exception $e)
        {
            abort(404);
        }

        Session::flash('vendirun-alert-success', 'Thank you for recommending this page to your friend! We\'ve sent them an email on your behalf.');

        return Redirect::back();
    }

    /**
     * Process Contact form
     * @param IlRequest $request
     * @return mixed
     */
    public function processContactForm(IlRequest $request)
    {
        $this->validate($request, [
            'email' => 'required'
        ]);

        $params['full_name'] = Input::get('fullname', '');
        $params['email'] = Input::get('email', '');
        $params['telephone'] = Input::get('telephone', '');
        $params['property_id'] = Input::get('propertyId', '');
        $params['form_id'] = Input::get('formId', '');
        $params['note'] = nl2br(Input::get('message', ''));
        $params['note'] .= Input::get('property') ? "<br><br>Property Name: " . Input::get('property') : '';

        try
        {
            VendirunApi::makeRequest('customer/store', $params);
        }
        catch (\Exception $e)
        {
            abort(404);
        }

        Session::flash('vendirun-alert-success', 'Thank you for contacting us we will get back to you shortly!');

        return Redirect::back();
    }

    /**
     * @return \Illuminate\View\View
     */
    public function register()
    {
        $data = Session::all();

        $data['bodyClass'] = 'property-search';

        return View::make('vendirun::customer.register', $data);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Session::flush();

        return Redirect::route(LocaleHelper::getLanguagePrefixForLocale(App::getLocale()) . 'vendirun.register');
    }

}