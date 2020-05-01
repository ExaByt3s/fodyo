$(document).ready(function(){
	$('.top-menu-btn-mobileBlock').click(function(){
        var w = $('.form-application').width();
        var sw = document.body.clientWidth;
        var strLeft = (sw/2 - (w+40)/2) + "px";
        $('.form-application').css('left',strLeft);
        $('.form-application').css('display','block');
        $('.background-opacity').css('display', 'block');
    });
});