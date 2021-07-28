jQuery(document).ready(function($) {

    $(".swm_btn_header_styles").on("click", function(){

        // We'll pass this variable to the PHP function example_ajax_request
        var $hs_value = $("input[name='swm_set_header_styles']:checked").val();
        var getHeaderStyleNounce = gyanHeaderStyles.gyanHeaderStylesNounce;

        if ( $hs_value ) {

            $('.gyan-hs-blank-header').hide();

            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    'action':'gyan-import-header-style',
                    'nonce' : getHeaderStyleNounce,
                    'init'  : $hs_value,
                },
                success:function(data) {
                    console.log(data);
                    $('.gyan-hs-notice').show();
                },
                error: function(errorThrown){
                    console.log(errorThrown);
                }
            });

        } else {
            $('.gyan-hs-blank-header').show();
        }

    });

});