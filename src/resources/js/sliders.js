$(window).load(function () {
	var iconStackLeft = '<span class="fa-stack">\
							<i class="fa fa-circle fa-stack-2x" style="color: #000;"></i>\
							<i class="fa fa-caret-left fa-stack-1x" style="top: -1px;"></i>\
						</span>';
	var iconStackRight = '<span class="fa-stack">\
							<i class="fa fa-circle fa-stack-2x" style="color: #000;"></i>\
							<i class="fa fa-caret-right fa-stack-1x" style="left: 2px; top: -1px"></i>\
						</span>';

	$('.property-slide-show').nivoSlider({
		manualAdvance: true,
		prevText: iconStackLeft,
		nextText: iconStackRight,
		controlNav: false
	});
});