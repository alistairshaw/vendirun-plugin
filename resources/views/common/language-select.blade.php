<div class="language-select">
    <div class="dropdown">
        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            <i class="flag {{ strtolower(LocaleHelper::getCountryCode(App::getLocale())) }}"></i> {{ trans('vendirun::languages.' . App::getLocale()) }}
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
            @foreach ($languages as $language)
                <li><a href="{{ LocaleHelper::getLanguageUrlForCurrentPage($language['language_code']) }}"><i class="flag {{ $language['country_code'] }}"></i> {{ trans('vendirun::languages.' . $language['language_code']) }}</a></li>
            @endforeach
        </ul>
    </div>
</div>