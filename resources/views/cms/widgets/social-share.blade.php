<div class="social-share">
    <div class="facebook">
        <div class="fb-share-button"
             data-href="{{ Request::fullUrl() }}"
             data-layout="button_count">
        </div>
    </div>

    <div class="twitter">
        <a href="https://twitter.com/share" class="twitter-share-button" data-via="{{ $clientData->social->twitter }}">Tweet</a>
        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
    </div>

    <div class="linkedin">
        <script src="//platform.linkedin.com/in.js" type="text/javascript"> lang: en_US</script>
        <script type="IN/Share" data-url="{{ Request::fullUrl() }}" data-counter="right"></script>
    </div>

    <div class="google_plus">
        <div class="g-plus" data-action="share" data-href="{{ Request::fullUrl() }}" data-annotation="bubble"></div>
    </div>
</div>