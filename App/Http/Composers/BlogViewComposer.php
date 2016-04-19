<?php namespace AlistairShaw\Vendirun\App\Http\Composers;

use AlistairShaw\Vendirun\App\Lib\VendirunApi\Exceptions\FailResponseException;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;
use App;

class BlogViewComposer {

    /**
     * @param $view
     */
    public function posts($view)
    {
        $viewData = $view->getData();

        if (!isset($view['posts']))
        {
            $params = [];
            if (isset($viewData['element']->element_options))
            {
                $options = json_decode($viewData['element']->element_options);
                if (isset($options->show)) $params['limit'] = $options->show;
                if (isset($options->show_images) && !$options->show_images) $view->with('hideImages', true);
                if (isset($options->category)) $params['category'] = $options->category;
            }

            try
            {
                $request = VendirunApi::makeRequest('blog/search', $params);
                $posts = $request->getData();
            }
            catch (FailResponseException $e)
            {
                $posts = [];
            }

            $view->with('posts', $posts);
        }
    }
    
}