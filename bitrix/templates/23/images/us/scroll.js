//console.log('ass')
/*jQuery(document).ready(function(){
    
    var offset = jQuery('#header').offset().top;
    var menu = jQuery('#header').offset().top;
    jQuery(window).scroll(function() {
        if (jQuery(window).scrollTop() > offset && jQuery(window).width() > '400') {
            if(jQuery(window).width() > '1299')
            {

                jQuery('#toolbar .grafik, #toolbar .mail, #toolbar .telephone,#search').hide();
                jQuery('.tm').css('margin-top', '10px');
                //jQuery('.zvon').css({'width':'60px', 'height': '40px', 'padding': '0', 'font-size': '0'});
                //jQuery('#header').css('height', '67px');
                jQuery(".zvon").css("margin-top", '4px');
                jQuery("#toolbar .tm .module").css("margin-top", '15px');

            
                jQuery('#logo img').css('width','unset');
                jQuery('#logo img').css('height','60px');
                jQuery('#header').css('height', '85px');
            }

            /*if(jQuery(window).width() <= '1101')
            {
                jQuery('.tm').css('margin-top', '22px');
                
            }*/
        /*}
        else if (jQuery(window).scrollTop() <= menu && jQuery(window).width() > '400') {
            if(jQuery(window).width() > '1299')
            {
                //jQuery('#logo, #toolbar .telephone').show(); //
                jQuery('.tm').css('margin-top', '54px');

                jQuery('#logo img').css('width','unset');
                jQuery('#logo img').css('height','76px');

            
                jQuery('#header').css('height', '80px');
                jQuery('#search').show();
                jQuery(".zvon").css("margin-top", '10px');
                jQuery("#toolbar .tm .module").css("margin-top", '0px');
            }
            /*if(jQuery(window).width() <= '1101')
            {
                jQuery('.tm').css('margin-top', '40px');
            }
            if(jQuery(window).width() >= '1000')
            {
                jQuery('#toolbar .mail, #toolbar .grafik, #toolbar .telephone').show(); //
            }*/
           
            //jQuery('.zvon').css({'padding-top': '15px', 'padding-bottom': '15px', 'padding-left': '22px', 'padding-right': '22px', 'font-size': '11px'});
            
            
        /*}
});

	jQuery('.portfolioFilter a[href="'+document.location.href+'"]').addClass('curent');
});
*/