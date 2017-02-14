<?php namespace AlistairShaw\Vendirun\App\Traits;

use Illuminate\Mail\Message;
use Mail;

trait ApiSubmissionFailTrait {

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

        foreach ($data as $key => $value)
        {
            if (is_array($value)) $data[$key] = '[array]';
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