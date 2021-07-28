<?php
/* Mega Menu class */

$Swm_Mega_Menu_Columns_Values = array(
    1 => '1',
    2 => '2',
    3 => '3',
    4 => '4'
);

$Swm_Mega_Menu_Columns_Values = apply_filters( 'swm_mega_menu_columns_number', $Swm_Mega_Menu_Columns_Values );

$Swm_Mega_Menu_Styles_Values = array(
    'default' => 'Style 1',
    'grid' => 'Style 2'
);

$Swm_Mega_Menu_Image_Position_Values = array(
    'left top' => esc_html__( 'Left Top', 'bizix' ),
    'left center' => esc_html__( 'Left Center', 'bizix' ),
    'left bottom' => esc_html__( 'Left Bottom', 'bizix' ),
    'center top' => esc_html__( 'Center Top', 'bizix' ),
    'center bottom' => esc_html__( 'Center Bottom', 'bizix' ),
    'center center' => esc_html__( 'Center Center', 'bizix' ),
    'right top' => esc_html__( 'Right Top', 'bizix' ),
    'right center' => esc_html__( 'Right Center', 'bizix' ),
    'right bottom' => esc_html__( 'Right Bottom', 'bizix' )
);

$Swm_Mega_Menu_Default = array(
    'icon' => '',
    'enable' => false,
    'masonry' => false,
    'columns' => 4,
    'image' => '',
    'image_position' => 'center center',
    'width' => 295,
    'not_link' => false,
    'not_show' => false,
    'new_row' => false,
    'label' => '',
    'padding_left' => '0px',
    'padding_top' => '0px',
    'padding_right' => '0px',
    'padding_bottom' => '0px',
    'style' => 'default',
);

class Swm_Mega_Menu {

	public $fat_menu = false;
	public $fat_columns = 3;

	function __construct() {

		// add custom menu fields to menu
		add_filter( 'wp_setup_nav_menu_item', array( $this, 'add_custom_nav_fields' ) );

		// save menu custom fields
		add_action( 'wp_update_nav_menu_item', array( $this, 'update_custom_nav_fields' ), 10, 3 );

		// replace menu walker
		add_filter( 'wp_edit_nav_menu_walker', array( $this, 'replace_walker_class' ), 90, 2 );

		// add admin css
		add_action( 'admin_print_styles-nav-menus.php', array( $this, 'add_admin_menu_inline_css' ), 15 );

		// add some javascript
		add_action( 'admin_print_footer_scripts', array( $this, 'javascript_magick' ), 99 );

		// add media uploader
		add_action( 'admin_enqueue_scripts', array( $this, 'uploader_scripts' ), 15 );
	}

	function add_custom_nav_fields( $menu_item ) {
        global $Swm_Mega_Menu_Columns_Values, $Swm_Mega_Menu_Image_Position_Values, $Swm_Mega_Menu_Default, $Swm_Mega_Menu_Styles_Values;

        $data = get_post_meta( $menu_item->ID, '_menu_item_swm_mega_menu', true );
        $menu_item->swm_mega_menu = array_merge($Swm_Mega_Menu_Default, (array) $data);

        $menu_item->swm_mega_menu_columns_values = $Swm_Mega_Menu_Columns_Values;
        $menu_item->swm_mega_menu_image_position_values = $Swm_Mega_Menu_Image_Position_Values;
        $menu_item->swm_mega_menu_default = $Swm_Mega_Menu_Default;
        $menu_item->swm_mega_menu_styles_values = $Swm_Mega_Menu_Styles_Values;

        $menu_item->swm_mobile_clickable = get_post_meta( $menu_item->ID, '_menu_item_swm_mobile_clickable', true );

		return $menu_item;
	}

