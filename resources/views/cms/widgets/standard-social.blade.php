@if (isset($social))
    <div class="social-media-icons {{ strtolower($socialType) }}">
        @if ($social->facebook)
            <a href="https://facebook.com/{{ $social->facebook }}" class="facebook" target="_blank"></a>
        @endif
        @if ($social->twitter)
            <a href="https://twitter.com/{{ $social->twitter }}" class="twitter" target="_blank"></a>
        @endif
        @if ($social->google_plus)
            <a href="https://plus.google.com/+{{ $social->google_plus }}" class="googleplus" target="_blank"></a>
        @endif
        @if ($social->linkedin)
            <a href="https://linkedin.com/company/{{ $social->linkedin }}" class="linkedin" target="_blank"></a>
        @endif
        @if ($social->blog)
            <a href="{{ $social->blog }}" class="rss" target="_blank"></a>
        @endif
    </div>
@endif