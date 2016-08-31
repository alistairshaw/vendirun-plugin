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

    var $sliderWidgets = $('.vendirun-slider-widget');
    if ($sliderWidgets.length) {
        $sliderWidgets.each(function () {
            var items = $(this).find('.item');
            var heights = [];
            var shortestSlide;

            if (items.length) {
                function normalizeHeights() {
                    items.each(function () {
                        heights.push($(this).height());
                    });
                    shortestSlide = Math.min.apply(null, heights);
                    items.each(function () {
                        $(this).css('max-height', shortestSlide + 'px');
                    });
                }

                normalizeHeights();

                $(window).on('resize orientationchange', function () {
                    shortestSlide = 0;
                    heights.length = 0;
                    items.each(function () {
                        $(this).css('max-height', '');
                    });
                    normalizeHeights();
                });
            }
        });
    }
});