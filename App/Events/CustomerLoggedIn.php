<?php namespace AlistairShaw\Vendirun\App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;

class CustomerLoggedIn extends Event
{
    use SerializesModels;

    public $token;

    /**
     * Create a new event instance.
     *
     * @param $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }
}