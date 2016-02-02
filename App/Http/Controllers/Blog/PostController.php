<?php namespace AlistairShaw\Vendirun\App\Http\Controllers\Blog;

use AlistairShaw\Vendirun\App\Http\Controllers\VendirunBaseController;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\Exceptions\FailResponseException;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;
use View;

class PostController extends VendirunBaseController {

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return $this->search();
    }

    /**
     * @param $slug
     * @return \Illuminate\View\View
     */
    public function post($slug)
    {
        try
        {
            $post = VendirunApi::makeRequest('blog/post', ['slug' => $slug]);
            $data['post'] = $post->getData();
            return View::make('vendirun::blog.post', $data);
        }
        catch (FailResponseException $e)
        {
            abort('404');
        }
    }

    /**
     * @return \Illuminate\View\View
     */
    public function search()
    {
        try
        {
            $posts = VendirunApi::makeRequest('blog/search', $_GET);
            $data['posts'] = $posts->getData();
            return View::make('vendirun::blog.search', $data);
        }
        catch (FailResponseException $e)
        {
            abort('404');
        }
    }
}