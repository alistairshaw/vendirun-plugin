$('.js-popout-search').on('click', function() {
	$('.left-column').removeClass('hide');
	$('.js-main-results').removeClass('col-sm-offset-1').removeClass('col-sm-10').addClass('col-sm-offset-3').addClass('col-sm-9');
	localStorage['filterOpen'] = 1;
});

$('.js-close-filter').on('click', function() {
	$('.left-column').addClass('hide');
	$('.js-main-results').addClass('col-sm-offset-1').addClass('col-sm-10').removeClass('col-sm-offset-3').removeClass('col-sm-9');
	localStorage['filterOpen'] = 0;
});

if (localStorage['filterOpen'] == 1) {
	$('.left-column').removeClass('hide');
	$('.js-main-results').removeClass('col-sm-offset-1').removeClass('col-sm-10').addClass('col-sm-offset-3').addClass('col-sm-9');
}