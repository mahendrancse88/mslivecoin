<?php

class Swm_Mega_Menu_Walker extends Walker_Nav_Menu {

	private $items_data = array();
	private $tree_megamenu_root = array();
	private $line_columns_count = 0;

	private function get_item_data($item_id) {
		global $Swm_Mega_Menu_Default;

		if (!isset($this->items_data[$item_id])) {
			$data = get_post_meta( $item_id, '_menu_item_swm_mega_menu', true );
			$this->items_data[$item_id] = array_merge($Swm_Mega_Menu_Default, (array) $data);
		}
		return $this->items_data[$item_id];

	}

	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$styles = array();
		$classes = array();

		if ($depth == 0 && $this->tree_megamenu_root['enable'] && !empty($this->tree_megamenu_root['image'])) {
			$styles['background-image'] = "url(" . esc_url($this->tree_megamenu_root['image']) . ")";
			$styles['background-position'] = esc_attr($this->tree_megamenu_root['image_position']);
		}

		$styles_str = '';
		foreach ($styles as $k => $v){
			$styles_str .= $k . ':' . esc_attr($v) . '; ';
		}

		$data_columns = '';
		if ($depth == 0 && $this->tree_megamenu_root['enable']){
			$data_columns = ' data-megamenu-columns="' . esc_attr($this->tree_megamenu_root["columns"]) .'" ';
		}

		$output .= "\n$indent<ul class=\"sub-menu " . implode(' ', $classes) . "\"" . $data_columns . (!empty($styles_str) ? ' style="' . esc_attr($styles_str) .'"' : '') . ">\n";

	}

	public function end_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul>\n";
	}

	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$mega_data = $this->get_item_data($item->ID);

		if ($depth == 0){
			$this->tree_megamenu_root = $mega_data;
		}

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . esc_attr($item->ID);

		if ($depth == 0 && $mega_data['enable']) {
			$classes[] = 'megamenu-on megamenu-style-grid';
			$this->line_columns_count = 0;
		} elseif($args->walker->has_children) {
			$classes[] = 'pm-dropdown';
		}

		if ($this->line_columns_count == 0){
			$classes[] = 'megamenu-first-element';
		}

		if ($depth == 1 && $this->tree_megamenu_root['enable']){
			$this->line_columns_count++;
		}

		$column_style = '';
		if ($depth == 1 && $this->tree_megamenu_root['enable'] && $mega_data['width'] > 0) {
			$column_style = ' style="width: '. intval($mega_data['width']) .'px;" ';
		}

		if ($depth == 2 && $this->tree_megamenu_root['enable'] && !empty($mega_data['icon'])) {
			$classes[] = 'megamenu-has-icon';
		}

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. esc_attr($item->ID), $item, $args );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= '<li' . $id . $class_names . $column_style . '>';

		if (true) {

			$atts = array();
			$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
			$atts['target'] = ! empty( $item->target )	 ? $item->target	 : '';
			$atts['rel']	= ! empty( $item->xfn )		? $item->xfn		: '';
			$atts['href']   = ! empty( $item->url )		? $item->url		: '';
			$atts['class'] = '';
			if ($depth == 1 && $this->tree_megamenu_root['enable'] && $mega_data['not_link']){
				$atts['class'] .= 'mega-no-link';
			}

			if ($this->tree_megamenu_root['enable'] && !empty($mega_data['icon'])) {
				$atts['class'] .= " megamenu-has-icon";
			}

			$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

			$attributes = '';
			foreach ( $atts as $attr => $value ) {
				if ( ! empty( $value ) ) {
					$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
					$attributes .= ' ' . esc_html($attr) . '="' . esc_html($value) . '"';
				}
			}

			$item_output = $args->before;
			if ($depth == 1 && $this->tree_megamenu_root['enable']){
				$item_output .= '<span class="megamenu-column-header' . ($mega_data['not_show'] ? ' mega-not-show' : '') . '">';
			}
			$item_output .= '<a'. $attributes .'><span>';

			if (!empty($mega_data['icon'])) {
				$item_output .= '<i class="fas fa-' . preg_replace('/fa-/', '', $mega_data['icon']) . '"></i>';
			}

			/** This filter is documented in wp-includes/post-template.php */

			$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
			if (!empty($mega_data['label'])) {
				$item_output .= '<span class="swm-menu-label">'. esc_html($mega_data['label']) .'</span>';
			}
			$item_output .= '</span></a>';
			if ($depth == 1 && $this->tree_megamenu_root['enable']){
				$item_output .= '</span>';
			}
			$item_output .= $args->after;

		}

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );

	}

		public function end_el( &$output, $item, $depth = 0, $args = array() ) {

			$output .= "</li>";
		}

}