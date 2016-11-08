<?php namespace AlistairShaw\Vendirun\App\Http\Controllers\Cms;

use AlistairShaw\Vendirun\App\Entities\Customer\Helpers\CustomerHelper;
use AlistairShaw\Vendirun\App\Http\Controllers\VendirunBaseController;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\Exceptions\FailResponseException;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;
use App;
use Cache;
use Config;
use LocaleHelper;
use Redirect;
use Request;
use Response;
use View;

class PageController extends VendirunBaseController {

    protected $primaryPages = true;

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (view()->exists('home'))
        {
            $data = [];
            try
            {
                $page = VendirunApi::makeRequest('cms/page', ['slug' => '', 'locale' => App::getLocale(), 'token' => CustomerHelper::checkLoggedinCustomer()]);
                $data['page'] = $page->getData();
            }
            catch (FailResponseException $e)
            {
                abort('404');
            }

            return View::make('home', $data);
        }

        return $this->page('');
    }

    /**
     * @param $slug
     * @return \Illuminate\View\View
     */
    public function page($slug = '')
    {
        $data = [];
        try
        {
            $page = VendirunApi::makeRequest('cms/page', ['slug' => $slug, 'locale' => App::getLocale(), 'token' => CustomerHelper::checkLoggedinCustomer()]);
            $data['page'] = $page->getData();
        }
        catch (FailResponseException $e)
        {
            $errors = json_decode($e->getMessage());
            if (isset($errors->try_with_login))
            {
                if (CustomerHelper::checkLoggedinCustomer()) return Redirect::route(LocaleHelper::localePrefix() . 'vendirun.noPermissions');

                return Redirect::route(LocaleHelper::localePrefix() . 'vendirun.register')->withErrors('Please login to view this content');
            }
            abort('404');
        }

        return View::make('vendirun::cms.page', $data);
    }

    /**
     * @param $staffId
     * @return \Illuminate\View\View
     */
    public function staff($staffId)
    {
        $staff = VendirunApi::makeRequest('client/staff', ['id' => $staffId])->getData();
        if (!$staff) abort(404);

        return View::make('vendirun::cms.staff', ['person' => $staff]);
    }
}