<?php

namespace Ambitiousdigital\Vendirun\Controllers;

use Ambitiousdigital\Vendirun\BaseController;

use Ambitiousdigital\Vendirun\Lib\CustomerApi;
use Ambitiousdigital\Vendirun\Lib\Mailer;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class CustomerController extends BaseController
{
	/**
	 * @var CustomerApi
	 */
	private $customerApi;

	public function __construct()
	{
		View::addNamespace('vendirun', app('path') . '/vendirun/views/');
		$this->customerApi = new CustomerApi();
	}

	/**
	 * Login customer
	 */
	public function doLogin()
	{

		$rules = [
			'email_login' => 'required',
			'password'    => 'required',
		];

		$validationResult = $this->validateForm($rules, Input::all());

		if (!$validationResult['success'])
		{
			Session::flash('alert_message_failure', 'Incorrect username or password please try again!');
			return Redirect::back();
		}


		$vars['email']    = $_POST['email_login'];
		$vars['password'] = $_POST['password'];

		$response = $this->customerApi->login($vars);
		if ($response['success'] == 1)
		{
			Session::flash('alert_message_success', 'Login Successful');
			Session::put('token', $response['data']);

			if (Session::get('action'))
			{
				return Redirect::to(Session::get('action'));
			}

			return Redirect::route('vendirun.register');
		}
		else
		{
			Session::flash('alert_message_failure', $response['error']);
			return Redirect::route('vendirun.register')->withInput();
		}

	}

	/**
	 * Register a customer
	 * @return mixed
	 */
	public function doRegister()
	{
		$setApiFailureError = "";

		$rules = [
			'full_name'             => 'required',
			'email'                 => 'required|email',
			'password'              => 'required|min:3|confirmed',
			'password_confirmation' => 'required|min:3'
		];

		$validationResult = $this->validateForm($rules, Input::all());

		if (!$validationResult['success'])
		{
			return Redirect::back()->with('errors', $validationResult['errors'])->withInput();
		}

		$response = $this->customerApi->store($_POST);

		if ($response['success'])
		{

			$vars['email']    = $_POST['email'];
			$vars['password'] = $_POST['password'];

			$response = $this->customerApi->login($vars);

			if ($response['success'] == 1)
			{
				Session::flash('alert_message_success', 'Login Successful');
				Session::put('token', $response['data']);

				if (Session::get('action'))
				{
					return Redirect::to(Session::get('action'));
				}

				return Redirect::route('vendirun.register');
			}
			else
			{
				Session::flash('alert_message_failure', $response['error']);
				return Redirect::route('vendirun.register')->withInput();
			}
		}
		else
		{


			if ($response['api_failure'] == 1)
			{
				unset($_POST['password']);
				unset($_POST['password_confirmation']);
				$data['mailData'] = $_POST;
				$mailer           = new Mailer();
				$mailer->sendMail($_ENV['EMAIL'], 'Registration', $data, 'vendirun::emails.contact_mail');
			}

			Session::flash('alert_message_failure', $response['error']);
			return Redirect::route('vendirun.register')->withInput();
		}

	}

	/**
	 * Recommend a Friend
	 * @return mixed
	 */
	public function recommendAFriend()
	{
		$rules = [
			'fullName'           => 'required',
			'emailAddress'       => 'required|email',
			'telephone'          => 'required',
			'fullNameFriend'     => 'required',
			'emailAddressFriend' => 'required|email',
			'telephoneFriend'    => 'required'
		];

		$validationResult = $this->validateForm($rules, Input::all());

		if (!$validationResult['success'])
		{
			return Redirect::back()->with('showModal', 1)->with('errors', $validationResult['errors'])->withInput();
		}

		$data                  = Input::all();
		$params['full_name']   = $data['fullName'];
		$params['email']       = $data['emailAddress'];
		$params['telephone']   = $data['telephone'];
		$params['property_id'] = $data['propertyId'];
		$params['form_id']     = $data['formId'];
		$params['note']        = isset($data['property']) ? "\n\nProperty Name: " . $data['property'] : '';
		$response              = $this->customerApi->store($params);

		$customerData = array();

		if (!$response['success'])
		{
			if ($response['api_failure'])
			{
				$data['mailData'] = $params;
				$mailer           = new Mailer();
				$mailer->sendMail($_ENV['EMAIL'], 'Recommend a Friend (Recommended By)', $data, 'vendirun::emails.contact_mail');
			}
		}
		else
		{
			$customerData = $response['data'];
		}

		$data                   = Input::all();
		$params['full_name']    = $data['fullNameFriend'];
		$params['email']        = $data['emailAddressFriend'];
		$params['telephone']    = $data['telephoneFriend'];
		$params['property_id']  = $data['propertyId'];
		$params['form_id']      = $data['formId'];
		$params['recommend_by'] = isset($customerData->id) ? $customerData->id : '';
		$params['note']         = isset($data['property']) ? "\n\nProperty Name: " . $data['property'] : '';
		$response               = $this->customerApi->store($params);


		if (!$response['success'])
		{
			if ($response['api_failure'])
			{
				$data['mailData'] = $params;
				$mailer           = new Mailer();
				$mailer->sendMail($_ENV['EMAIL'], 'Recommend a Friend', $data, 'vendirun::emails.contact_mail');
			}
		}
		else
		{
			$customerData = $response['data'];
		}


		Session::flash('alert_message_recommend_a_friend', 'Thank you for recommending your friend we will be in touch shortly.');
		return Redirect::back();

	}

	/**
	 * Process Contact form
	 * @return mixed
	 */
	public function processContactForm()
	{

		$rules = [
			'fullName'     => 'required',
			'emailAddress' => 'required|email',
			'telephone'    => 'required'
		];

		$validationResult = $this->validateForm($rules, Input::all());
		if (!$validationResult['success'])
		{
			return Redirect::back()->with('errors', $validationResult['errors']);
		}

		$data                  = Input::all();
		$params['full_name']   = $data['fullName'];
		$params['email']       = $data['emailAddress'];
		$params['telephone']   = $data['telephone'];
		$params['note']        = $data['message'];
		$params['property_id'] = isset($data['propertyId']) ? $data['propertyId'] : '';
		$params['form_id']     = $data['formId'];
		$params['note'] .= isset($data['property']) ? "\n\nProperty Name: " . $data['property'] : '';
		$params['note'] .= isset($data['message']) ? $data['message'] : '';

		$response = $this->customerApi->store($params);

		if (!$response['success'])
		{
			if($response['api_failure'])
			{
				$data['mailData'] = $params;
				$mailer           = new Mailer();
				$mailer->sendMail($_ENV['EMAIL'], 'Contact Form', $data, 'vendirun::emails.contact_mail');
			}

		}

		Session::flash('alert_message_success', 'Thank you for contacting us we will get back to you shortly!');
		return Redirect::back();
	}

	/**
	 * Validates a form
	 * @param $rules Rules for validation
	 * @param $data  Form Data.
	 * @return array
	 */
	private function validateForm($rules, $data)
	{
		$validator = Validator::make($data, $rules);
		if ($validator->fails())
		{
			return ['success' => false, 'errors' => $validator->messages()];
		}
		return ['success' => true];
	}

	/**
	 * Loads Register / Login page.
	 * @return mixed
	 */
	public function register()
	{
		$data = Session::all();

		$data['bodyClass'] = 'property-search';
		return View::make('vendirun::customer.register', $data);
	}

	public function logout()
	{
		Session::flush();

		return Redirect::route('vendirun.register');
	}

}