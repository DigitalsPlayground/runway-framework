<?php
/**
 * Filters to update and modify the output of content for template
 * files, theme functions and WordPress outputs.
 */

#-----------------------------------------------------------------
# Filters wp_title to create page specific title tags.
#-----------------------------------------------------------------

if ( ! function_exists( 'rf_wp_title' ) ) :
function rf_wp_title( $title, $sep ) {
	global $page, $paged;

	if ( is_feed() )
		return $title;

	// Add the blog name
	$title .= get_bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $sep $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || (!is_object($page) && $page >= 2) ) {
		$page = (is_object($page)) ? 0 : $page;
		$title .= " $sep " . sprintf( __( 'Page %s', 'framework' ), max( $paged, $page ) );
	}

	return $title;
}
endif; // rf_wp_title
add_filter( 'wp_title', 'rf_wp_title', 10, 2 );


#-----------------------------------------------------------------
# Classes for header (.hero) section
#-----------------------------------------------------------------
if ( ! function_exists( 'rf_theme_extra_header_classs' ) ) :
function rf_theme_extra_header_classs( $classes ) {

	$add_class = array();
	$header_size = '';
	$header_overlay = '';

	// Home page class
	if (is_front_page() || is_home()) {
		$header_size = get_options_data('home-page', 'home-header-size', 'large'); // header size
		$header_overlay = get_options_data('home-page', 'home-section-1-active', ''); // Overlay adjust? (example: featured destinations)
		if ( get_option('show_on_front') == 'page' && (int) get_option('page_for_posts') === get_queried_object_ID() ) {
			// doesn't apply for blog pages without featured destinations
			$header_size = 'small';
			$header_overlay = 'hide';
		}
		$add_class[] = get_options_data('home-page', 'home-header-class', ''); // custom class
	// All other pages (defaults)
	} else {
		// Deafaults
		$header_size = 'small';
	}

	$queried_object = get_queried_object();
	$object_id = get_queried_object_id();
	if(isset($queried_object->ID)) {                         // if post/page (not taxonomy)
		// Header size in meta options
		$meta_options = get_post_custom( $object_id );
		if ( $object_id && isset($meta_options['theme_custom_layout_metabox_options_header_size']) ) {
			$size_setting = $meta_options['theme_custom_layout_metabox_options_header_size'][0];

			if ( isset($size_setting) && $size_setting !== 'default' && $size_setting !== 'none' ) {
				$header_size = $size_setting;
			}
		}

		// Header color in meta options
		//$meta_options = get_post_custom( get_queried_object_id() );
		if ( $object_id && isset($meta_options['theme_custom_layout_metabox_options_header_bg']) ) {
			$bg_setting = $meta_options['theme_custom_layout_metabox_options_header_bg'][0];

			if ( isset($bg_setting) && ($bg_setting == 'color-1' || $bg_setting == 'color-2' || $bg_setting == 'color-3') ) {
				$header_color = $bg_setting;
			}
		}
	}

	// Destinations classes
	if (is_singular('destination')) {
		$header_size = 'large';
	}

	// Map's in header - show map by default
	$dest_meta = get_post_meta( get_the_ID(), 'destination_options');
	$destination_options = (empty($dest_meta[0])) ? '' : json_decode($dest_meta[0], true);
	$show_on_load = ( isset($destination_options['google_map']['show_map_on_load']) ) ? trim($destination_options['google_map']['show_map_on_load']) : 'false';
	if( get_post_type() == 'travel-directory' ) {
		$show_on_load = show_directory_items_on_page_load( get_the_ID() );
	}

	if ($show_on_load == 'true') {
		$add_class[] = 'mapOn';
	}

	// Error checking
	if (!empty($header_size)) {
		$add_class[] = $header_size.'-hero';
	}
	if (!empty($header_color)) {
		$add_class[] = $header_color;
	}
	if ($header_overlay == 'show') {
		$add_class[] = 'hero-overlap';
	}

	// Formatting
	array_filter($add_class); // Get rid of empty values
	$classes .= implode(' ', $add_class); // make into a string

	return $classes;
}
endif; // rf_theme_extra_header_classs
add_filter('rf_theme_header_class', 'rf_theme_extra_header_classs' );


#-----------------------------------------------------------------
# Filters for Header Styles
#-----------------------------------------------------------------

// Destinations - Header Background
// ................................................................
if ( ! function_exists( 'rf_destination_header_bg' ) ) :
function rf_destination_header_bg( $style = array() ) {

	// requires the Travel Destinations plugin
	if ( !function_exists('get_the_destination_ID') ) {
		return $style;
	}

	$queryID = get_queried_object_id();

	if ( $queryID && get_option('page_for_posts') != $queryID ) {

//		$id = get_the_destination_ID( $queryID );
		$id = get_the_destination_ID();

		if ( has_post_thumbnail($id) ) {
			$thumb_id = get_post_thumbnail_id( $id );
			$thumb_src = wp_get_attachment_image_src( $thumb_id, 'header' );
			if ( isset($thumb_src[0]) && !empty($thumb_src[0]) ) {
				$style['background-image'] = 'url('. $thumb_src[0] .')';
			}
		}
	}

	return $style;
}
endif;
add_filter( 'rf_get_header_style_attributes', 'rf_destination_header_bg' );

