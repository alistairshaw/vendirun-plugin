<?php

namespace AlistairShaw\Vendirun\App\Http\Controllers\Customer;

use AlistairShaw\Vendirun\App\Entities\Customer\CustomerFactory;
use AlistairShaw\Vendirun\App\Entities\Customer\CustomerRepository;
use AlistairShaw\Vendirun\App\Events\CustomerLoggedIn;
use AlistairShaw\Vendirun\App\Exceptions\CustomerNotFoundException;
use AlistairShaw\Vendirun\App\Http\Controllers\VendirunBaseController;
use AlistairShaw\Vendirun\App\Lib\LocaleHelper;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\Exceptions\FailResponseException;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;
use App;
use Cache;
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
        $data['pageTitle'] = trans('vendirun::forms.register');

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
     * @param CustomerRepository $customerRepository
     * @return mixed
     */
    public function recommendAFriend(IlRequest $request, CustomerRepository $customerRepository)
    {
        $this->validate($request, [
            'fullName' => 'required',
            'emailAddress' => 'required|email',
            'fullNameFriend' => 'required',
            'emailAddressFriend' => 'required|email',
        ]);

        $params['property_id'] = Request::get('property_id', null);
        $params['product_id'] = Request::get('product_id', null);

        // generate correct link
        $link = route(LocaleHelper::localePrefix() . 'vendirun.home');
        if (Request::has('propertyId'))
        {
            $link = route(LocaleHelper::localePrefix() . 'vendirun.propertyView', ['id' => Request::get('propertyId'), 'name' => htmlentities(Request::get('property'))]);
        }
        if (Request::has('productId'))
        {
            $link = route(LocaleHelper::localePrefix() . 'vendirun.productView', ['id' => Request::get('productId'), 'name' => htmlentities(Request::get('product'))]);
        }

        $customerFactory = new CustomerFactory();
        try
        {
            $originator = $customerRepository->find();
        }
        catch (CustomerNotFoundException $e)
        {
            $originator = $customerFactory->make(null, Request::get('fullName'), Request::get('emailAddress'));
            $customerRepository->save($originator);
        }

        $receiver = $customerFactory->make(null, Request::get('fullNameFriend'), Request::get('emailAddressFriend'));

        $customerRepository->save($receiver);

        try
        {
            $customerRepository->recommendFriend($originator, $receiver, $link);
            Session::flash('vendirun-alert-success', 'Thank you for recommending this page to your friend! We\'ve sent them an email on your behalf.');
        }
        catch (FailResponseException $e)
        {
            Session::flash('vendirun-alert-error', 'Unable to send email to your friend. Please try again.');
        }

        return Redirect::back();
    }

    /**
     * Process Contact form
     * @param IlRequest $request
     * @param CustomerRepository $customerRepository
     * @return mixed
     */
    public function processContactForm(IlRequest $request, CustomerRepository $customerRepository)
    {
        $this->validate($request, [
            'email' => 'required'
        ]);

        // we will always make a new customer on contact forms, in case the form values are wildly different from the logged in user's details
        $customerFactory = new CustomerFactory();
        $customer = $customerFactory->make(null, Request::get('fullname'), Request::get('email'));
        $customer->setPrimaryTelephone(Request::get('telephone', null));
        $customerRepository->save($customer);

        if (Request::has('propertyId'))
        {
            VendirunApi::makeRequest('property/addToFavourite', ['customer_id' => $customer->getId(), 'property_id' => Request::get('propertyId')]);
            Cache::forget('favourites-' . Session::get('token'));
        }

        $note = '';
        if (Request::has('property')) $note .= "<strong>Property Name: " . Request::get('property') . '</strong><br>';
        if (Request::has('product')) $note .= "<strong>Product Name: " . Request::get('product') . '</strong><br>';
        $note .= nl2br(Request::get('message', ''));

        VendirunApi::makeRequest('customer/addNote', ['customer_id' => $customer->getId(), 'note' => $note]);
        VendirunApi::makeRequest('customer/registerFormCompletion', [
            'customer_id' => $customer->getId(),
            'new_customer' => 1,
            'data' => json_encode(Request::all()),
            'form_id' => Request::get('formId', 'Website Form')
        ]);

        Session::flash('vendirun-alert-success', 'Thank you for contacting us we will get back to you shortly!');

        return Redirect::back();
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function emailConfirm()
    {
        $data['pageTitle'] = trans('vendirun::customer.emailConfirmation');

        return View::make('vendirun::customer.email-confirm', $data);
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
        $data['pageTitle'] = trans('vendirun::customer.noPermissionsTitle');

        return View::make('vendirun::customer.no-permissions', $data);
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