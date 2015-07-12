<?php namespace Ambitiousdigital\Vendirun\Composers;

class CmsViewComposer {

    public function compose($view)
    {
        $view->with('test', array('first', 'second', 'third'));
    }

}