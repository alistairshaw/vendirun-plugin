<?php

namespace AlistairShaw\Vendirun\App\Http\Controllers\Customer;

use AlistairShaw\Vendirun\App\Entities\Customer\Helpers\CustomerHelper;
use AlistairShaw\Vendirun\App\Http\Controllers\VendirunBaseController;
use AlistairShaw\Vendirun\App\Lib\LocaleHelper;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\Exceptions\FailResponseException;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;
use Redirect;
use Request;
use Session;
use View;

class PasswordController extends VendirunBaseController {

    /**
     * @return \Illuminate\View\View
     */
    public function recovery()
    {
        // log out if logged in
        if (CustomerHelper::checkLoggedinCustomer()) Session::flush();

        $data['pageTitle'] = trans('vendirun::customer.recoverPassword');

        return View::make('vendirun::customer.password.recovery', $data);
    }

    /**
     * @return mixed
     */
    public function processRecovery()
    {
        try
        {
            VendirunApi::makeRequest('customer/passwordRecovery', ['email' => Request::get('email')]);
            return Redirect::route(LocaleHelper::localePrefix() . 'vendirun.passwordRecoveryOk');
        }
        catch (FailResponseException $e)
        {
            $data['pageTitle'] = trans('vendirun::customer.recoverPassword');
            $data['alertMessage'] = trans('vendirun::customer.recoverPasswordFail');
            return View::make('vendirun::customer.password.recovery', $data);
        }
    }

    /**
     * @return \Illuminate\View\View
     */
    public function completeRecovery()
    {
        $data['pageTitle'] = trans('vendirun::customer.recoverPassword');

        return View::make('vendirun::customer.password.recovery-ok', $data);
    }

    /**
     * @param $token
     * @return \Illuminate\View\View
     */
    public function resetForm($token)
    {
        $data['pageTitle'] = trans('vendirun::customer.recoverPassword');
        $data['token'] = $token;

        return View::make('vendirun::customer.password.reset-form', $data);
    }

    /**
     * @return mixed
     */
    public function processReset()
    {
        try
        {
            VendirunApi::makeRequest('customer/passwordReset', ['email' => Request::get('email'), 'token' => Request::get('token'), 'password' => Request::get('password')]);
            return Redirect::route(LocaleHelper::localePrefix() . 'vendirun.passwordResetOk');
        }
        catch (FailResponseException $e)
        {
            $data['pageTitle'] = trans('vendirun::customer.recoverPassword');
            $data['alertMessage'] = trans('vendirun::customer.recoverPasswordFail2');
            $data['token'] = Request::get('token');
            return View::make('vendirun::customer.password.reset-form', $data);
        }
    }

    /**
     * @return \Illuminate\View\View
     */
    public function completeReset()
    {
        $data['pageTitle'] = trans('vendirun::customer.recoverPassword');

        return View::make('vendirun::customer.password.reset-ok', $data);
    }
}