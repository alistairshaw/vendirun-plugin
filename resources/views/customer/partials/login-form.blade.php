@if (!isset($outputFormTags) || $outputFormTags)
    <form method="POST" action="{{ route('vendirun.doLogin') }}">
        @endif
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <h2>{{ trans('vendirun::standard.login') }}</h2>

        <div class="form-group">
            <label for="email_login">{{ trans('vendirun::forms.email') }}</label>
            <input type="text" class="form-control" name="email_login" id="email_login" placeholder="{{ trans('vendirun::forms.email') }}">
        </div>

        <div class="form-group">
            <label for="password">{{ trans('vendirun::forms.password') }}</label>
            <input type="password" class="form-control" name="password" placeholder="{{ trans('vendirun::forms.password') }}">
        </div>

        <div class="form-group text-right">
            <button type="submit" class="btn btn-primary">{{ trans('vendirun::standard.login') }}</button>
            <br>
            <br>
            <a href="{{ route(LocaleHelper::localePrefix() . 'vendirun.passwordRecovery') }}">{{ trans('vendirun::forms.passwordForgotten') }}</a>
        </div>
        @if (!isset($outputFormTags) || $outputFormTags == true)
    </form>
@endif