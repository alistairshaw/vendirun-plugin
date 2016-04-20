<?php

namespace AlistairShaw\Vendirun\App\Http\Controllers\Customer;

use AlistairShaw\Vendirun\App\Events\CustomerLoggedIn;
use AlistairShaw\Vendirun\App\Http\Controllers\VendirunBaseController;
use AlistairShaw\Vendirun\App\Lib\LocaleHelper;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\Exceptions\FailResponseException;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;
use App;
use Config;
use Event;
use League\Flysystem\Adapter\Local;
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
        Session::remove('token');
        if (Session::has('primaryPagePath')) return Redirect::to(Session::get('primaryPagePath'));

        return Redirect::route(LocaleHelper::localePrefix() . 'vendirun.home');
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

        $r = $this->login(Request::get('email_login'), Request::get('password'));

        return $r;
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

        // check if we need to verify the email address first
        $clientInfo = Config::get('clientInfo');
        if ($clientInfo->signup_email_verification) return $this->doEmailVerification(Request::all());

        try
        {
            VendirunApi::makeRequest('customer/store', Request::all());
            return $this->login(Request::get('email'), Request::get('password'));
        }
        catch (FailResponseException $e)
        {
            return Redirect::route(LocaleHelper::localePrefix() . 'vendirun.register')->withInput()->withErrors($e->getMessage());
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

            Event::fire(new CustomerLoggedIn($login->getData()->token));

            Session::flash('vendirun-alert-success', 'Login Successful');
            Session::put('token', $login->getData()->token);
            Session::save();

            if (Session::has('attemptedAction'))
            {
                $redirect = Session::get('attemptedAction');
                return redirect($redirect);
            }

            if (Session::has('primaryPagePath')) return Redirect::to(Session::get('primaryPagePath'));

            return Redirect::route(LocaleHelper::localePrefix() . 'vendirun.home');
        }
        catch (FailResponseException $e)
        {
            return Redirect::route(LocaleHelper::localePrefix() . 'vendirun.register')->withInput()->withErrors('Invalid Username or Password');
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

        $data = Request::all();
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

        $params['full_name'] = Request::get('fullname', '');
        $params['email'] = Request::get('email', '');
        $params['telephone'] = Request::get('telephone', '');
        $params['property_id'] = Request::get('propertyId', '');
        $params['form_id'] = Request::get('formId', '');
        $params['note'] = nl2br(Request::get('message', ''));
        $params['note'] .= Request::get('property') ? "<br><br>Property Name: " . Request::get('property') : '';

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
     * @return \Illuminate\Contracts\View\View
     */
    public function emailConfirm()
    {
        return View::make('vendirun::customer.email-confirm');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function emailConfirmAction()
    {
        try
        {
            $params = VendirunApi::makeRequest('customer/verifyEmailData', ['id' => Request::get('confirmId')])->getData();

            VendirunApi::makeRequest('customer/store', $params);
            return $this->login($params->email, $params->password);
        }
        catch (FailResponseException $e)
        {
            return Redirect::route(LocaleHelper::localePrefix() . 'vendirun.register')->withErrors($e->getMessage());
        }
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function noPermissions()
    {
        return View::make('vendirun::customer.no-permissions');
    }

    /**
     * @param $callbackData
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    private function doEmailVerification($callbackData)
    {
        try
        {
            $params = [
                'email' => $callbackData['email'],
                'callback_url' => route(LocaleHelper::localePrefix() . 'vendirun.emailConfirmAction'),
                'callback_data' => json_encode($callbackData)
            ];

            VendirunApi::makeRequest('customer/verifyEmail', $params);
            return Redirect::route(LocaleHelper::localePrefix() . 'vendirun.emailConfirm');
        }
        catch (FailResponseException $e)
        {
            return Redirect::route(LocaleHelper::localePrefix() . 'vendirun.register')->withInput()->withErrors($e->getMessage());
        }
    }

}