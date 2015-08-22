<?php if (!isset($options)) $options = json_decode($element->element_options, true) ?>
<div class="social-media-icons {{ strtolower($options['social_type']) }}">
    @if ($options['social_facebook'])
        <a href="{{ $options['social_facebook'] }}" class="facebook"></a>
    @endif
    @if ($options['social_twitter'])
        <a href="{{ $options['social_twitter'] }}" class="twitter"></a>
    @endif
    @if ($options['social_googleplus'])
        <a href="{{ $options['social_googleplus'] }}" class="googleplus"></a>
    @endif
    @if ($options['social_rss'])
        <a href="{{ $options['social_rss'] }}" class="rss"></a>
    @endif
</div>