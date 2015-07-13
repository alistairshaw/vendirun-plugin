<?php namespace Ambitiousdigital\Vendirun\App\Http\Composers;

class CmsViewComposer {

    public function compose($view)
    {
        $viewdata= $view->getData();

        $view->with('test', array('first', 'second', 'third'));
    }

}