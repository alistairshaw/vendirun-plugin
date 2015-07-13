<?php namespace Ambitiousdigital\Vendirun\App\Lib\VendirunApi;

use Cache;

class BaseApi {

    public $errorMessage = '';
    public $error = false;
    public $debugmode = false;

    private $result;

    public function __construct($api_key = NULL, $cid = NULL, $endpoint = NULL)
    {
        $this->api_key = ($api_key !== NULL) ? $api_key : config('vendirun.apiKey');
        $this->cid = ($cid !== NULL) ? $cid : config('vendirun.clientId');
        $this->endpoint = ($endpoint !== NULL) ? $endpoint : config('vendirun.apiEndPoint');
    }

    /**
     * Does the CURL request, returns the response or sets an error message
     *
     * @param  string $url    Only pass the end of the URL, the main endpoint is set in the constructor
     * @param  array  $params Only pass in additional post parameters if required
     * @param bool    $ignoreCache
     * @return array
     */
    protected function request($url, $params = array(), $ignoreCache = false)
    {
        $key = $url . json_encode($params);

        if (!$ignoreCache)
        {
            if (Cache::has($key))
            {
                $this->result = Cache::get($key);

                return true;
            }
        }

        //Build the final URL
        $final_url = $this->endpoint . $url;

        // If debug mode is enabled then we print out the URL and parameters
        if ($this->debugmode)
        {
            echo '<pre style="border: 1px solid #CCC; padding: 20px; margin-bottom: 20px;">';
            echo "<p>URL: $final_url</p>";
            print_r($params);
            echo '</pre>';
        }

        //Initiate CURL
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $final_url,
            CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
            CURLOPT_USERPWD => $this->cid . ':' . $this->api_key,
        ));

        // if we need to pass in parameters, then set it to POST
        if (count($params) > 0)
        {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
        }

        $resp = curl_exec($curl);
        $this->errorMessage = curl_error($curl);

        // if ($url == 'property/location') exit($resp);

        //Close Request
        curl_close($curl);
        $result = $resp;

        $resp = json_decode($resp);

        // If debug mode is enabled then we print out the CURL response
        if ($this->debugmode)
        {
            echo '<pre style="border: 1px solid #CCC; padding: 20px; margin-bottom: 20px;">';
            echo '<p>CURL Response: </p>';
            print_r($resp);
            echo '<p>RAW DATA: </p>';
            print_r($result);
            echo '</pre>';
        }

        //If we get a success
        if (isset($resp->success) && $resp->success)
        {
            $response = array();
            $response['data'] = $resp->data;
            $response['error'] = 0;
            $response['success'] = $resp->success;
            $response['error_message'] = '';
            $this->result = $response;

            Cache::put($key, $response, 1);
            Cache::forever('Permanent' . $key, $response);
        }
        else
        {
            $response = array();
            $response['data'] = '';
            $response['error'] = isset($resp->error) ? $resp->error : 'Fail to connect to the API';
            $response['api_failure'] = (!isset($resp->error)) ? 1 : 0;
            $response['success'] = 0;

            if (!$ignoreCache)
            {
                if (Cache::has($key))
                {
                    $this->result = Cache::get('Permanent' . $key);
                }
                else
                {
                    $this->result = $response;
                }

            }
            else
            {
                $this->result = $response;
            }
        }
    }

    /**
     * Returns the current result
     */
    protected function getResult()
    {
        return $this->result;
    }

    protected function getError()
    {
        return $this->error;
    }

    protected function getErrorMessage()
    {
        return $this->errorMessage;
    }
}