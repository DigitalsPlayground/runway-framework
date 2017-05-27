<?php
/*
    Extension Name: Custom Header
    Version: 1.0
    Description: Custom theme header content.
*/



/**
 * Default template parts folder for design templates
 * 
 * You can modify this path with a filter.
 * Example: 
 * 
 *     function set_custom_template_folder() {
 *         return 'my/folder/path/';
 *     }
 *     add_filter('rf_header_template', 'set_custom_template_folder' );
 */
function rf_header_template_base( $options = array() ) {
	
	return apply_filters('rf_header_template', 'templates/parts/hero');

}

#-----------------------------------------------------------------
# Headers
#-----------------------------------------------------------------

/**
 * Header for "Cover" templates
 */
if ( ! function_exists( 'rf_cover_theme_header' ) ) :
function rf_cover_theme_header() {

	// Load the cover template
	get_template_part( rf_header_template_base(), 'cover' );

}
endif;


/**
 * Classes applied to the header
 */
if ( ! function_exists( 'rf_default_header_class' ) ) :
function rf_default_header_class( $extra_classes = '') {

	$header_content_class = $extra_classes;
	return apply_filters('rf_theme_header_class', $header_content_class );

}
endif;


/**
 * Styles applied to the header
 */
if ( ! function_exists( 'rf_header_styles' ) ) :
function rf_header_styles( $extra_styles = '') {

	$inline_styles = '';
	$styles = rf_get_header_style_attributes();

	if ( is_array($styles) && !empty($styles) ) {
		foreach ($styles as $attr => $style) {
			$inline_styles .= $attr .':'. $style .';';
		}
	}

	// Assemble all the styles
	$inline_styles .= $extra_styles;
	
	echo 'style="'.apply_filters('rf_theme_header_styles', $inline_styles).'"';
}
endif;


// Get the header styles
if ( ! function_exists( 'rf_get_header_style_attributes' ) ) :
function rf_get_header_style_attributes() {

	$styles = array();
	
	// All other pages
	$background_color  = get_options_data('options-page', 'header-color-default', '');
	$background_image  = get_options_data('options-page', 'header-bg-default', '');

	// some defaults
	if (is_front_page() || is_home()) {
		// Home Page, but not a 'page_for_posts'
		if ( get_option('show_on_front') == 'page' && (int) get_option('page_for_posts') === get_queried_object_ID() ) {
			// Do nothing. This is the blog page.
		} else {
			// It's the real home, set the values.
			$background_color = get_options_data('home-page', 'home-header-background-color', '');
			$background_image = get_options_data('home-page', 'home-header-background-image', '');
		}
	} 

	// error checking
	if ( !empty($background_color) && $background_color !== '#' ) {
		$styles['background-color'] = $background_color;
	}
	if ( !empty($background_image) ) {
		$styles['background-image'] = 'url('.$background_image.')';
	}
	
	return apply_filters('rf_get_header_style_attributes', $styles);
}
endif;

// Header inner container
if ( ! function_exists( 'rf_header_container_styles' ) ) :
function rf_header_container_styles( $extra_styles = '') {

	$header_inline_styles = '';
	$background_height = '';
	
	if (is_front_page() || is_home()) {
		// Home Page
	} else {
		// All other pages
		$background_height = get_options_data('options-page', 'header-height-default', '');
	}

	// error checking
	if ( !empty($background_height) ) {
		// % or px
		if ( strpos($background_height, '%') !== false ) {
			$header_inline_styles .= 'padding-top: '. (int) $background_height .'%;';
			$header_inline_styles .= 'max-height: none; height: auto;';
		} else {
			// assume any other value is px
			$header_inline_styles .= 'max-height: none; height: '. (int) $background_height .'px;';
			$header_inline_styles .= 'padding-top: 0;';
		}
	}

	// Assemble all the styles
	$header_inline_styles .= $extra_styles;
	
	echo 'style="'.apply_filters('rf_header_container_styles', $header_inline_styles ).'"';

}
endif;


#-----------------------------------------------------------------
# Title Functions
#-----------------------------------------------------------------

/**
 * Page Title in Header. Similar to titles generaged by wp_title() 
 * for use in headers and other areas outside the loop.
 */
if ( ! function_exists( 'rf_generate_the_title' ) ) :
function rf_generate_the_title( $title = '' ) {
	global $wpdb, $wp_locale;

	$m        = get_query_var('m');
	$year     = get_query_var('year');
	$monthnum = get_query_var('monthnum');
	$day      = get_query_var('day');
	$search   = get_search_query();
	$t_sep    = ' ';

	// If there is a post
	if ( is_single() || ( is_home() && !is_front_page() ) || ( is_page() && !is_front_page() ) ) {
		$title = single_post_title( '', false );
	}
	// If there's a category or tag
	if ( is_category() || is_tag() ) {
		$title = single_term_title( '', false );
	}
	// If there's a taxonomy
	if ( is_tax() ) {
		// $term = get_queried_object();
		// $tax = get_taxonomy( $term->taxonomy );
		// $title = single_term_title( $tax->labels->name . $t_sep, false );
		$title = single_term_title( '', false );
	}
	// If there's an author
	if ( is_author() ) {
		$author = get_queried_object();
		$title = __('Posts by', 'framework'). ' ' .$author->display_name;
	}
	// If there's a post type archive
	if ( is_post_type_archive() )
		$title = post_type_archive_title( '', false );
	// If there's a month
	if ( is_archive() && !empty($m) ) {
		$my_year = substr($m, 0, 4);
		$my_month = $wp_locale->get_month(substr($m, 4, 2));
		$my_day = intval(substr($m, 6, 2));
		$title = ( $my_month ? $my_month .  $t_sep : '' ) . ( $my_day ? $my_day . $t_sep : '' ) . $my_year;
	}
	// If there's a year
	if ( is_archive() && !empty($year) ) {
		$title = '';
		if ( !empty($monthnum) )
			$title .= $wp_locale->get_month($monthnum) . $t_sep;
		if ( !empty($day) )
			$title .= zeroise($day, 2) . $t_sep;
		$title .= $year;
	}
	// If it's a search
	if ( is_search() ) {
		/* translators: 1: separator, 2: search phrase */
		$title = sprintf(__('Search Results for: %s', 'framework'), '<em>'.strip_tags($search).'</em>');
	}
	// If it's a 404 page
	if ( is_404() ) {
		$title = __('Page not found', 'framework');
	}

	return apply_filters('rf_generate_the_title', $title);

}
endif; 
add_filter( 'theme_header_title', 'rf_generate_the_title' );