// Pages/Posts - Header Styles
// ................................................................
if ( ! function_exists( 'rf_page_header_bg' ) ) :
function rf_page_header_bg( $style = array() ) {

	// Make sure not to overriding a destination header image
	if ( function_exists('get_the_destination_ID') && get_the_destination_ID()) {
		return $style;
	}

	// get the current page/post ID
	$id = get_queried_object_id();
	$queried_object = get_queried_object();
	if(isset($queried_object->ID)) { 			//if post/page (not taxonomy)
		$meta_options = get_post_custom( $id );
		if ( isset($meta_options['theme_custom_layout_metabox_options_header_bg']) ) {
			$bg_setting = $meta_options['theme_custom_layout_metabox_options_header_bg'][0];

			if ( isset($bg_setting) && !empty($bg_setting) ) {

				// Featured image background
				if ($bg_setting == 'featured-image' && has_post_thumbnail( $id )) {
					$thumb_id = get_post_thumbnail_id( $id );
					$thumb_src = wp_get_attachment_image_src( $thumb_id, 'header' );
					if ( isset($thumb_src[0]) && !empty($thumb_src[0]) ) {
						$style['background-image'] = 'url('. $thumb_src[0] .')';
					}
				}

				// Color background
				if ($bg_setting == 'color-1' || $bg_setting == 'color-2' || $bg_setting == 'color-3') {
					$style['background-image'] = 'none';
					unset($style['background-color']); // remove property, class applied in rf_theme_extra_header_classs()
				}
			}
		}
	}

	return $style;
}
endif;
add_filter( 'rf_get_header_style_attributes', 'rf_page_header_bg' );

// Pages/Posts - Hidden Header
// ................................................................
if ( ! function_exists( 'rf_page_header_bg_hidden' ) ) :
function rf_page_header_bg_hidden( $show_header ) {

	// Header size in meta options
	$meta_options = get_post_custom( $id = get_queried_object_id() );
	if ( $id && isset($meta_options['theme_custom_layout_metabox_options_header_size']) ) {
		$size_setting = $meta_options['theme_custom_layout_metabox_options_header_size'][0];

		if ( isset($size_setting) && $size_setting == 'none' ) {
			$show_header = false;
		}
	}

	return $show_header;
}
endif;
add_filter( 'rf_has_custom_header', 'rf_page_header_bg_hidden' );

// Body class for "no header" styles
// ................................................................
if ( ! function_exists( 'rf_no_header_body_class' ) ) :
function rf_no_header_body_class( $classes ) {
	// Body class for no header style
	$show_header = rf_has_custom_header();

	if ( !$show_header ) {
		$classes[] = 'no-hero-image';
	}

	return $classes;
}
endif;
add_filter( 'body_class', 'rf_no_header_body_class' );


#-----------------------------------------------------------------
# Filters for Header Titles and Sub-titles
#-----------------------------------------------------------------

// Header title filters
// ................................................................
if ( ! function_exists( 'rf_theme_header_title_filter' ) ) :
function rf_theme_header_title_filter( $title = '' ) {
	global $shortname;

	// Pages and Posts
	if ( is_page() || is_single() ) {
		$title = ''; // no title in header, default for pages/posts
		// Meta options, title set to header
		if ( function_exists('rf_show_page_title') && rf_show_page_title('meta-value') === 'in-header' ) {
			$title = get_the_title( get_queried_object_id() ); // don't use get_the_ID(), it can change
		}
	}

	// Home Page
	if (is_front_page() || is_home()) {
		if ( get_option('show_on_front') == 'page' && (int) get_option('page_for_posts') === get_queried_object_ID() ) {
			$title = apply_filters('get_qtranslate_rw', $title);
			return $title; // don't change the "blog page" if not front page
		} else {
			$title = get_options_data('home-page', 'home-header-title');
		}
	}

	// Author
	if ( is_author() ) {
		// Get author info
		$author = get_queried_object();
		$posts_by = '<span class="author-name">'. __('Posts by', 'framework'). ' ' .$author->display_name .'</span>';
		$avatar = '<div class="author-avatar">'. get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'theme_author_bio_avatar_size', 120 ) ) .'</div>';
		// Create the title
		$title = $avatar . $posts_by;
	}

	if( is_archive('destinations') ) {
		$title = rf__($title, 'destinations');
	}

	// Travel Destination
	if ( function_exists('get_the_destination_ID') ) {
		// Original queried object
		$queryID = get_queried_object_id();
		if ($queryID) {
			$id = get_the_destination_ID( $queryID );
			// check for ID of Destination
			if ( isset($id) && !empty($id) ) {
				// Get header info
				$destination = get_hero_data( $id );
				if (isset($destination['name'])) {
					$title = $destination['name'];
				}
			}
		}
	}

	$title = apply_filters('get_qtranslate_rw', $title);

	return $title;
}
endif;
add_filter( 'theme_header_title', 'rf_theme_header_title_filter', 11 );


