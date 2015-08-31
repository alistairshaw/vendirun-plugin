$(document).ready(function () {

    var propertyResultsUrlManager = new urlManager();

    $('#limit').on('change', function () {
        propertyResultsUrlManager.addParameterToUrl('limit', $(this).val());
    });

    $('#order_by').on('change', function() {
        propertyResultsUrlManager.addParameterToUrl('order_by', $(this).val());
    });
});