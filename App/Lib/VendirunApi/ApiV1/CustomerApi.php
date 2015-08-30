<?php namespace AlistairShaw\Vendirun\App\Lib\VendirunApi\ApiV1;

use AlistairShaw\Vendirun\App\Lib\VendirunApi\Exceptions\FailResponseException;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\Exceptions\InvalidApiRequestException;

class CustomerApi extends BaseApi {

	/**
	 * Process Form
	 * @param $params
	 * @param $params ['full_name']
	 * @param $params ['email']        required!
	 * @param $params ['telephone']
	 */
	function store($params)
	{
		$url = 'customer/store';
        try
        {
            $this->request($url, $params, true);
        }
        catch (\Exception $e)
        {
            unset($params['_token']);
            unset($params['password']);
            unset($params['password_confirmation']);
            $this->apiSubmissionFailed('contact-form', $params);
        }
	}

	/**
	 * @param array $params
	 * @return array
	 */
	function login($params)
	{
		$url = 'customer/login';
		return $this->request($url, $params, true);
	}

    /**
     * @param $params
     * @return array
     */
	function tokenAuth($params)
	{
		$url = 'customer/token_auth';
		return $this->request($url, ['token' => $params['token']], true);
	}

}
