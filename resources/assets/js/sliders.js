$(window).load(function () {
	$('.property-slide-show').nivoSlider({
		manualAdvance: true,
		prevText: '',
		nextText: '',
		controlNav: true,
		controlNavThumbs: true,
        effect: 'slideInRight',
        animSpeed: 200
	});

    $('.product-slide-show').nivoSlider({
        manualAdvance: true,
        prevText: '',
        nextText: '',
        controlNav: true,
        controlNavThumbs: true,
        effect: 'slideInRight',
        animSpeed: 200
    });
});