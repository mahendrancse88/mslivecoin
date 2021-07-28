(function($){
    GyanCustomizerManager = {

        init: function() {
            this._bind();
            this._CustomizerOptions();
        },
        _bind: function() {
            $( document ).on('click' , '.gyan-install-recommended-plugin', GyanCustomizerManager._installNow );
            $( document ).on('click' , '.gyan-activate-recommended-plugin', GyanCustomizerManager._activatePlugin);
            $( document ).on('click' , '.gyan-deactivate-recommended-plugin', GyanCustomizerManager._deactivatePlugin);
            $( document ).on('wp-plugin-install-success' , GyanCustomizerManager._activatePlugin);
            $( document ).on('wp-plugin-install-error'   , GyanCustomizerManager._installError);
            $( document ).on('wp-plugin-installing'      , GyanCustomizerManager._pluginInstalling);
        },

        // Installing Plugin
        _pluginInstalling: function(event, args) {
            event.preventDefault();
            var slug = args.slug;
            var $card = jQuery( '.gyan-install-recommended-plugin' );
            var activatingText = gyanPluginInstall.recommendedPluiginActivatingText;

            $card.each(function( index, element ) {
                element = jQuery( element );
                if ( element.data('slug') === slug ) {
                    element.addClass('updating-message');
                    element.html( activatingText );
                }
            });
        },

        // Activate Success
        _activatePlugin: function( event, response ) {

            event.preventDefault();
            var $message = jQuery(event.target);
            var $init = $message.data('init');
            var activatedSlug;

            if (typeof $init === 'undefined') {
                var $message = jQuery('.gyan-install-recommended-plugin[data-slug=' + response.slug + ']');
                activatedSlug = response.slug;
            } else {
                activatedSlug = $init;
            }

            // Transform the 'Install' button into an 'Activate' button.
            var $init = $message.data('init');
            var activatingText = gyanPluginInstall.recommendedPluiginActivatingText;
            var settingsLink = $message.data('settings-link');
            var settingsLinkText = gyanPluginInstall.recommendedPluiginSettingsText;
            var deactivateText = gyanPluginInstall.recommendedPluiginDeactivateText;
            var afterPluginActivationText = gyanPluginInstall.afterPluginActivationText;
            var gyanSitesLink = gyanPluginInstall.gyanSitesLink;
            var gyanPluginRecommendedNonce = gyanPluginInstall.gyanPluginManagerNonce;

            $message.removeClass( 'install-now installed button-disabled updated-message' )
                .addClass('updating-message')
                .html( activatingText );

            // WordPress adds "Activate" button after waiting for 1000ms. So we will run our activation after that.
            setTimeout( function() {
                $.ajax({
                    url: gyanPluginInstall.ajaxUrl,
                    type: 'POST',
                    data: {
                        'action'            : 'gyan-sites-plugin-activate',
                        'nonce'             : gyanPluginRecommendedNonce,
                        'init'              : $init,
                    },
                })
                .done(function (result) {
                    if( result.success ) {
                        var output  = '<a href="#" class="gyan-deactivate-recommended-plugin button button-secondary" data-init="'+ $init +'" data-settings-link="'+ settingsLink +'" data-settings-link-text="'+ deactivateText +'" aria-label="'+ deactivateText +'">'+ deactivateText +'</a>';
                            output += ( typeof settingsLink === 'string' && settingsLink != 'undefined' ) ? '<a href="' + settingsLink +'" aria-label="'+ settingsLinkText +'">' + settingsLinkText +' </a>' : '';
                            output += ( typeof settingsLink === undefined && settingsLink != undefined ) ? '<a href="' + settingsLink +'" aria-label="'+ settingsLinkText +'">' + settingsLinkText +' </a>' : '';

                        $message.removeClass( 'gyan-activate-recommended-plugin gyan-install-recommended-plugin button button-primary install-now activate-now updating-message' );

                        $message.parent('.gyan-recommended-plugin').addClass('active');
                        $message.parents('.gyan-recommended-plugin').html( output );
                        $( '.gyan-customizer-ie-path').hide();
                        $( '.gyanAfterPluginActivationText').show();
                        $( '.gyanAfterPluginActivationText').html( afterPluginActivationText );

                    } else {
                        $message.removeClass( 'updating-message' );
                    }

                });

            }, 1200 );

        },

        // Activate Success
        _deactivatePlugin: function( event, response ) {

            event.preventDefault();
            var $message = jQuery(event.target);
            var $init = $message.data('init');

            if (typeof $init === 'undefined') {
                var $message = jQuery('.gyan-install-recommended-plugin[data-slug=' + response.slug + ']');
            }

            // Transform the 'Install' button into an 'Activate' button.
            var $init = $message.data('init');
            var deactivatingText = $message.data('deactivating-text') || gyanPluginInstall.recommendedPluiginDeactivatingText;
            var settingsLink = $message.data('settings-link');
            var activateText = gyanPluginInstall.recommendedPluiginActivateText;
            var gyanPluginRecommendedNonce = gyanPluginInstall.gyanPluginManagerNonce;

            $message.removeClass( 'install-now installed button-disabled updated-message' )
                .addClass('updating-message')
                .html( deactivatingText );

            // WordPress adds "Activate" button after waiting for 1000ms. So we will run our activation after that.
            setTimeout( function() {

                $.ajax({
                    url: gyanPluginInstall.ajaxUrl,
                    type: 'POST',
                    data: {
                        'action'            : 'gyan-sites-plugin-deactivate',
                        'nonce'             : gyanPluginRecommendedNonce,
                        'init'              : $init,
                    },
                })
                .done(function (result) {

                    if( result.success ) {
                        var output = '<a href="#" class="gyan-activate-recommended-plugin button button-primary" data-init="'+ $init +'" data-settings-link="'+ settingsLink +'" data-settings-link-text="'+ activateText +'" aria-label="'+ activateText +'">'+ activateText +'</a>';
                        $message.removeClass( 'gyan-activate-recommended-plugin gyan-install-recommended-plugin button button-secondary install-now activate-now updating-message' );

                        $message.parent('.gyan-recommended-plugin').removeClass('active');
                        $message.parents('.gyan-recommended-plugin').html( output );

                    } else {

                        $message.removeClass( 'updating-message' );

                    }

                });

            }, 1200 );

        },

        // Install Now
        _installNow: function(event) {
            event.preventDefault();

            var $button     = jQuery( event.target ),
                $document   = jQuery(document);

            if ( $button.hasClass( 'updating-message' ) || $button.hasClass( 'button-disabled' ) ) {
                return;
            }

            if ( wp.updates.shouldRequestFilesystemCredentials && ! wp.updates.ajaxLocked ) {
                wp.updates.requestFilesystemCredentials( event );

                $document.on( 'credential-modal-cancel', function() {
                    var $message = $( '.gyan-install-recommended-plugin.updating-message' );

                    $message
                        .addClass('gyan-activate-recommended-plugin')
                        .removeClass( 'updating-message gyan-install-recommended-plugin' )
                        .text( wp.updates.l10n.installNow );

                    wp.a11y.speak( wp.updates.l10n.updateCancel, 'polite' );
                } );
            }

            wp.updates.installPlugin( {
                slug:    $button.data( 'slug' )
            });
        },

        // Plugin Installation Error
        _installError: function( event, response ) {
            var $card = jQuery( '.gyan-install-recommended-plugin' );
            $card
                .removeClass( 'button-primary' )
                .addClass( 'disabled' )
                .html( wp.updates.l10n.installFailedShort );
        },

        _CustomizerOptions: function(event) {

            $( '.gyan-customizer-check-all' ).on('click',( function() {
                $('.gyan-customizer-editor-checkbox').each( function() {
                    this.checked = true;
                } );
                return false;
            } ));

            $( '.gyan-customizer-uncheck-all' ).on('click',( function() {
                $('.gyan-customizer-editor-checkbox').each( function() {
                    this.checked = false;
                } );
                return false;
            } ));

        },

    };  // GyanCustomizerManager

    $(function(){
        GyanCustomizerManager.init();
    });

})(jQuery);