<ul class="social-share">
    @foreach($socialLinks as $social)
        <li class="{{ $social->getProvider() }}">
            <a href="{{ $social->getLink() }}"><img src="{{ asset('vendor/vendirun/images/social/' . $social->getProvider() . '.jpg') }}"></a>
        </li>
    @endforeach
</ul>