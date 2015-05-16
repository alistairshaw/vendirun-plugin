<?php

namespace Ambitiousdigital\Vendirun\Controllers\Customer;

use Ambitiousdigital\Vendirun\Controllers\VendirunBaseController;
use Ambitiousdigital\Vendirun\Lib\CustomerApi;
use Ambitiousdigital\Vendirun\Lib\Mailer;
use Input;
use Redirect;
use Request;
use Session;
use Validator;
use View;

class CustomerController extends VendirunBaseController {

	/**
	 * @var CustomerApi
	 */
	private $customerApi;

	public function __construct()
	{
		parent::__construct();
		$this->customerApi = new CustomerApi(config('vendirun.apiKey'), config('vendirun.clientId'), config('vendirun.apiEndPoint'));
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

		if ( ! $validationResult['success'])
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
		$rules = [
			'full_name'             => 'required',
			'email'                 => 'required|email',
			'password'              => 'required|min:3|confirmed',
			'password_confirmation' => 'required|min:3'
		];

		$validationResult = $this->validateForm($rules, Input::all());

		if ( ! $validationResult['success'])
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
			'fullNameFriend'     => 'required',
			'emailAddressFriend' => 'required|email',
		];

		$validationResult = $this->validateForm($rules, Input::all());

		if ( ! $validationResult['success']) return Redirect::back()->with('showModal', 1)->with('errors', $validationResult['errors'])->withInput();

		$data                  = Input::all();
		$params['property_id'] = isset($data['propertyId']) ? $data['propertyId'] : null;

		$params['full_name'] = $data['fullName'];
		$params['email']     = $data['emailAddress'];

		$params['receiver_full_name'] = $data['fullNameFriend'];
		$params['receiver_email']     = $data['emailAddressFriend'];

		$params['recommend_a_friend']      = true;
		$params['recommend_a_friend_link'] = Route('vendirun.propertyView', ['id' => Request::input('propertyId'), 'propertyName' => Request::input('propertyName')]);
		$params['recommend_a_friend_link'] .= '/' . urlencode(Request::input('property'));

		$params['form_id'] = 'Recommend a Friend Form';

		$response = $this->customerApi->store($params);

		if ( ! $response['success']) $this->apiSubmissionFailed('recommend-friend', $data);
		Session::flash('vendirun-alert-success', 'Thank you for recommending this page to your friend! We\'ve sent them an email on your behalf.');

		return Redirect::back();
	}

	/**
	 * @param $action
	 * @param $data
	 */
	private function apiSubmissionFailed($action, $data)
	{
		$subjectLine = '';
		$view        = '';

		switch ($action)
		{
			case 'recommend-friend-sender':
				$subject = '';
				$view    = 'vendirun::emails.contact_mail';
				break;
			case 'recommend-friend-receiver':
				$view = 'vendirun::emails.contact_mail';
				break;
		}

		// only send an email if we have subject line
		if ($subjectLine !== '')
		{
			$data['mailData'] = $data;
			$mailer           = new Mailer();
			$mailer->sendMail(config('mail.from'), $subjectLine, $data, $view);
		}
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
		if ( ! $validationResult['success'])
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

		if ( ! $response['success'])
		{
			if ($response['api_failure'])
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
	 * @param array $rules Rules for validation
	 * @param array $data Form Data.
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