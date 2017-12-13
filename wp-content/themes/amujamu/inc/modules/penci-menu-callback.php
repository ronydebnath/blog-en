<?php
/**
 * Class penci_nav_menu_edit_walker
 * Callback of penci_nav_menu_edit_walker function in penci-walker.php
 * Use to filter to wp_edit_nav_menu_walker
 *
 * @since 1.0
 */
class penci_nav_menu_edit_walker extends Walker_Nav_Menu_Edit {
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$menu_return  = '';
		$menu_control = '';
		$style = "font-family: 'Open Sans', sans-serif;";

		// Menu setting
		$penci_cat_mega_menu = get_post_meta( $item->ID, 'penci_cat_mega_menu', true );
		$penci_number_mega_menu = get_post_meta( $item->ID, 'penci_number_mega_menu', true );

		// Add option choose mega menu
		$td_category_tree = array_merge( array( '- Not Mega Menu -' => '' ), penci_list_categories() );

		$menu_control .= '<p class="description description-wide">';
		$menu_control .= '<label>';
		$menu_control .= 'Make it is a category mega menu (make sure category you selected has posts & menu item you selected need is top level and this menu item no have child menu items)';
		$menu_control .= '</label>';

		$menu_control .= '<select style="'. $style .'" name="penci_cat_mega_menu[' . $item->ID . ']" id="" class="widefat code edit-menu-item-url">';
		foreach ( $td_category_tree as $category => $category_id ) {
			$menu_control .= '<option value="' . $category_id . '"' . selected( $penci_cat_mega_menu, $category_id, false ) . '>' . $category . '</option>';
		}
		$menu_control .= ' </select>';
		$menu_control .= '</p>';

		$menu_control .= '<p class="description description-wide">';
		$menu_control .= '<label>';
		$menu_control .= 'Select rows when display posts in this category mega menu';
		$menu_control .= '</label>';

		$menu_control .= '<select style="'. $style .'" name="penci_number_mega_menu[' . $item->ID . ']" id="" class="widefat code edit-menu-item-url">';
		$menu_control .= '<option value="1"' . selected( $penci_number_mega_menu, '1', false ) . '>1 row</option>';
		$menu_control .= '<option value="2"' . selected( $penci_number_mega_menu, '2', false ) . '>2 rows</option>';
		$menu_control .= '<option value="3"' . selected( $penci_number_mega_menu, '3', false ) . '>3 rows</option>';
		$menu_control .= ' </select>';
		$menu_control .= '</p>';

		parent::start_el( $menu_return, $item, $depth, $args, $id );

		$menu_return = preg_replace( '/(?=<div.*submitbox)/', $menu_control, $menu_return );

		$output .= $menu_return;
	}
}