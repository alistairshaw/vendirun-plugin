<?php namespace AlistairShaw\Vendirun\App\Lib\VendirunApi\ApiV1;

use AlistairShaw\Vendirun\App\Lib\VendirunApi\Exceptions\FailResponseException;

class CustomerApi extends BaseApi {

    /**
     * Process Form
     * @param $params
     * @param $params ['full_name']
     * @param $params ['email']        required!
     * @param $params ['telephone']
     * @return object
     * @throws FailResponseException
     */
	public function store($params)
	{
        $url = 'customer/store';
        return $this->request($url, $params, true);
	}

    /**
     * @param $params
     * @return object
     */
	public function update($params)
    {
        $url = 'customer/update/' . $params['id'];
        return $this->request($url, $params, true);
    }

    /**
     * @param $params
     * @return object
     */
    public function find($params)
    {
        $url = 'customer/find/' . $params['token'];
        return $this->request($url, $params);
    }

	/**
	 * @param array $params
	 * @return object
	 */
	public function login($params)
	{
		$url = 'customer/login';
		return $this->request($url, $params, true);
	}

    /**
     * @param $params
     * @return object
     * @throws FailResponseException
     */
    public function recommendFriend($params)
    {
        $url = 'customer/recommend_friend';
        return $this->request($url, $params, true);
    }

    /**
     * @param $params
     * @return object
     * @throws FailResponseException
     */
    public function addNote($params)
    {
        $url = 'customer/add_note';
        return $this->request($url, $params, true);
    }

    /**
     * @param $params
     * @return object
     * @throws FailResponseException
     */
    public function registerFormCompletion($params)
    {
        // params: customer_id, new_customer, data, form_id
        $url = 'customer/register_form_completion';
        return $this->request($url, $params, true);
    }

    /**
     * @param $params
     * @return object
     */
	public function tokenAuth($params)
	{
		$url = 'customer/token_auth';
		return $this->request($url, ['token' => $params['token']], true);
	}

    /**
     * @param $params
     * @return object
     */
	public function passwordRecovery($params)
    {
        $url = 'customer/password_recovery';
        return $this->request($url, $params, true);
    }

    /**
     * @param $params
     * @return object
     */
	public function passwordReset($params)
    {
        $url = 'customer/password_reset';
        return $this->request($url, $params, true);
    }

    /**
     * @param $params
     * @return object
     * @throws FailResponseException
     */
    public function verifyEmail($params)
    {
        $url = 'customer/verify_email';
        return $this->request($url, $params, true);
    }

    /**
     * @param $params
     * @return object
     * @throws FailResponseException
     */
    public function verifyEmailData($params)
    {
        $url = 'customer/get_email_verification_data/' . $params['id'];
        return $this->request($url, $params);
    }

    /**
     * @param $params
     * @return object
     */
    public function deleteAddress($params)
    {
        $url = 'customer/delete_address/' . $params['id'];
        return $this->request($url, $params);
    }
}
