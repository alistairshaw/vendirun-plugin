<?php namespace AlistairShaw\Vendirun\App\Lib;

use Illuminate\Support\Facades\Mail;

class Mailer
{
	public function sendMail($to, $subject, $params, $view)
	{
		Mail::send($view, $params, function($message) use ($to, $subject)
		{
			$message->from('website@cleomarbellaproperties.com', 'Cleo Marbella Properties');
			$message->to($to)->subject($subject);
		});
	}

}