<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class SwmRevSlider {
	public $valid;

	public function __construct() {

		$this->valid = get_option( 'revslider-valid', 'false' );

		if ( is_admin() ) {

			// Remove things when license isn't valid
			if ( 'false' == $this->valid ) {

				global $pagenow;

				// Remove update notice
				if ( 'admin.php' == $pagenow && 'false' == $this->valid ) {
					swm_remove_class_filter( 'admin_notices', 'RevSliderAdmin', 'add_notices', 10 );
				}

				// Remove addons page
				add_action( 'admin_menu', array( $this, 'remove_addons_page' ), 999 );

			}

			// Remove activation notice
			swm_remove_class_filter( 'admin_notices', 'RevSliderAdmin', 'addActivateNotification', 10 );

			// Remove metabox from VC grid builder
			add_action( 'do_meta_boxes', array( $this, 'remove_metabox' ) );

		}

		// Front end functions
		else {

			// Remove front-end meta generator
			add_filter( 'revslider_meta_generator', '__return_false' );

		}

	}

	/* Remove metabox */
	public function remove_metabox() {
		remove_meta_box( 'mymetabox_revslider_0', array( 'vc_grid_item', 'templatera', 'swm_sidebars' ), 'normal' );

		foreach ( get_post_types() as $post_type ) {
			remove_meta_box( 'mymetabox_revslider_0', $post_type, 'normal' );
		}
	}

	/* Remove Addons Page */
	public function remove_addons_page() {
		remove_submenu_page( 'revslider', 'rev_addon' );
	}

	/* Remove duplicate font awesome script */
	public function remove_font_awesome() {
		global $fa_icon_var;
		$fa_icon_var = null;
	}

}

new SwmRevSlider();