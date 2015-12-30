<?php namespace AlistairShaw\Vendirun\App\Lib\VendirunApi\ApiV1;

use AlistairShaw\Vendirun\App\Lib\VendirunApi\Exceptions\FailResponseException;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\Exceptions\InvalidResponseException;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\Exceptions\NoApiConnectionException;
use AlistairShaw\Vendirun\App\Traits\NotifySupportTrait;
use App;
use Cache;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Mail\Message;
use Mail;

class BaseApi {

    use NotifySupportTrait;

    /**
     * @var string
     */
    private $error = '';

    /**
     * @var
     */
    private $result;

    /**
     * @param null $api_key
     * @param null $cid
     * @param null $endpoint
     */
    public function __construct($api_key = NULL, $cid = NULL, $endpoint = NULL)
    {
        $this->api_key = $api_key;
        $this->cid = $cid;
        $this->endpoint = $endpoint;
    }

    /**
     * Does the CURL request, returns the response or sets an error message
     *
     * @param string $url       Only pass the end of the URL, the main endpoint is set in the constructor
     * @param array  $params    Only pass in additional post parameters if required
     * @param bool   $noCache   Do not use the cache at all
     * @param int    $cacheTime Time in minutes
     * @return object
     * @throws FailResponseException
     * @throws InvalidResponseException
     * @throws NoApiConnectionException
     */
    protected function request($url, $params = [], $noCache = false, $cacheTime = 5)
    {
        $key = $url . json_encode($params);

        if (!$noCache && Cache::has($key)) return Cache::get($key);

        $client = new GuzzleClient();
        $res = null;
        try
        {
            $res = $client->post($this->endpoint . $url, [
                'form_params' => $params,
                'auth' => [$this->cid, $this->api_key],
                'decode_content' => 'json'
            ]);

            if ($res->getStatusCode() !== 200) throw new NoApiConnectionException($url, $res->getStatusCode(), $key);
            $response = json_decode($res->getBody());

            if ($response == '' && $res->getBody() == '')
            {
                if (App::environment() == 'local')
                {
                    echo 'API endpoint returned completely empty. That shouldn\'t happen.';
                    dd($res->getStatusCode());
                }
                $response = $this->getFromPermanentCache($noCache, $key, 'Empty response from server at ' . $url);
            }

            // if no valid JSON, try to get from cache
            if (json_last_error() !== JSON_ERROR_NONE)
            {
                if (App::environment() == 'local')
                {
                    echo $res->getBody();
                    dd($res->getStatusCode());
                }
                $response = $this->getFromPermanentCache($noCache, $key, 'Invalid response from server at ' . $url);
            }
        }
        catch (ServerException $e)
        {
            if (App::environment() == 'local')
            {
                echo $e->getResponse()->getBody();
                dd($e->getResponse()->getStatusCode());
            }
            $response = $this->getFromPermanentCache($noCache, $key, 'Server returned a ' . $e->getResponse()->getStatusCode() . ' status at ' . $url);
        }
        catch (\Exception $e)
        {
            if (App::environment() == 'local')
            {
                dd($e);
            }
            $response = $this->getFromPermanentCache($noCache, $key, 'Unknown error on connecting to ' . $url);
        }

        // if the API returns a valid failure response, try to get from cache or FailResponseException
        if (!$response->success) $response = $this->getFromPermanentCache($noCache, $key, $response->error);

        $this->setCache($response, $key, $cacheTime);

        return $response;
    }

    /**
     * @param bool   $noCache
     * @param string $key
     * @param string $errorMessage
     * @return bool|mixed
     * @throws FailResponseException
     */
    protected function getFromPermanentCache($noCache, $key, $errorMessage = '')
    {
        if (!$noCache)
        {
            if (Cache::has('Permanent' . $key))
            {
                $this->alertSupport('API Request Failed, Using Permanent Cache', $key, 480);
                $response = Cache::get('Permanent' . $key);
                if ($response) return $response;
            }
        }
        throw new FailResponseException(false, $errorMessage);
    }

    /**
     * @param     $response
     * @param     $key
     * @param int $cacheTime
     */
    protected function setCache($response, $key, $cacheTime = 5)
    {
        // only use the cache in production
        if (App::environment() == 'production')
        {
            Cache::put($key, $response, $cacheTime);
            Cache::forever('Permanent' . $key, $response);
        }
    }

    /**
     * Returns the current result
     */
    protected function getResult()
    {
        return $this->result;
    }

    /**
     * @param $message
     * @return bool
     */
    protected function setError($message)
    {
        $this->error = $message;

        return false;
    }

    /**
     * @return string
     */
    protected function getError()
    {
        return $this->error;
    }

    /**
     * @param $action
     * @param $data
     */
    protected function apiSubmissionFailed($action, $data)
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
        Mail::send($view, $data, function (Message $message) use ($subjectLine)
        {
            $message->from(Config('vendirun.emailsFrom'), Config('vendirun.emailsFromName'));
            $message->to(Config('vendirun.backupEmail'))->subject($subjectLine);
            $message->cc(Config('vendirun.vendirunSupportEmail'), 'Vendirun Support');
        });
    }
}