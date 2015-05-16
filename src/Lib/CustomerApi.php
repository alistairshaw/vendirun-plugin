<?php namespace Ambitiousdigital\Vendirun\Lib;

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
		$this->request($url, $params, true);

		return $this->getResult();
	}

	/**
	 * @param array $params
	 * @return mixed
	 */
	function login($params)
	{
		$url = 'customer/login';
		$this->request($url, $params, true);

		return $this->getResult();
	}

	/**
	 * @param $token
	 * @return mixed
	 */
	function tokenAuth($token)
	{
		$url = 'customer/token_auth';
		$this->request($url, ['token' => $token], true);

		return $this->getResult();
	}
}
