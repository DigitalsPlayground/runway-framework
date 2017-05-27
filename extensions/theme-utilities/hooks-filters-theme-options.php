<?php
/**
 * Add dynamic values to theme options by filter to include and 
 * select from pages, categories, slide shows and other content
 * created by the user.
 */


#-----------------------------------------------------------------
# Include page list in 404 Error select for theme options
#-----------------------------------------------------------------

if (is_admin() && !function_exists('theme_option_404_content_select')) :
	function theme_option_404_content_select( $options ) {
		
		$allPages = get_pages();
		$options = array('default' => 'Default');

		if (is_array($allPages)) {
			foreach ($allPages as $page) {
				$options[$page->ID] = esc_attr($page->post_title);
			}
		}

		return $options;
	}
	// add filter: [field alias]_data_options
	add_filter( 'error-content_data_options', 'theme_option_404_content_select' );
endif;


#-----------------------------------------------------------------
# Include Destination Categories list select for theme options
#-----------------------------------------------------------------

if (is_admin() && !function_exists('theme_option_blog_categories_select')) :
	function theme_option_blog_categories_select( $options ) {

		$args = array(
			'hide_empty'    => 0,
			'hierarchical'  => 1,
			'taxonomy'      => 'category',
			// 'pad_counts' => false 
		);
		$categories = get_categories( $args );
		if ( !empty( $categories ) && !is_wp_error( $categories ) ){
			
			$items = categories_order_by_hierarchy($categories); // categories_parent_hierarchy($categories);
			$options = array('none' => ''); // default
			if (is_array($items)) {
				foreach ($items as $key => $value) {
					$level = count(get_ancestors($value->term_id, 'category'));
					$options[$value->term_id] = str_repeat('&mdash; &nbsp;', $level) . esc_html( $value->name .' ('.$value->count.')' );
				}
			}
		}

		return $options;
	}
	// add filter: [field alias]_data_options
	add_filter( 'home-section-5-source-categories_data_options', 'theme_option_blog_categories_select' );
endif;


#-----------------------------------------------------------------
# Include Static Blocks list select for theme options
#-----------------------------------------------------------------

if (is_admin() && !function_exists('theme_option_static_blocks_select')) :
	function theme_option_static_blocks_select( $options ) {

		$args = array(
			'posts_per_page' => -1,
			'post_type' => 'static_block'
		);
		$items = get_posts($args);
		$options = array('disabled' => 'Disabled');
		if (is_array($items)) {
			foreach ($items as $key => $value) {
				$options[$value->ID] = esc_html( $value->post_title );
			}
		}

		return $options;
	}
	// add filter: [field alias]_data_options
	add_filter( 'home-section-2-content-1_data_options', 'theme_option_static_blocks_select' );
	add_filter( 'home-section-2-content-2_data_options', 'theme_option_static_blocks_select' );
	add_filter( 'footer-content-1_data_options', 'theme_option_static_blocks_select' );
	add_filter( 'footer-content-2_data_options', 'theme_option_static_blocks_select' );
	add_filter( 'sub-footer-content_data_options', 'theme_option_static_blocks_select' );
endif;


#-----------------------------------------------------------------
# Include destination list select for theme options
#-----------------------------------------------------------------

if (is_admin() && !function_exists('theme_option_destinations_select')) :
	function theme_option_destinations_select( $options ) {

		$items = get_pages( array('post_type' => 'destination') );
		$items_hierarchy = get_page_hierarchy($items);
		$options = array('all' => __('* All Destinations', 'framework')); // array('default' => 'Default');
		if (is_array($items_hierarchy)) {
			foreach ($items_hierarchy as $id => $slug) {
				$level = count(get_post_ancestors($id));
				$options[$id] = str_repeat('&mdash; &nbsp;', $level) . get_the_title($id);
			}
		}

		return $options;
	}
	// add filter: [field alias]_data_options
	add_filter( 'destinations_data_options', 'theme_option_destinations_select' );
	add_filter( 'home-section-1-source-destinations_data_options', 'theme_option_destinations_select' );
endif;



#-----------------------------------------------------------------
# Include Destination Categories list select for theme options
#-----------------------------------------------------------------

