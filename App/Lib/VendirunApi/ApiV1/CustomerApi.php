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
     * @return object
     */
	public function store($params)
	{
		$url = 'customer/store';
        return $this->request($url, $params, true);
        //todo: put this back so it sends an email when a customer signs up if API access is unavailable
        /*try
        {

        }
        catch (\Exception $e)
        {
            unset($params['_token']);
            unset($params['password']);
            unset($params['password_confirmation']);
            $this->apiSubmissionFailed('contact-form', $params);
        }*/
	}

    public function find($params)
    {
        $url = 'customer/find/' . $params['token'];
        return $this->request($url, $params);
    }

	/**
	 * @param array $params
	 * @return array
	 */
	public function login($params)
	{
		$url = 'customer/login';
		return $this->request($url, $params, true);
	}

    /**
     * @param $params
     * @return array
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
}
