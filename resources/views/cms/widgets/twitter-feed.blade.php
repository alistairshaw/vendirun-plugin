<?php if (!isset($options)) $options = json_decode($element->element_options, true) ?>
<div class="vendirun-twitter-feed">
    <a class="twitter-timeline" data-dnt="true" href="https://twitter.com/{{ $options['name'] }}" data-widget-id="722490161188225024">Tweets by @{{ $options['name }}</a>
    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
</div>