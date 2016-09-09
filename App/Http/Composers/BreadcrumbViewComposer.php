<?php namespace AlistairShaw\Vendirun\App\Http\Composers;

use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;
use Illuminate\View\View;

class BreadcrumbViewComposer
{

    /**
     * Create breadcrumbs depending on what kind of page we're on
     * @param View $view
     */
    public function index($view)
    {
        $viewData = $view->getData();
        $view->with('breadcrumbs', $this->generateBreadcrumbs($viewData));
    }

    private function generateBreadcrumbs($viewData)
    {
        $breadcrumbs = [];
        if (isset($viewData['page'])) return $this->pageBreadcrumbs($viewData['page']->breadcrumbs);
        if (isset($viewData['posts'])) return $this->blogBreadcrumbs();
        if (isset($viewData['post'])) return $this->blogPostBreadcrumbs($viewData['post']);

        return $breadcrumbs;
    }

    /**
     * @param $br
     * @return array
     */
    private function pageBreadcrumbs($br)
    {
        $breadcrumbs = [];
        foreach ($br as $crumb)
        {
            $breadcrumbs[] = (array)$crumb;
        }
        return $breadcrumbs;
    }

    /**
     * @return array
     */
    private function blogBreadcrumbs()
    {
        return [
            [
                'title' => 'Home',
                'slug' => ''
            ],
            [
                'title' => trans('vendirun::blog.blog'),
                'slug' => 'blog'
            ]
        ];
    }

    /**
     * @param $post
     * @return array
     */
    private function blogPostBreadcrumbs($post)
    {
        $breadcrumbs = $this->blogBreadcrumbs();
        $breadcrumbs[] = [
            'title' => $post->title,
            'slug' => 'blog/' . $post->slug
        ];

        return $breadcrumbs;
    }
}