/**
 * Page Sub-Title/Content in Header
 */
if ( ! function_exists( 'rf_generate_the_subtitle' ) ) :
function rf_generate_the_subtitle( $subtitle = '' ) {
	global $wpdb, $wp_locale;

	$t_sep    = ' ';

	// If there is a post
	if (is_page() && has_excerpt()) {
		$subtitle = get_the_excerpt();
	} elseif ( is_single() || ( is_home() && !is_front_page() ) ) {
		$subtitle = ( !function_exists( 'rf_posted_on' ) ) ? '' : rf_posted_on( false ); // use false to return, not echo
	}

	return apply_filters('rf_generate_the_subtitle', $subtitle);

}
endif;

add_filter( 'theme_header_subtitle', 'rf_generate_the_subtitle' );



#-----------------------------------------------------------------
# Header Helpers
#-----------------------------------------------------------------

/**
 * Custom class on HTML element for "Cover" templates
 */
if ( ! function_exists( 'rf_html_cover_class' ) ) :
function rf_html_cover_class() {

	if (is_page_template( 'templates/cover.php' ) || is_page_template( 'templates/cover-with-page.php' )) { 

		echo 'class="cover"'; 

	}

}
endif;


/**
 * Show the header for the specific area.
 */
if ( ! function_exists( 'rf_theme_header' ) ) :
function rf_theme_header() {

	if (is_page_template( 'templates/cover.php' ) || is_page_template( 'templates/cover-with-page.php' )) {

		rf_cover_theme_header();

	} else {

		if (rf_has_custom_header()) {
			// Load the default header template
			get_template_part( rf_header_template_base(), 'default' );
		}
	}
}
endif;


/**
 * Checks if custom headers are enabled for current page from theme options
 * 
 * @return bool Returns true if custom headers are enabled.
 */
if ( ! function_exists( 'rf_has_custom_header' ) ) :
function rf_has_custom_header() {
	
	// Use Page Headers
	$show_the_header = false;
	$show_headers = get_options_data('options-page', 'use-page-headers');
	if (isset($show_headers) && is_array($show_headers)) {

		foreach ($show_headers as $section) {
			// Create conditions
			$user_func = 'is_'.$section; // default functions: is_home, is_single, is_page...
			$user_param = ''; // parmeter to pass: is_page(123)...
			if ( strpos($section,':') !== false ) {
				$condition = explode(':', $section);
				$user_func = (isset($condition[0])) ? $condition[0] : '';;
				$user_param = (isset($condition[1])) ? $condition[1] : '';
			}
			// Test
			if ( function_exists($user_func) ) {
				if ( call_user_func($user_func, $user_param) )
					$show_the_header = true;

				continue;
			}
		}

		// include post archive & categories as part of blog setting
		if ( in_array('home', $show_headers) && (is_archive() || is_category()) ) {
			$show_the_header = true;
		}

		// Check destinations 
		if ( get_post_type() == 'destination' ) {
			$show_the_header = (in_array('destination', $show_headers)) ? true : false;
		}
		if ( get_post_type() == 'destination-page' ) {
			$show_the_header = (in_array('destination-page', $show_headers)) ? true : false;
		}
		if ( get_post_type() == 'travel-directory' ) {
			$show_the_header = (in_array('travel-directory', $show_headers)) ? true : false;
		}

		// extra check for static home page.
		if (is_front_page() && !in_array('front_page', $show_headers)) {
			$show_the_header = false;
		}
	}

	return apply_filters('rf_has_custom_header', $show_the_header);
}
endif;


#-----------------------------------------------------------------
# Filters and Actions
#-----------------------------------------------------------------

// Filter Home Header for Auto Paragraphs
if ( ! function_exists( 'wpautop_home_header' ) ) :
function wpautop_home_header( $content ) {
	
	$home_autop = get_options_data('home-page', 'home-header-autop');
	if ( !is_front_page() || $home_autop == 'true') {
		$content = wpautop($content);
	}
	return $content;
}
endif;
remove_filter( 'get_options_data_type_text-editor', 'wpautop', 10 ); // remove for all Runway text editors
add_filter( 'get_options_data_type_text-editor', 'wpautop_home_header', 10 ); // add custom version


// Add custom CSS from header options.
function home_header_custom_styles() {
	$custom_css = get_options_data('home-page', 'home-header-custom-css', '');
	if (!empty($custom_css) && is_front_page()) {
		wp_add_inline_style( 'theme-style', $custom_css ); // $handle must match existing CSS file. 
	}
}
add_action( 'wp_enqueue_scripts', 'home_header_custom_styles', 11 );


// Add support for excerpts in pages.
function rf_add_page_excerpts() {
	add_post_type_support( 'page', 'excerpt' );
}
add_action('init', 'rf_add_page_excerpts');