// Header sub-title filters
// ................................................................
if ( ! function_exists( 'rf_theme_header_subtitle_filter' ) ) :
function rf_theme_header_subtitle_filter( $content = '' ) {
	global $shortname;

	// Archive
	if (is_archive()) {
		$term_description = term_description();
		if ( ! empty( $term_description ) ) :
			$content = sprintf( '<div class="taxonomy-description">%s</div>', $term_description );
		endif;
	}

	// Page
	if ( is_page() ) {
		// In header or page content
		if ( rf_show_page_title('meta-value') === 'in-header' ) {
			// Intro Text / Sub-title
			$summary = get_post_meta( get_queried_object_ID(), 'theme_custom_sub_title_metabox_options_sub_title', true );
			if (!empty($summary))  {
				$content = $summary;
			}
		}
	}

	// Home Page
	if (is_front_page() || is_home()) {
		if ( get_option('show_on_front') == 'page' && (int) get_option('page_for_posts') === get_queried_object_ID() ) {
			$content = apply_filters('get_qtranslate_rw', $content);			
			return $content; // don't change the "blog page" if not front page
		} else {
			$content = html_entity_decode(get_options_data('home-page', 'home-header-content')); // allow HTML
		}
	}

	// Author
	if ( is_author() ) {
		// Intro Text / Sub-title
		if ( get_the_author_meta( 'description' ) ) {
			$content = get_the_author_meta( 'description' );
		}
	}
	$content = apply_filters('get_qtranslate_rw', $content);

	return $content;
}
endif;
add_filter( 'theme_header_content', 'rf_theme_header_subtitle_filter', 11 );


#-----------------------------------------------------------------
# Filters for plugin: Simple Theme Slider
#-----------------------------------------------------------------
/**
 * Plugin: Simple Theme Slider
 * Define fileds available for each slide.
 *
 * Specify the default field name, value and lable creating a new
 * array instance for each input. These inputs will appear as the
 * options for each slide created in the admin for the plugin.
 *
 * Field types: text, textarea and checkbox
 *
 * Example:
 *
 * 	$fields[{field_name}] = array(
 * 		'type'  => {field_type},
 * 		'label' => {label_text},
 * 		'value' => {default_value}
 * 	);
 */
if ( ! function_exists( 'theme_simple_slider_input_fields' ) ) :
function theme_simple_slider_input_fields( $fields = array() ) {

	// Text (Title)
	$fields['title'] = array(
		'type'  => 'text',  // the field type
		'label' => __('Title', 'framework'), // the label
		'value' => '',      // the default value
	);
	// Textarea (Description)
	$fields['description'] = array(
		'type'  => 'textarea',
		'label' => __('Description', 'framework'),
		'value' => '',
	);
	// Text (URL)
	$fields['slide-link'] = array(
		'type'  => 'text',
		'label' => __('Link URL', 'framework'),
		'value' => '',
	);
	// Checkbox (Open in new window)
	$fields['open-new-window'] = array(
		'type'  => 'checkbox',
		'label' => __('Open in New Window', 'framework'),
		'value' => 'checked',
	);

	return $fields;
}
add_filter('st_slider_fields', 'theme_simple_slider_input_fields' );
endif;


#-----------------------------------------------------------------
# Filters for plugin: Travel Destinations
#-----------------------------------------------------------------
/**
 * Rating Types for Destinations
 *
 * Create custom ratings from any Font Awesome icon:
 *
 * $rating['settings'][ {$key} ] = array(
 *   'class'            => { $font_awesome_class },
 *   'color'            => { $color_of_selected },
 *   'class-menu'       => { $font_awesome_class_in_dropdown },
 *   'class-menu-half'  => { $font_awesome_class_in_dropdown (half empty) }, // optional
 *   'class-menu-empty' => { $font_awesome_class_in_dropdown (empty) },      // optional
 *   'style'            => { $CSS_style_for_empty_style_in_dropdown }
 * );
 *
 */
if ( ! function_exists( 'set_custom_rating_settings' ) ) :
function set_custom_rating_settings( $rating ) {

	// Stars
	$rating['settings']['star'] = array(
		'class'            => 'fa fa-star',
		'color'            => '#fcbf07',
		'class-menu'       => 'fa fa-fw fa-star',        // font awesome class
		'class-menu-half'  => 'fa fa-fw fa-star-half-o',
		'class-menu-empty' => 'fa fa-fw fa-star-o',
		'style'            => 'opacity:.5',              // for "empty" style icons in sort dropdown
	);

	// Dollars
	$rating['settings']['usd']  = array(
		'class'            => 'fa fa-usd',
		'color'            => '#0faf0f',
		'class-menu'       => 'fa fa-fw fa-usd',
		'class-menu-half'  => 'fa fa-fw fa-usd',
		'class-menu-empty' => 'fa fa-fw fa-usd',
		'style'            => 'opacity:.33',     // for "empty" style icons in sort dropdown
	);

	return $rating;
}
add_filter('rating_settings', 'set_custom_rating_settings' );
endif; // set_custom_rating_settings

