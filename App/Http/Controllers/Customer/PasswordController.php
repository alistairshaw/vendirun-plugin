<?php

namespace AlistairShaw\Vendirun\App\Http\Controllers\Customer;

use AlistairShaw\Vendirun\App\Http\Controllers\VendirunBaseController;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\Exceptions\FailResponseException;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;
use Input;
use Redirect;
use Session;
use View;

class PasswordController extends VendirunBaseController {

    /**
     * @return \Illuminate\View\View
     */
    public function recovery()
    {
        // log out if logged in
        if (Session::has('token')) Session::flush();

        return View::make('vendirun::customer.password.recovery');
    }

    /**
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function processRecovery()
    {
        try
        {
            VendirunApi::makeRequest('customer/passwordRecovery', ['email' => Input::get('email')]);
            return Redirect::route('vendirun.passwordRecoveryOk');
        }
        catch (FailResponseException $e)
        {
            return View::make('vendirun::customer.password.recovery')->with('alertMessage', $e->getMessage());
        }
    }

    /**
     * @return \Illuminate\View\View
     */
    public function completeRecovery()
    {
        return View::make('vendirun::customer.password.recovery-ok');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function resetForm($token)
    {
        return View::make('vendirun::customer.password.reset-form', ['token' => $token]);
    }

    /**
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function processReset()
    {
        try
        {
            VendirunApi::makeRequest('customer/passwordReset', ['email' => Input::get('email'), 'token' => Input::get('token'), 'password' => Input::get('password')]);
            return Redirect::route('vendirun.passwordResetOk');
        }
        catch (FailResponseException $e)
        {
            return View::make('vendirun::customer.password.reset-form')->with('alertMessage', $e->getMessage())->with('token', Input::get('token'));
        }
    }

    /**
     * @return \Illuminate\View\View
     */
    public function completeReset()
    {
        return View::make('vendirun::customer.password.reset-ok');
    }
}