<?php if (!isset($options)) $options = json_decode($element->element_options, true) ?>
<input type="hidden" id="googleMapAddress" value="{{ $options['address'] }}">
<div id="map_canvas" class="map-canvas"></div>