(function ($) {

    var MagnifierObj = function (element, options) {

        var settings = $.extend({}, $.fn.magnifier.defaults, options);

        var slider = $(element);

        var viewerWindow = {
            currentOriginalWidth: 0,
            currentOriginalHeight: 0,
            currentSlide: null,
        };

        // create viewing window
        var top = slider.offset().top - 17;
        var left = slider.offset().left + slider.width() + 33;
        var html = '<div class="magnifier-viewer js-magnifier-viewer" style="' +
            'position: absolute; ' +
            'display: none; ' +
            'top: ' + top + 'px; ' +
            'left: ' + left + 'px; ' +
            //'border: 1px solid #ccc; ' +
            'width: ' + settings.viewerWidth + 'px; ' +
            'height: ' + settings.viewerHeight + 'px;"' +
            '>' +
            '<div class="cover" style="' +
            'position: absolute; ' +
            'width: 100%; ' +
            'height: 100%; ' +
            'line-height: ' + settings.viewerHeight + 'px; ' +
            'top: 0; ' +
            'left: 0; ' +
            'background: #FFF; ' +
            'text-align: center; ' +
            'font-size: 1.4em; ' +
            '"><i class="fa fa-circle-o-notch fa-spin"></i></div>' +
            '</div>';

        var $viewerWindow = $(html);
        var $body = $('body').append($viewerWindow);

        // the viewer box
        var $box = $('<div class="box" style="' +
            'background: rgba(255,255,255,0.5); ' +
            'position: absolute; ' +
            'border: 1px solid black; ' +
            'z-index: 10; ' +
            '"></div>');

        $body.append($box);
        $box.css('top', slider.offset().top);
        $box.css('left', slider.offset().left);
        $box.css('pointer-events', 'none'); // note: requires polyfill for IE (pointer-events-polyfill.js)

        // add behaviours to each child
        slider.find('a').each(function () {
            $(this).on('mouseover', function() {
                $viewerWindow.css('display', 'block');
                viewerWindow.currentSlide = $(this);
                $viewerWindow.find('.cover').css('display', 'block');
                var $imageLink = $(this).find('img');
                $('<img>').load(function(){
                    $viewerWindow.find('.cover').css('display', 'none');
                    $viewerWindow.css('background-image', 'url(' + $imageLink.data('original') + ')').css('background-repeat', 'no-repeat');
                    $('body').append(this);
                    $(this).hide();
                    viewerWindow.currentOriginalHeight = $(this).height();
                    viewerWindow.currentOriginalWidth = $(this).width();
                }).attr('src',function(){
                    return $imageLink.data('original');
                }).each(function() {
                    // fail-safe for cached images which sometimes don't trigger "load" events
                    if(this.complete) $(this).load();
                });
            });

            $(this).on('mouseout', function() {
                $viewerWindow.css('display', 'none');
                $box.css('display', 'none');
            });

            $(this).on('mousemove', function(event) {
                // position within image
                var posTop = slider.offset().top - event.pageY;
                var posLeft = slider.offset().left - event.pageX;

                // hover image size
                var height = slider.height();
                var width = slider.width();

                if (height == 0 || width == 0) return;

                // ratios
                var heightRatio = viewerWindow.currentOriginalHeight / height;
                var widthRatio = viewerWindow.currentOriginalWidth / width;

                var boxWidth =  height / widthRatio;
                var boxHeight = width / heightRatio;

                var boxLeft = event.pageX - (boxWidth / 4);
                if (boxLeft < slider.offset().left) boxLeft = slider.offset().left;
                if (boxLeft > slider.offset().left + slider.width() - boxWidth) boxLeft = slider.offset.left + slider.width() - boxWidth;

                var boxTop = event.pageY - (boxHeight / 4);
                if (boxTop < slider.offset().top) boxTop = slider.offset().top;
                if (boxTop > slider.offset().top + slider.height() - boxHeight) boxTop = slider.offset().top + slider.height() - boxHeight;

                $box.css('width', boxWidth + 'px');
                $box.css('height', boxHeight + 'px');
                $box.css('top', boxTop + 'px');
                $box.css('left', boxLeft + 'px');

                // offsets
                var offsetTop = posTop * heightRatio;
                var offsetLeft = posLeft * widthRatio;

                var minOffsetTop = (viewerWindow.currentOriginalHeight - settings.viewerHeight) * -1;
                if (offsetTop < minOffsetTop) offsetTop = minOffsetTop;

                var minOffsetLeft = (viewerWindow.currentOriginalWidth - settings.viewerHeight) * -1;
                if (offsetLeft < minOffsetLeft) offsetLeft = minOffsetLeft;

                $viewerWindow.css('background-position', offsetLeft + 'px ' + offsetTop + 'px');

                $box.css('display', 'block');
            })
        });

        return this;
    };

    $.fn.magnifier = function (options) {
        return this.each(function () {
            var element = $(this);
            if (element.data('magnifier')) {
                return element.data('magnifier');
            }
            var magnifier = new MagnifierObj(this, options);
            element.data('magnifier', magnifier);
        });
    };

    //Default settings
    $.fn.magnifier.defaults = {
        viewerWidth: 400,
        viewerHeight: 400
    };

}(jQuery));