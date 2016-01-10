<?php

namespace AlistairShaw\Vendirun\App\Http\Middleware;

use AlistairShaw\Vendirun\App\Lib\LocaleHelper;
use AlistairShaw\Vendirun\App\Lib\VendirunApi\VendirunApi;
use App;
use Closure;

class Localization {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $segment = $request->segment(1);

        if (in_array($segment, LocaleHelper::validLocales()))
        {
            app()->setLocale($segment);
        }
        else
        {
            $clientInfo = VendirunApi::makeRequest('client/publicInfo')->getData();
            app()->setLocale($clientInfo->primary_language->language_code);
        }

        // if it's a CMS page, we need to get rid of the locale part of the URL so we get the actual slug
        if ($request->route()->getName() == 'cmsPage')
        {
            $path = $request->route()->parameter('catchall');
            $pathArray = explode('/', $path);
            if (in_array($pathArray[0], LocaleHelper::validLocales()))
            {
                $request->route()->setParameter('catchall', str_replace($request->segment(1) . '/', '', $path));
            }
        }

        return $next($request);
    }
}
