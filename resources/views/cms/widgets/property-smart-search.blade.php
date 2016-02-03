<?php if (!isset($options)) $options = json_decode($element->element_options, true) ?>
<form method="post" action="{{ route(\AlistairShaw\Vendirun\App\Lib\LocaleHelper::getLanguagePrefixForLocale(App::getLocale()) . 'vendirun.propertySearch') }}" class="search-box">
    <div class="form-group">
        <label class="sr-only">{{ trans('vendirun::property.search') }}</label>
        <input type="text" class="form-control" name="search_string" placeholder="{{ $options['placeholder'] or '' }}">
    </div>
    <div class="form-group">
        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
        <button type="submit" class="btn btn-default">{{ $options['button_text'] or 'Search Now' }}</button>
    </div>
</form>