(function ($) {	$(document).ready(function(){

	"use strict";

    function gyanPostsSliderWidget() {

        $('.gyan-posts-slider-widget').each(function () {

            var $this = $(this),
                play = $this.data('autoplay') ? true : false,
                pause = $this.data('pause') ? true : false,
                mouse = $this.data('mouse-drag') ? true : false,
                touch = $this.data('touch-drag') ? true : false,
                is_rtl = $this.data('rtl') ? true : false;

            //Initialize carousel
            $this.owlCarousel({
                autoplay: true,
                autoplayHoverPause: pause,
                nav: true,
                dots: true,
                mouseDrag: true,
                touchDrag: true,
                loop: true,
                smartSpeed: 700,
                autoplayTimeout: 5000,
                items:1,
                navText:'',
                autoHeight:true,
                margin:10,
                rtl:is_rtl
            });

        });

    }

    /* Post Love ------------------------- */

    function gyan_postLike() {

        $('.gyan-love').on('click',function() {
            var el = $(this);
            if( el.hasClass('loved') ) return false;

            var post = {
                action: 'gyan_love',
                post_id: el.attr('data-id')
            };

            $.post(gyan_get_ajax_full_url.ajaxurl, post, function(data){
                el.find('.gyan-like-number').html(data);
                el.addClass('loved');
            });

            return false;
        });
    }

    gyanPostsSliderWidget();
    gyan_postLike();

}); })(jQuery);