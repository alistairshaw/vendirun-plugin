<form method="post" action="{{ route(\AlistairShaw\Vendirun\App\Lib\LocaleHelper::getLanguagePrefixForLocale(App::getLocale()) . 'vendirun.propertySearch') }}">
    <input type="hidden" name="_token" value="{{{ csrf_token() }}}">
    <div class="form-group">
        <label class="sr-only">{{ trans('vendirun::property.search') }}</label>
        <input type="text" class="form-control" name="search_string" placeholder="{{ trans('vendirun::property.simpleSearchExample') }}">
    </div>
    <button type="submit" class="btn btn-default">{{ trans('vendirun::property.searchNow') }}</button>
</form>