$('.js-reload-per-page-button').remove();

$(document).ready(function () {

    var resultsUrlManager = new urlManager();

    $('#limit').on('change', function () {
        resultsUrlManager.addParameterToUrl('limit', $(this).val());
    });

    $('#order_by').on('change', function() {
        resultsUrlManager.addParameterToUrl('order_by', $(this).val());
    });
});