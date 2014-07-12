jQuery(function ($){

/**
* Form Switch
*/
$('.wpduel-switch a').on('click', function(e){
	e.preventDefault();
	var vote = $(this).attr('href');
	var background = $(this).parents('.wpduel-switch').find('span');
	var option = '.' + $(this).data('option');

	$('.contender').removeClass('active');
	$(option).addClass('active');

	$('#vote').val(vote);
	$('.wpduel-switch li').removeClass('active');
	$(this).parent('li').addClass('active');

	if ( $(this).parent('li').hasClass('right') ){
		$(background).addClass('right');
	} else {
		$(background).removeClass('right');
	}

});

}); // jQuery
