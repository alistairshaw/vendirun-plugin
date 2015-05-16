<?php
/**
 * Created by PhpStorm.
 * User: Alistair
 * Date: 15/11/2014
 * Time: 22:51
 */
namespace Ambitiousdigital\Vendirun\Lib;

use Illuminate\Support\Facades\Mail;

class Mailer extends BaseApi
{

	public function sendMail($to, $subject, $params, $view)
	{

		Mail::send($view, $params, function($message)
		{
			$message->from('website@cloemarbellaproperties.com', 'Cleo Marbella Properties');
			$message->to($_ENV['EMAIL'])->subject($_ENV['NAME']);
		});

	}

}