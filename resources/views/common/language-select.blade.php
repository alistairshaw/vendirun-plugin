<div class="language-select">
    <div class="dropdown">
        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            <i class="flag {{ strtolower($clientInfo->primary_language->country_code) }}"></i> {{ $clientInfo->primary_language->language }}
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
            @foreach ($languages as $language)
                <li><a href="#"><i class="flag {{ $language['country_code'] }}"></i> {{ $language['language'] }}</a></li>
            @endforeach
        </ul>
    </div>
    {{ App::getLocale() }}
</div>