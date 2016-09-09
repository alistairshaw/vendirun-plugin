<?php namespace AlistairShaw\Vendirun\App\Http\Composers;

use AlistairShaw\Vendirun\App\Entities\Product\Product;
use AlistairShaw\Vendirun\App\Entities\Product\ProductSearchResult\ProductSearchResult;
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

        // cms and blog
        if (isset($viewData['page'])) return $this->pageBreadcrumbs($viewData['page']->breadcrumbs);
        if (isset($viewData['posts'])) return $this->blogBreadcrumbs();
        if (isset($viewData['post'])) return $this->blogPostBreadcrumbs($viewData['post']);

        if (isset($viewData['productSearchResult'])) return $this->productsBreadcrumbs($viewData['productSearchResult']);
        if (isset($viewData['product'])) return $this->productBreadcrumbs($viewData['product'],
            isset($viewData['recommend']) ? $viewData['recommend'] : false,
            isset($viewData['pageTitle']) ? $viewData['pageTitle'] : '');

        if (isset($viewData['pageTitle']))
        {
            $breadcrumbs[] = [
                'title' => trans('vendirun::standard.home'),
                'slug' => '/'
            ];
            $breadcrumbs[] = [
                'title' => $viewData['pageTitle'],
                'slug' => isset($viewData['slug']) ? $viewData['slug'] : ''
            ];
        }

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

    private function homeCrumb()
    {
        return [
            [
                'title' => trans('vendirun::standard.home'),
                'slug' => '/'
            ]
        ];
    }

    /**
     * @return array
     */
    private function blogBreadcrumbs()
    {
        $breadcrumbs = $this->homeCrumb();
        $breadcrumbs[] = [
            'title' => trans('vendirun::blog.blog'),
            'slug' => 'blog'
        ];

        return $breadcrumbs;
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

    /**
     * @param ProductSearchResult $productSearchResult
     * @return array
     */
    private function productsBreadcrumbs(ProductSearchResult $productSearchResult)
    {
        $breadcrumbs = $this->homeCrumb();
        foreach ($productSearchResult->getBreadcrumbs() as $crumb)
        {
            $breadcrumbs[] = (array)$crumb;
        }
        return $breadcrumbs;
    }

    /**
     * @param Product $product
     * @param bool $recommend
     * @param string $pageTitle
     * @return array
     */
    private function productBreadcrumbs(Product $product, $recommend = false, $pageTitle = '')
    {
        $breadcrumbs = $this->homeCrumb();
        $breadcrumbs[] = [
            'title' => trans('vendirun::product.shop'),
            'slug' => 'shop'
        ];

        $parent_id = null;

        foreach ($product->getCategories() as $cat)
        {
            if ($parent_id == null || $cat->parent_id == $parent_id)
            {
                $breadcrumbs[] = [
                    'title' => $cat->category_name,
                    'slug' => 'shop' . $cat->slug
                ];

                $parent_id = $cat->category_id;
            }

            if ($parent_id == null) $parent_id = $cat->category_id;
        }

        $slug = $recommend ? $product->makeSlug() : '';

        $breadcrumbs[] = [
            'title' => $product->getProductName(),
            'slug' => $slug
        ];

        if ($recommend)
        {
            $breadcrumbs[] = [
                'title' => $pageTitle,
                'slug' => $slug
            ];
        }

        return $breadcrumbs;
    }
}