	function update_custom_nav_fields( $menu_id, $menu_item_db_id, $args ) {
        global $Swm_Mega_Menu_Columns_Values, $Swm_Mega_Menu_Image_Position_Values, $Swm_Mega_Menu_Default, $Swm_Mega_Menu_Styles_Values;

        $data = get_post_meta( $menu_item_db_id, '_menu_item_swm_mega_menu', true );
        $menu_data = array_merge($Swm_Mega_Menu_Default, (array) $data);

        if ( isset($_REQUEST['swm_mega_menu_icon'], $_REQUEST['swm_mega_menu_icon'][$menu_item_db_id]) ) {
            $menu_data['icon'] = $_REQUEST['swm_mega_menu_icon'][$menu_item_db_id];
        }

        $menu_data['enable'] = isset($_REQUEST['swm_mega_menu_enable'], $_REQUEST['swm_mega_menu_enable'][$menu_item_db_id]);
        $menu_data['masonry'] = isset($_REQUEST['swm_mega_menu_masonry'], $_REQUEST['swm_mega_menu_masonry'][$menu_item_db_id]);

        if ( isset($_REQUEST['swm_mega_menu_columns'], $_REQUEST['swm_mega_menu_columns'][$menu_item_db_id]) ) {
            $menu_data['columns'] = absint($_REQUEST['swm_mega_menu_columns'][$menu_item_db_id]);
            $valid_values = array_keys($Swm_Mega_Menu_Columns_Values);
            if (!in_array($menu_data['columns'], $valid_values)) {
                $menu_data['columns'] = $Swm_Mega_Menu_Default['columns'];
            }
        }

        if ( isset($_REQUEST['swm_mega_menu_style'], $_REQUEST['swm_mega_menu_style'][$menu_item_db_id]) ) {
            $menu_data['style'] = $_REQUEST['swm_mega_menu_style'][$menu_item_db_id];
            $valid_values = array_keys($Swm_Mega_Menu_Styles_Values);
            if (!in_array($menu_data['style'], $valid_values)) {
                $menu_data['style'] = $Swm_Mega_Menu_Default['style'];
            }
        }

        if ( isset($_REQUEST['swm_mega_menu_image'], $_REQUEST['swm_mega_menu_image'][$menu_item_db_id]) ) {
            $menu_data['image'] = $_REQUEST['swm_mega_menu_image'][$menu_item_db_id];
        }

        if ( isset($_REQUEST['swm_mega_menu_image_position'], $_REQUEST['swm_mega_menu_image_position'][$menu_item_db_id]) ) {
            $menu_data['image_position'] = $_REQUEST['swm_mega_menu_image_position'][$menu_item_db_id];
            $valid_values = array_keys($Swm_Mega_Menu_Image_Position_Values);
            if (!in_array($menu_data['image_position'], $valid_values)) {
                $menu_data['image_position'] = $Swm_Mega_Menu_Default['image_position'];
            }
        }

        if ( isset($_REQUEST['swm_mega_menu_width'], $_REQUEST['swm_mega_menu_width'][$menu_item_db_id]) ) {
            $menu_data['width'] = absint($_REQUEST['swm_mega_menu_width'][$menu_item_db_id]);
        }

        $menu_data['not_link'] = isset($_REQUEST['swm_mega_menu_not_link'], $_REQUEST['swm_mega_menu_not_link'][$menu_item_db_id]);

        $menu_data['not_show'] = isset($_REQUEST['swm_mega_menu_not_show'], $_REQUEST['swm_mega_menu_not_show'][$menu_item_db_id]);

        $menu_data['new_row'] = isset($_REQUEST['swm_mega_menu_new_row'], $_REQUEST['swm_mega_menu_new_row'][$menu_item_db_id]);

        if ( isset($_REQUEST['swm_mega_menu_label'], $_REQUEST['swm_mega_menu_label'][$menu_item_db_id]) ) {
            $menu_data['label'] = $_REQUEST['swm_mega_menu_label'][$menu_item_db_id];
        }

        if ( isset($_REQUEST['swm_mega_menu_padding_left'], $_REQUEST['swm_mega_menu_padding_left'][$menu_item_db_id]) ) {
            $menu_data['padding_left'] = $_REQUEST['swm_mega_menu_padding_left'][$menu_item_db_id];

            if (preg_match('%^\d+$%', $menu_data['padding_left'])) {
                $menu_data['padding_left'] .= 'px';
            }
        }

        if ( isset($_REQUEST['swm_mega_menu_padding_right'], $_REQUEST['swm_mega_menu_padding_right'][$menu_item_db_id]) ) {
            $menu_data['padding_right'] = $_REQUEST['swm_mega_menu_padding_right'][$menu_item_db_id];

            if (preg_match('%^\d+$%', $menu_data['padding_right'])) {
                $menu_data['padding_right'] .= 'px';
            }
        }

        if ( isset($_REQUEST['swm_mega_menu_padding_top'], $_REQUEST['swm_mega_menu_padding_top'][$menu_item_db_id]) ) {
            $menu_data['padding_top'] = $_REQUEST['swm_mega_menu_padding_top'][$menu_item_db_id];

            if (preg_match('%^\d+$%', $menu_data['padding_top'])) {
                $menu_data['padding_top'] .= 'px';
            }
        }

        if ( isset($_REQUEST['swm_mega_menu_padding_bottom'], $_REQUEST['swm_mega_menu_padding_bottom'][$menu_item_db_id]) ) {
            $menu_data['padding_bottom'] = $_REQUEST['swm_mega_menu_padding_bottom'][$menu_item_db_id];

            if (preg_match('%^\d+$%', $menu_data['padding_bottom'])) {
                $menu_data['padding_bottom'] .= 'px';
            }
        }

        update_post_meta( $menu_item_db_id, '_menu_item_swm_mega_menu', $menu_data );

        if (isset($_REQUEST['swm_mobile_clickable'], $_REQUEST['swm_mobile_clickable'][$menu_item_db_id])) {
        	update_post_meta( $menu_item_db_id, '_menu_item_swm_mobile_clickable', true );
        } else {
        	update_post_meta( $menu_item_db_id, '_menu_item_swm_mobile_clickable', false );
        }
	}

