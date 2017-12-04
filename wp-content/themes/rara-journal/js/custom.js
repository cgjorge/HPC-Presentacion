
jQuery(document).ready(function($){

    /* removes class hidden from the banner */
    $("#banner-slider").removeClass("hidden");
   
   /** Variables from Customizer for Slider settings */
    if( rarajournal_data.auto == '1' ){
        var slider_auto = true;
    }else{
        slider_auto = false;
    }
    
    if( rarajournal_data.loop == '1' ){
        var slider_loop = true;
    }else{
        var slider_loop = false;
    }
    
    if( rarajournal_data.pager == '1' ){
        var slider_control = true;
    }else{
        slider_control = false;
    }
    
    /** Home Page Slider */
    $('#lightSlider').lightSlider({

        slideMargin: 0,
        mode: rarajournal_data.animation,        
        speed: rarajournal_data.a_speed, //ms'
        auto: slider_auto,
        loop: slider_loop,
        pager: slider_control,
        
        responsive : [
            {
                breakpoint:767.5,
                settings: {
                    item: 1,
                }
            }
        ],

    });

    $('.header-bottom  .main-navigation').meanmenu({

       meanScreenWidth: 991,
       meanRevealPosition: "right"
    
    });

    $('#responsive-menu-button').sidr({

        name: 'sidr-main',
        source: '#secondary-menu',
        side: 'left'
    
    });

});