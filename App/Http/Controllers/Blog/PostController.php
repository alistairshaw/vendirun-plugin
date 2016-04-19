<?php namespace AlistairShaw\Vendirun\App\Http\Controllers\Blog;

use AlistairShaw\Vendirun\App\Http\Controllers\VendirunBaseController;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\Exceptions\FailResponseException;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;
use App;
use View;

class PostController extends VendirunBaseController {

    protected $primaryPages = true;

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
        $data = [];
        try
        {
            $post = VendirunApi::makeRequest('blog/post', ['slug' => $slug]);
            $data['post'] = $post->getData();
        }
        catch (FailResponseException $e)
        {
            abort('404');
        }
        return View::make('vendirun::blog.post', $data);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function search()
    {
        $data = [];
        try
        {
            $searchVars = $_GET;
            $searchVars['language'] = App::getLocale();
            $posts = VendirunApi::makeRequest('blog/search', $searchVars);
            $data['posts'] = $posts->getData();
        }
        catch (FailResponseException $e)
        {
            abort('404');
        }
        return View::make('vendirun::blog.search', $data);
    }
}