	function replace_walker_class( $walker, $menu_id ) {

		if ( 'Walker_Nav_Menu_Edit' == $walker ) {
			$walker = 'Swm_Edit_Mega_Menu_Walker';
		}

		return $walker;
	}

	function add_admin_menu_inline_css() {
		$css = '
            .wrapper-swm-mobile-clickable {
                padding-top: 10px;
            }

			.menu.ui-sortable .swm-megamenu-fields p,.field-section-megamanu-enable,.field-section-megamanu-subitem-enable {
				display: none;
			}

            .menu.ui-sortable .menu-item-depth-2.field-swm-megamenu-on .swm-megamenu-fields .field-swm-megamenu-label span.description { display:block; }

            .menu.ui-sortable .swm-megamenu-fields p select {
                width: 190px;
            }

			.menu.ui-sortable .menu-item-depth-0 .swm-megamenu-fields .field-swm-megamenu-on,
            .menu.ui-sortable .menu-item-depth-0.field-swm-megamenu-on .swm-megamenu-fields .field-swm-megamenu-columns,
            .menu.ui-sortable .menu-item-depth-0.field-swm-megamenu-on .swm-megamenu-fields .field-section-megamanu-enable,
            .menu.ui-sortable .menu-item-depth-0.field-swm-megamenu-on .swm-megamenu-fields .field-swm-megamenu-image,
            .menu.ui-sortable .menu-item-depth-0.field-swm-megamenu-on .swm-megamenu-fields .field-swm-megamenu-image-position {
				display: block;
			}

            .menu.ui-sortable .menu-item-depth-1.field-swm-megamenu-on .swm-megamenu-fields .field-section-megamanu-subitem-enable,
            .menu.ui-sortable .menu-item-depth-1.field-swm-megamenu-on .swm-megamenu-fields .field-swm-megamenu-width,
            .menu.ui-sortable .menu-item-depth-1.field-swm-megamenu-on .swm-megamenu-fields .field-swm-megamenu-not-link,
            .menu.ui-sortable .menu-item-depth-1.field-swm-megamenu-on .swm-megamenu-fields .field-swm-megamenu-not-show,
            .menu.ui-sortable .menu-item-depth-1.field-swm-megamenu-on .swm-megamenu-fields .field-swm-megamenu-new-row {
                display: block;
            }

            .menu.ui-sortable .menu-item-depth-2.field-swm-megamenu-on .swm-megamenu-fields .field-swm-megamenu-label {
                display: block;
            }

            .field-section-megamanu-enable,
            .field-section-megamanu-subitem-enable {
                border:1px solid #e6e6e6;
                background:#f4f4f4;
                padding:15px;
                margin:10px 10px 10px 0;
            }
		';
		wp_add_inline_style( 'wp-admin', $css );
	}

	function uploader_scripts() {
		if ( function_exists( 'wp_enqueue_media' ) ) {
			wp_enqueue_media();
		}
	}

	function javascript_magick() {
		?>
		<script type="text/javascript">
			jQuery(function(){

                "use strict";

				var swm_mega_menu = {
					reTimeout: false,

					recalc : function() {
						var $menuItems = jQuery('.menu-item', '#menu-to-edit');

						$menuItems.each( function(i) {
							var $item = jQuery(this),
								$checkbox = jQuery('.swm-edit-menu-item-icon-enable', this);

							if ( !$item.is('.menu-item-depth-0') ) {

								var checkItem = $menuItems.filter(':eq('+(i-1)+')');
								if ( checkItem.is('.field-swm-megamenu-on') ) {
									$item.addClass('field-swm-megamenu-on');
									$checkbox.attr('checked','checked');
								} else {
									$item.removeClass('field-swm-megamenu-on');
									$checkbox.attr('checked','');
								}
							}

						});

					},

					binds: function() {

						jQuery('#menu-to-edit').on('click', '.swm-edit-menu-item-icon-enable', function(event) {
							var $checkbox = jQuery(this),
								$container = $checkbox.closest('.menu-item');

                            if ( $checkbox.is(':checked') ) {
								$container.addClass('field-swm-megamenu-on');
							} else {
								$container.removeClass('field-swm-megamenu-on');
							}

							swm_mega_menu.recalc();

							return true;
						});

					},

					init: function() {
						swm_mega_menu.binds();
						swm_mega_menu.recalc();

						jQuery( ".menu-item-bar" ).mouseup(function(event, ui) {
							if ( !jQuery(event.target).is('a') ) {
								clearTimeout(swm_mega_menu.reTimeout);
								swm_mega_menu.reTimeout = setTimeout(swm_mega_menu.recalc, 700);
							}
						});
					},


				}

				swm_mega_menu.init();
			});

		</script>
		<?php
	}
}

include_once( get_template_directory() . '/functions/megamenu/edit-megamenu-walker-class.php' );