<?php

class Swm_Edit_Mega_Menu_Walker extends Walker_Nav_Menu {

	function start_lvl( &$output, $depth = 0, $args = array() ) {}
	function end_lvl( &$output, $depth = 0, $args = array() ) {}

	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

		global $_wp_nav_menu_max_depth;
		$_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;

		ob_start();
		$item_id = esc_attr( $item->ID );
		$removed_args = array(
			'action',
			'customlink-tab',
			'edit-menu-item',
			'menu-item',
			'page-tab',
			'_wpnonce',
		);

		$original_title = false;
		if ( 'taxonomy' == $item->type ) {
			$original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
			if ( is_wp_error( $original_title ) ) {
				$original_title = false;
			}
		} elseif ( 'post_type' == $item->type ) {
			$original_object = get_post( $item->object_id );
			$original_title  = get_the_title( $original_object->ID );
		} elseif ( 'post_type_archive' == $item->type ) {
			$original_object = get_post_type_object( $item->object );
			if ( $original_object ) {
				$original_title = $original_object->labels->archives;
			}
		}

		$classes = array(
			'menu-item menu-item-depth-' . esc_attr( $depth ),
			'menu-item-' . esc_attr( $item->object ),
			'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
		);

		$title = $item->title;

		if ( ! empty( $item->_invalid ) ) {
			$classes[] = 'menu-item-invalid';
			/* translators: %s: title of menu item which is invalid */
			$title = sprintf( esc_html__( '%s (Invalid)', 'bizix' ), $item->title );
		} elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
			$classes[] = 'pending';
			/* translators: %s: title of menu item in draft status */
			$title = sprintf( esc_html__('%s (Pending)', 'bizix'), $item->title );
		}

		$title = ( ! isset( $item->label ) || '' == $item->label ) ? $title : $item->label;

		$submenu_text = '';
		if ( 0 == $depth ) {
			$submenu_text = 'style="display: none;"';
		}

		// megamenu custom code start ##################
		if (!isset($item->swm_mega_menu)) {
			$item->swm_mega_menu = $menu_item->swm_mega_menu_default;
		}

		$mega_menu_container_classes = array( 'swm-megamenu-fields' );
		if ( $item->swm_mega_menu['enable'] ) {
			$classes[] = 'field-swm-megamenu-on';
		}

		$mega_menu_container_classes = implode( ' ', $mega_menu_container_classes );
		// megamenu custom code end ##################

		?>
		<li id="menu-item-<?php echo esc_attr($item_id); ?>" class="<?php echo esc_attr(implode(' ', $classes )); ?>">
			<dl class="menu-item-bar">
				<dt class="menu-item-handle">
					<span class="item-title"><span class="menu-item-title"><?php echo esc_html( $title ); ?></span> <span class="is-submenu" <?php echo esc_html($submenu_text); ?>><?php esc_html_e( 'sub item', 'bizix' ); ?></span></span>
					<span class="item-controls">
						<span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
						<span class="item-order hide-if-js">
							<a href="<?php
								echo esc_url(wp_nonce_url(
									add_query_arg(
										array(
											'action' => 'move-up-menu-item',
											'menu-item' => $item_id,
										),
										remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
									),
									'move-menu_item'
								));
							?>" class="item-move-up"><abbr title="<?php esc_attr_e('Move up', 'bizix'); ?>">&#8593;</abbr></a>
							|
							<a href="<?php
								echo esc_url(wp_nonce_url(
									add_query_arg(
										array(
											'action' => 'move-down-menu-item',
											'menu-item' => $item_id,
										),
										remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
									),
									'move-menu_item'
								));
							?>" class="item-move-down"><abbr title="<?php esc_attr_e('Move down', 'bizix'); ?>">&#8595;</abbr></a>
						</span>
						<a class="item-edit" id="edit-<?php echo esc_attr($item_id); ?>" title="<?php esc_attr_e('Edit Menu Item', 'bizix'); ?>" href="<?php
							echo esc_url(( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : add_query_arg( 'edit-menu-item', $item_id, remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . esc_attr($item_id) ) ) ));
						?>" aria-label="<?php esc_attr_e( 'Edit menu item', 'bizix' ); ?>"><span class="screen-reader-text"><?php esc_html_e( 'Edit', 'bizix' ); ?></span></a>
					</span>
				</dt>
			</dl>

			<div class="menu-item-settings wp-clearfix" id="menu-item-settings-<?php echo esc_attr($item_id); ?>">
				<?php if( 'custom' == $item->type ) : ?>
					<p class="field-url description description-wide">
						<label for="edit-menu-item-url-<?php echo esc_attr($item_id); ?>">
							<?php esc_html_e( 'URL', 'bizix' ); ?><br />
							<input type="text" id="edit-menu-item-url-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
						</label>
					</p>
				<?php endif; ?>
				<p class="description description-thin">
					<label for="edit-menu-item-title-<?php echo esc_attr($item_id); ?>">
						<?php esc_html_e( 'Navigation Label', 'bizix' ); ?><br />
						<input type="text" id="edit-menu-item-title-<?php echo esc_attr($item_id); ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
					</label>
				</p>
				<p class="description description-thin">
					<label for="edit-menu-item-attr-title-<?php echo esc_attr($item_id); ?>">
						<?php esc_html_e( 'Title Attribute', 'bizix' ); ?><br />
						<input type="text" id="edit-menu-item-attr-title-<?php echo esc_attr($item_id); ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
					</label>
				</p>
				<p class="field-link-target description">
					<label for="edit-menu-item-target-<?php echo esc_attr($item_id); ?>">
						<input type="checkbox" id="edit-menu-item-target-<?php echo esc_attr($item_id); ?>" value="_blank" name="menu-item-target[<?php echo esc_attr($item_id); ?>]"<?php checked( $item->target, '_blank' ); ?> />
						<?php esc_html_e( 'Open link in a new window/tab', 'bizix' ); ?>
					</label>
				</p>
				<p class="field-css-classes description description-thin">
					<label for="edit-menu-item-classes-<?php echo esc_attr($item_id); ?>">
						<?php esc_html_e( 'CSS Classes (optional)', 'bizix' ); ?><br />
						<input type="text" id="edit-menu-item-classes-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( implode(' ', $item->classes ) ); ?>" />
					</label>
				</p>
				<p class="field-xfn description description-thin">
					<label for="edit-menu-item-xfn-<?php echo esc_attr($item_id); ?>">
						<?php esc_html_e( 'Link Relationship (XFN)', 'bizix' ); ?><br />
						<input type="text" id="edit-menu-item-xfn-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
					</label>
				</p>
				<p class="field-description description description-wide">
					<label for="edit-menu-item-description-<?php echo esc_attr($item_id); ?>">
						<?php esc_html_e( 'Description', 'bizix' ); ?><br />
						<textarea id="edit-menu-item-description-<?php echo esc_attr($item_id); ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo esc_attr($item_id); ?>]"><?php echo esc_html( $item->description ); ?></textarea>
						<span class="description"><?php esc_html_e('The description will be displayed in the menu if the current theme supports it.', 'bizix'); ?></span>
					</label>
				</p>

				<!--  MEGAMENU CUSTOM CODE START HERE  -->

				<p class="field-swm-megamenu-icon description">
                        <label for="edit-swm_mega_menu_icon-<?php echo esc_attr($item_id); ?>">
                            <?php esc_html_e( 'Icon', 'bizix' ); ?><br />
                            <input id="edit-swm_mega_menu_icon-<?php echo esc_attr($item_id); ?>" class="swm-edit-menu-item-icon" type="text" name="swm_mega_menu_icon[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_html( $item->swm_mega_menu['icon'] ); ?>"/><br />
                            <span class="description">
								<?php echo sprintf( esc_html__( 'Enter icon name. %1$s to get Solid Icons Reference Page.', 'bizix' ), '<a href="https://fontawesome.com/cheatsheet/free/solid" target="_blank">Click Here</a>' ); ?><br />
								<?php echo esc_html__( 'For Regular and Brands icons add "regular" or "brands" word next to icon name . ( e.g "clock regular", "twitter brands")', 'bizix' ); ?>
							</span>
                        </label>
                    </p>

				<div class="<?php echo esc_attr( $mega_menu_container_classes ); ?>" style="clear: both;">

					<!-- first level -->
					<p class="field-swm-megamenu-on">
						<label for="edit-swm_mega_menu_enable-<?php echo esc_attr($item_id); ?>">
							<input id="edit-swm_mega_menu_enable-<?php echo esc_attr($item_id); ?>" type="checkbox" class="swm-edit-menu-item-icon-enable" name="swm_mega_menu_enable[<?php echo esc_attr($item_id); ?>]" <?php checked( $item->swm_mega_menu['enable'] ); ?>/>
							<?php echo esc_html__( 'Enable Mega Menu', 'bizix' ); ?>
						</label>
					</p>

					<div <?php if ( 0 == $depth ) { echo 'class="field-section-megamanu-enable "'; } ?> >

						<p class="field-swm-megamenu-columns description">
		                    <label for="edit-swm_mega_menu_columns-<?php echo esc_attr($item_id); ?>">
								<?php esc_html_e( 'Mega Menu - Number of columns: ', 'bizix' ); ?><br />
								<select name="swm_mega_menu_columns[<?php echo esc_attr($item_id); ?>]" for="edit-swm_mega_menu_columns-<?php echo esc_attr($item_id); ?>">
									<?php foreach( $item->swm_mega_menu_columns_values as $value=>$title): ?>
										<option value="<?php echo esc_attr($value); ?>" <?php selected($value, $item->swm_mega_menu['columns']); ?>><?php echo esc_html($title); ?></option>
									<?php endforeach; ?>
								</select>
		                    </label>
						</p>

						<p class="field-swm-megamenu-image description">
							<label for="edit-swm_mega_menu_image-<?php echo esc_attr($item_id); ?>">
								<?php esc_html_e( 'Mega Menu - Background image', 'bizix' ); ?><br />
								<input id="edit-swm_mega_menu_image-<?php echo esc_attr($item_id); ?>" class= "swm-edit-menu-item-image picture-select" type="text" name="swm_mega_menu_image[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_html( $item->swm_mega_menu['image'] ); ?>"/>
								<button class="picture-select-button"><?php esc_html_e( 'Select', 'bizix' ); ?></button>
							</label>
						</p>

						 <p class="field-swm-megamenu-image-position description">
		                    <label for="edit-swm_mega_menu_image_position-<?php echo esc_attr($item_id); ?>">
		                        <?php esc_html_e( 'Mega Menu - Background Image Position: ', 'bizix' ); ?><br />
		                        <select name="swm_mega_menu_image_position[<?php echo esc_attr($item_id); ?>]" for="edit-swm_mega_menu_image_position-<?php echo esc_attr($item_id); ?>">
		                            <?php foreach( $item->swm_mega_menu_image_position_values as $value=>$title): ?>
		                                <option value="<?php echo esc_attr($value); ?>" <?php selected($value, $item->swm_mega_menu['image_position']); ?>><?php echo esc_html($title); ?></option>
		                            <?php endforeach; ?>
		                        </select>
		                    </label>
		                </p>
	            	</div>

					<!-- second level -->

					<div class="field-section-megamanu-subitem-enable">

	                    <p class="field-swm-megamenu-width description">
	                        <label for="edit-swm_mega_menu_width-<?php echo esc_attr($item_id); ?>">
	                            <?php esc_html_e( 'Column width', 'bizix' ); ?><br />
	                            <input id="edit-swm_mega_menu_width-<?php echo esc_attr($item_id); ?>" class= "swm-edit-menu-item-width" type="text" name="swm_mega_menu_width[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_html( $item->swm_mega_menu['width'] ); ?>"/>
	                        </label>
	                    </p>

	                     <p class="field-swm-megamenu-not-link">
	                        <label for="edit-swm_mega_menu_not_link-<?php echo esc_attr($item_id); ?>">
	                            <input id="edit-swm_mega_menu_not_link-<?php echo esc_attr($item_id); ?>" type="checkbox" class="swm-edit-menu-item-not-link" name="swm_mega_menu_not_link[<?php echo esc_attr($item_id); ?>]" <?php checked( $item->swm_mega_menu['not_link'] ); ?>/>
	                            <?php esc_html_e( 'Do not add link on this Mega menu columns title', 'bizix' ); ?>
	                        </label>
	                    </p>

						 <p class="field-swm-megamenu-not-show">
	                        <label for="edit-swm_mega_menu_not_show-<?php echo esc_attr($item_id); ?>">
	                            <input id="edit-swm_mega_menu_not_show-<?php echo esc_attr($item_id); ?>" type="checkbox" class="swm-edit-menu-item-not-show" name="swm_mega_menu_not_show[<?php echo esc_attr($item_id); ?>]" <?php checked( $item->swm_mega_menu['not_show'] ); ?>/>
	                            <?php esc_html_e( 'Do not show this Mega menu column title', 'bizix' ); ?>
	                        </label>
	                    </p>
	                </div>

	            </div>

				<!--  MEGAMENU CUSTOM CODE END HERE  -->

				<p class="field-move hide-if-no-js description description-wide">
					<label>
						<span><?php esc_html_e( 'Move', 'bizix' ); ?></span>
						<a href="#" class="menus-move-up"><?php esc_html_e( 'Up one', 'bizix' ); ?></a>
						<a href="#" class="menus-move-down"><?php esc_html_e( 'Down one', 'bizix' ); ?></a>
						<a href="#" class="menus-move-left"></a>
						<a href="#" class="menus-move-right"></a>
						<a href="#" class="menus-move-top"><?php esc_html_e( 'To the top', 'bizix' ); ?></a>
					</label>
				</p>

				<div class="menu-item-actions description-wide submitbox">
					<?php if( 'custom' != $item->type && $original_title !== false ) : ?>
						<p class="link-to-original">
							<?php printf( esc_html__('Original: %s', 'bizix'), '<a href="' . esc_url(esc_attr( $item->url )) . '">' . esc_html( $original_title ) . '</a>' ); ?>
						</p>
					<?php endif; ?>
					<a class="item-delete submitdelete deletion" id="delete-<?php echo esc_attr($item_id); ?>" href="<?php
					echo esc_url(wp_nonce_url(
						add_query_arg(
							array(
								'action' => 'delete-menu-item',
								'menu-item' => $item_id,
							),
							admin_url( 'nav-menus.php' )
						),
						'delete-menu_item_' . esc_attr($item_id)
					)); ?>"><?php esc_html_e( 'Remove', 'bizix' ); ?></a> <span class="meta-sep hide-if-no-js"> | </span> <a class="item-cancel submitcancel hide-if-no-js" id="cancel-<?php echo esc_attr($item_id); ?>" href="<?php echo esc_url( add_query_arg( array( 'edit-menu-item' => $item_id, 'cancel' => time() ), admin_url( 'nav-menus.php' ) ) );
						?>#menu-item-settings-<?php echo esc_attr($item_id); ?>"><?php esc_html_e('Cancel', 'bizix'); ?></a>
				</div>

				<input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr($item_id); ?>" />
				<input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
				<input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
				<input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
				<input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
				<input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
			</div><!-- .menu-item-settings-->
			<ul class="menu-item-transport"></ul>
		<?php
		$output .= ob_get_clean();

	}
}