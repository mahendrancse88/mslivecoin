<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class gyanCustomSidebars {

	protected $custom_sidebars	= array();
	protected $orig			= array();

	public function __construct( $custom_sidebars = array() ) {
		add_action( 'widgets_init', array( $this, 'register_sidebars' ), 1000 );
		add_action( 'admin_print_scripts-widgets.php', array( $this, 'add_new_sidebar_box' ) );
		add_action( 'load-widgets.php', array( $this, 'add_new_sidebar' ), 100 );
		add_action( 'load-widgets.php', array( $this, 'load_scripts' ), 100 );
		add_action( 'wp_ajax_gyan_delete_custom_sidebar', array( $this, 'gyan_delete_custom_sidebar' ) );
	}

	/* Add the widget box inside a script */
	public function add_new_sidebar_box() {
		$nonce = wp_create_nonce ( 'delete-gyan-custom_sidebar-nonce' ); ?>
		  <script type="text/html" id="gyan-add-sidebar-template">
			<div id="gyan-add-sidebar" class="widgets-holder-wrap">
			 <div class="">
			  <input type="hidden" name="gyan-nonce" value="<?php echo esc_attr( $nonce ); ?>" />
			  <div class="sidebar-name">
			   <h3><?php esc_html_e( 'Add New Sidebar', 'gyan-elements' ); ?> <span class="spinner"></span></h3>
			  </div>
			  <div class="sidebar-description">
				<form id="add-new-sidebar-form" action="" method="post">
				  <div class="widget-content">
					<input id="gyan-add-sidebar-input" name="gyan-add-sidebar-input" type="text" class="regular-text" title="<?php esc_attr_e( 'Enter New Widget Area Name', 'gyan-elements' ); ?>" placeholder="<?php esc_attr_e( 'Sidebar Name', 'gyan-elements' ); ?>" />
				  </div>
				  <div class="widget-control-actions">
					  <input class="add-new-sidebar-button button-primary" type="submit" value="<?php esc_attr_e( 'Add', 'gyan-elements' ); ?>" />
				  </div>
				  <div class="clear"></div>
				</form>
			  </div>
			 </div>
			</div>
		  </script>
		<?php
	}

	/* Create new Widget Area */
	public function add_new_sidebar() {
		if ( ! empty( $_POST['gyan-add-sidebar-input'] ) ) {
			$this->custom_sidebars = $this->get_custom_sidebars();
			array_push( $this->custom_sidebars, $this->check_custom_sidebar_name( $_POST['gyan-add-sidebar-input'] ) );
			$this->save_custom_sidebars();
			wp_redirect( admin_url( 'widgets.php' ) );
			die();
		}
	}

	/* Before we create a new custom sidebar, verify it doesn't already exist. If it does, append a number to the name. */
	public function check_custom_sidebar_name( $name ) {
		if ( empty( $GLOBALS['gyan_registered_custom_sidebars'] ) ) {
			return $name;
		}

		$taken = array();
		foreach ( $GLOBALS['gyan_registered_custom_sidebars'] as $custom_sidebar ) {
			$taken[] = $custom_sidebar['name'];
		}

		$taken = array_merge( $taken, $this->custom_sidebars );

		if ( in_array( $name, $taken ) ) {
			$counter  = substr( $name, -1 );
			$new_name = "";

			if ( ! is_numeric( $counter ) ) {
				$new_name = $name . " 1";
			} else {
				$new_name = substr( $name, 0, -1 ) . ((int) $counter + 1);
			}

			$name = $this->check_custom_sidebar_name( $new_name );
		}
		echo esc_html( $name );
		exit();
	}

	public function save_custom_sidebars() {
		set_theme_mod( 'gyan_custom_sidebars', array_unique( $this->custom_sidebars ) );
	}

	/* Register and display the custom custom_sidebar areas we have set. */
	public function register_sidebars() {

		// Register new widget areas from $this->type post type

		// Get widget areas
		if ( empty( $this->custom_sidebars ) ) {
			$this->custom_sidebars = $this->get_custom_sidebars();
		}

		// Original widget areas is empty
		$this->orig = array();

		// Save widget areas
		if ( ! empty( $this->orig ) && $this->orig != $this->custom_sidebars ) {
			$this->custom_sidebars = array_unique( array_merge( $this->custom_sidebars, $this->orig ) );
			$this->save_custom_sidebars();
		}

		// If widget areas are defined add a sidebar area for each
		if ( is_array( $this->custom_sidebars ) ) {
			foreach ( array_unique( $this->custom_sidebars ) as $custom_sidebar ) {
				$args = array(
					'id'			=> sanitize_key( $custom_sidebar ),
					'name'			=> $custom_sidebar,
					'class'			=> 'gyan-custom',
					'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="swm-sidebar-widget-box"><div class="swm-widget-content">',
					'after_widget' => '<div class="clear"></div></div></div></div>',
					'before_title' => '<div class="swm-sidebar-ttl"><h3><span>',
					'after_title' => '</span></h3><div class="clear"></div></div><div class="clear"></div>'
				);
				register_sidebar( $args );
			}
		}
	}

	/* Return the get_custom_sidebars array. */
	public function get_custom_sidebars() {

		// If the single instance hasn't been set, set it now.
		if ( ! empty( $this->custom_sidebars ) ) {
			return $this->custom_sidebars;
		}

		// Create theme mode to save new sidebar
		$get_custom_sidebars = get_theme_mod( 'gyan_custom_sidebars' );

		// If theme mod isn't empty set to class widget area var
		if ( ! empty( $get_custom_sidebars ) && is_array( $get_custom_sidebars ) ) {
			$this->custom_sidebars = array_unique( array_merge( $this->custom_sidebars, $get_custom_sidebars ) );
		}

		return $this->custom_sidebars;
	}

	public function gyan_delete_custom_sidebar() {
		// Check_ajax_referer('delete-gyan-custom_sidebar-nonce');
		if ( ! empty( $_REQUEST['name'] ) ) {
			$name = strip_tags( ( stripslashes( $_REQUEST['name'] ) ) );
			$this->custom_sidebars = $this->get_custom_sidebars();
			$key = array_search($name, $this->custom_sidebars );
			if ( $key >= 0 ) {
				unset( $this->custom_sidebars[$key] );
				$this->save_custom_sidebars();
			}
			echo "custom-sidebar-is-removed";
		}
		die();
	}

	/* Enqueue JS for the customizer controls */
	public function load_scripts() {

		// Load scripts
		wp_enqueue_style( 'dashicons' );
		$gyan_min_js = get_option('swm_enable_minify_gyan_elements_js',true) ? '-min.js' : '.js';
		wp_enqueue_script('gyan-custom-sidebars', GYAN_PLUGIN_URL . 'sidebars/sidebars' . $gyan_min_js, array( 'jquery' ), GYAN_ELEMENTS_VERSION, true );

		$gyan_min_css = get_option('swm_enable_minify_gyan_elements_css',true) ? '-min.css' : '.css';
		wp_enqueue_style('gyan-custom-sidebars', GYAN_PLUGIN_URL . 'sidebars/sidebars' . $gyan_min_css, false, GYAN_ELEMENTS_VERSION );

		// Get widgets
		$widgets = array();
		if ( ! empty( $this->custom_sidebars ) ) {
			foreach ( $this->custom_sidebars as $widget ) {
				$widgets[$widget] = 1;
			}
		}

		// Localize script
		wp_localize_script('gyan-custom-sidebars', 'gyanLocalizeCustomSidebars', array(
				'count'   => count( $this->orig ),
				'widget_id'  => esc_html__( 'Widget ID', 'gyan-elements' ),
				'delete'  => esc_html__( 'Delete', 'gyan-elements' ),
				'confirm' => esc_html__( 'Confirm', 'gyan-elements' ),
				'cancel'  => esc_html__( 'Cancel', 'gyan-elements' ),
			)
		);
	}

}

new gyanCustomSidebars();