<?php namespace Ambitiousdigital\Vendirun\App\Http\Composers;

class CmsViewComposer {

    public function compose($view)
    {
        $view->with('test', array('first', 'second', 'third'));
    }

}