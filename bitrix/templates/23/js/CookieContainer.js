$(document).ready(function(){
  	if (!$.cookie('hideModal')) {
		var delay_popup = 0;
		setTimeout("document.querySelector('.cookie-container').style.display='flex'", delay_popup);
	}
	$('.accept').click(function(){
		$.cookie('hideModal', true, {expires: 30, path: '/'});
	    $('.cookie-container').animate({bottom :-1*$('.cookie-container').height()}, 500 );
		setTimeout("document.querySelector('.cookie-container').style.display='none'", 1500);
	});
});

