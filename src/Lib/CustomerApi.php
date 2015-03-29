<?php
/**
 * Created by PhpStorm.
 * User: Alistair
 * Date: 15/11/2014
 * Time: 22:51
 */
namespace Ambitiousdigital\Vendirun\Lib;

class CustomerApi extends BaseApi
{
	/**
	 * Process Form
	 * @param $params
	 * @param $params['full_name']	required!
	 * @param $params['email']		required!
	 * @param $params['telephone']	required!
	 */
	function store($params)
	{
		$url = 'customer/store';
		$this->request($url, $params, true);
		return $this->getResult();
	}

	function login($params)
	{
		$url = 'customer/login';
		$this->request($url, $params, true);
		return $this->getResult();
	}

}
