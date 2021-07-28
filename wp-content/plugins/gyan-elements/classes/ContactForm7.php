<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
class ContactForm7 {
	public function __construct() {

		if ( ! defined( 'CF7MSM_PLUGIN' ) && function_exists( 'wpcf7_enqueue_scripts' ) && apply_filters( 'swm_conditional_wpcf7_scripts', true ) ) {
			add_filter( 'wpcf7_load_css', '__return_false' );  // Remove CSS Completely - theme adds styles
			add_filter( 'wpcf7_load_js', '__return_false' );  // Remove JS
			add_action( 'wpcf7_contact_form', array( $this, 'enqueue_scripts' ), 1 );  // Conditionally load JS
		}
	}

	public function enqueue_scripts() {
		wpcf7_enqueue_scripts();
		wpcf7_enqueue_styles();
	}

}
new ContactForm7();