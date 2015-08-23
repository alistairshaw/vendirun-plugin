<?php

namespace AlistairShaw\Vendirun\App\Http\Controllers\Customer;

use AlistairShaw\Vendirun\App\Http\Controllers\VendirunBaseController;
use AlistairShaw\Vendirun\App\Lib\Mailer;
use Config;
use Input;
use Mail;
use Redirect;
use Request;
use Session;
use Validator;
use View;

class CustomerController extends VendirunBaseController {

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Login customer
     */
    public function doLogin()
    {
        $rules = [
            'email_login' => 'required',
            'password' => 'required',
        ];

        $validationResult = $this->validateForm($rules, Input::all());

        if (!$validationResult['success'])
        {
            Session::flash('vendirun-alert-error', 'Incorrect username or password please try again!');

            return Redirect::back();
        }

        $vars['email'] = $_POST['email_login'];
        $vars['password'] = $_POST['password'];

        $response = $this->customerApi->login($vars);

        if ($response['success'] == 1)
        {
            Session::flash('vendirun-alert-success', 'Login Successful');
            Session::put('token', $response['data']);

            if (Session::has('action'))
            {
                $redirect = Session::get('action');

                return Redirect::to($redirect);
            }

            return Redirect::route('vendirun.register');
        }
        else
        {
            Session::flash('vendirun-alert-error', $response['error']);

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
            'full_name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:5|confirmed',
            'password_confirmation' => 'required|min:5'
        ];

        $validationResult = $this->validateForm($rules, Input::all());

        if (!$validationResult['success'])
        {
            return Redirect::back()->with('errors', $validationResult['errors'])->withInput();
        }

        $response = $this->customerApi->store($_POST);

        if ($response['success'])
        {
            $vars['email'] = $_POST['email'];
            $vars['password'] = $_POST['password'];

            $loginResponse = $this->customerApi->login($vars);

            if ($loginResponse['success'])
            {
                Session::flash('vendirun-alert-success', 'Login Successful');
                Session::put('token', $loginResponse['data']);

                if (Session::get('action'))
                {
                    return Redirect::to(Session::get('action'));
                }

                return Redirect::route('vendirun.home');
            }
            else
            {
                Session::flash('vendirun-alert-error', $loginResponse['error']);

                return Redirect::route('vendirun.register')->withInput();
            }
        }
        else
        {
            if ($response['api_failure'] == 1)
            {
                $vars = $_POST;
                unset($vars['password']);
                unset($vars['password_confirmation']);
                $this->apiSubmissionFailed('register', $vars);
            }

            Session::flash('vendirun-alert-error', $response['error']);

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
            'fullName' => 'required',
            'emailAddress' => 'required|email',
            'fullNameFriend' => 'required',
            'emailAddressFriend' => 'required|email',
        ];

        $validationResult = $this->validateForm($rules, Input::all());

        if (!$validationResult['success']) return Redirect::back()->with('errors', $validationResult['errors'])->withInput();

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

        $response = $this->customerApi->store($params);

        if (!$response['success']) $this->apiSubmissionFailed('recommend-friend', $data);
        Session::flash('vendirun-alert-success', 'Thank you for recommending this page to your friend! We\'ve sent them an email on your behalf.');

        return Redirect::back();
    }

    /**
     * Process Contact form
     * @return mixed
     */
    public function processContactForm()
    {
        $rules = [
            'email' => 'required'
        ];

        $validationResult = $this->validateForm($rules, Input::all());
        if (!$validationResult['success'])
        {
            return Redirect::back()->with('errors', $validationResult['errors']);
        }

        $data = Input::all();
        $params['full_name'] = Input::get('fullname', '');
        $params['email'] = Input::get('email', '');
        $params['telephone'] = Input::get('telephone', '');
        $params['property_id'] = Input::get('propertyId', '');
        $params['form_id'] = Input::get('formId', '');
        $params['note'] = nl2br(Input::get('message', ''));
        $params['note'] .= Input::get('property') ? "<br><br>Property Name: " . Input::get('property') : '';

        $response = $this->customerApi->store($params);

        if (!$response['success'])
        {
            if ($response['api_failure'])
            {
                unset($data['_token']);
                $this->apiSubmissionFailed('contact-form', $data);
            }
        }

        Session::flash('vendirun-alert-success', 'Thank you for contacting us we will get back to you shortly!');

        return Redirect::back();
    }

    /**
     * @param $action
     * @param $data
     */
    private function apiSubmissionFailed($action, $data)
    {
        switch ($action)
        {
            case 'contact-form':
                $subjectLine = 'Someone contacted you from your website';
                $view = 'vendirun::emails.failures.contact-form';
                break;
            case 'register':
                $subjectLine = 'Someone attempted to register on your website';
                $view = 'vendirun::emails.failures.register';
                break;
            case 'recommend-friend':
                $subjectLine = 'Someone attempted to recommed a friend to a page on your website';
                $view = 'vendirun::emails.failures.recommend-friend';
                break;
            default:
                $subjectLine = 'An unknown error occurred';
                $view = 'vendirun::emails.failures.default';
        }

        $data['mailData'] = $data;
        $mailer = new Mailer();
        Mail::send($view, $data, function($message)
        {
            $message->from(Config('vendirun.emailsFrom'), Config('vendirun.emailsFromName'));
            $message->to(Config('vendirun.backupEmail'))->subject('');
            $message->cc(Config('vendirun.vendirunSupportEmail'), 'Vendirun Support');
        });
        $mailer->sendMail(Config('vendirun.backupEmail'), $subjectLine, $data, $view);
    }

    /**
     * Validates a form
     * @param array $rules Rules for validation
     * @param array $data  Form Data.
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