if (is_admin() && !function_exists('theme_option_destination_categories_select')) :
	function theme_option_destination_categories_select( $options ) {

		$args = array(
			'hide_empty'    => 0,
			'hierarchical'  => 1,
			'taxonomy'      => 'travel-category',
			// 'pad_counts' => false 
		);
		$categories = get_categories( $args );
		if ( !empty( $categories ) && !is_wp_error( $categories ) && !isset($categories['errors']) ){

			$items = categories_order_by_hierarchy($categories); // categories_parent_hierarchy($categories);
			$options = array('disabled' => __('Disabled', 'framework')); // default
			if (is_array($items)) {
				foreach ($items as $key => $value) {
					$level = count(get_ancestors($value->term_id, 'travel-category'));
					$options[$value->term_id] = str_repeat('&mdash; &nbsp;', $level) . esc_html( $value->name .' ('.$value->count.')' );
				}
			}
		}

		return $options;
	}
	// add filter: [field alias]_data_options
	add_filter( 'home-accordion-1-category_data_options', 'theme_option_destination_categories_select' );
	add_filter( 'home-accordion-2-category_data_options', 'theme_option_destination_categories_select' );
	add_filter( 'home-accordion-3-category_data_options', 'theme_option_destination_categories_select' );
	add_filter( 'home-section-4-destination-category_data_options', 'theme_option_destination_categories_select' );
endif;


#-----------------------------------------------------------------
# Include Simple Theme Slider list select for theme options
#-----------------------------------------------------------------

if (is_admin() && !function_exists('theme_option_st_slider_select')) :
	function theme_option_st_slider_select( $options ) {

		if (function_exists('sts_get_all_sliders')) : 

			$the_query = sts_get_all_sliders();
			if ( $the_query->have_posts() ) {
				$options = array();
				while ( $the_query->have_posts() ) : $the_query->the_post(); 
				
					$id    = esc_attr(get_the_ID());
					$title = esc_attr(get_the_title());
					// Select options
					$options[$id] = $title;
				endwhile;
							
				/* Restore original Post Data */
				wp_reset_postdata();

			} else {
				$options = array('none' => __('No Sliders Created', 'framework'));
			}
		
		else:
			$options = array('none' => __('Plugin not installed', 'framework'));
		endif; // function_exists('sts_get_all_sliders')

		return $options;
	}
	// add filter: [field alias]_data_options
	add_filter( 'home-section-4-simple-slideshow-source_data_options', 'theme_option_st_slider_select' );
endif;


#-----------------------------------------------------------------
# Include Revolution Slider list select for theme options
#-----------------------------------------------------------------

if (is_admin() && !function_exists('theme_option_rev_slider_select')) :
	function theme_option_rev_slider_select( $options ) {

		if (class_exists('RevSlider')) : 
			$ss = new RevSlider();
			$arrSliders = $ss->getArrSliders();
			$options = array();
			if (count($arrSliders)) {
				foreach($arrSliders as $ss):
					// Slide data
					$id    = $ss->getID();
					$title = $ss->getTitle();
					$alias = $ss->getAlias();
					// Select options
					$options[$alias] = $title;
				endforeach;
			} else {
				$options = array('none' => __('No Sliders Created', 'framework'));
			}
		else:
			$options = array('none' => __('Plugin not installed', 'framework'));
		endif; // class_exists('RevSlider')

		return $options;
	}
	// add filter: [field alias]_data_options
	add_filter( 'home-section-4-rev-slider-source_data_options', 'theme_option_rev_slider_select' );
endif;


#-----------------------------------------------------------------
# Include list of WP menus in theme options
#-----------------------------------------------------------------

if (is_admin() && !function_exists('theme_option_wp_menu_select')) :
	function theme_option_wp_menu_select( $options ) {

		$wp_menus = get_terms( 'nav_menu', array( 'hide_empty' => true ) );
		$options = array('' => '');

		if (is_array($wp_menus)) {
			foreach ($wp_menus as $menu) {
				$options[$menu->slug] = esc_attr($menu->name);
			}
		}

		return $options;
	}
	// add filter: [field alias]_data_options
	add_filter( 'wp-menus_data_options', 'theme_option_wp_menu_select' );
endif;

// Creates multi-dimensional array of categories with hierarchy
if (is_admin() && !function_exists('categories_parent_hierarchy')) :
function categories_parent_hierarchy( $items, $parent = 0 ) {
	$op = array();
	foreach( $items as $item ) {
		if( $item->category_parent == $parent ) {
			$op[$item->term_id]['post'] = $item;
			// using recursion
			$children = categories_parent_hierarchy( $items, $item->term_id );
			if( $children ) {
				$op[$item->term_id]['children'] = $children; // Use this for multidimensional (nested) categories
			}
		}
	}
	return $op;
}
endif;

// Creates one dimensional array ordered by category hierarchy
if (is_admin() && !function_exists('categories_order_by_hierarchy')) :
function categories_order_by_hierarchy( $items, $parent = 0 ) {
	$op = array();
	foreach( $items as $item ) {
		if( $item->category_parent == $parent ) {
			$op[$item->term_id] = $item;
			// using recursion
			$children = categories_order_by_hierarchy( $items, $item->term_id );
			if( $children ) {
				$op = array_merge($op, $children); // Use this for multidimensional (nested) categories
			}
		}
	}
	return $op;
}
endif;
