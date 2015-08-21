var thumbnails = {
    init: function () {
        this.resizeThumbnails();
        return this;
    },

    resizeThumbnails: function () {
        var tallest = 0;
        var $thumbnail = $('.thumbnail');
        $thumbnail.each(function () {
            if ($(this).height() > tallest) tallest = $(this).height();
        });

        $thumbnail.each(function() {
            $(this).css('min-height', (tallest + 35) + 'px');
        });
    }
};