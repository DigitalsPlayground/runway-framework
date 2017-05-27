<?php
/**
 * Actions to apply and output theme behavior and content on the
 * template files and other WP specific areas. 
 */


#-----------------------------------------------------------------
# Outputs the default template layout container wrapper
#-----------------------------------------------------------------
/**
 * This helps the theme decide if it needs to include a content container for specific pages, templates and content sources.
 * The container acts as a content wrapper for any templates without built in content containers.
 *
 * For templates not needing wrapper elements, before the get_header() function, include the following filter:
 *
 * add_filter('theme_template_has_layout', function(){ return true; });
 */
if ( ! function_exists( 'rf_default_template_wrapper' ) ) :
function rf_default_template_wrapper( $position = 'start' ) {

	// Templates not needing wrappers don't continue
	if (apply_filters('theme_template_has_layout', false)) {
		return;
	}

	$container = apply_filters('theme_template_wrapper_type', 'section'); // the container type
	$class = apply_filters('theme_template_wrapper_class', 'main container'); // class attribute for container
	
	// The opening container
	if ($position == 'start') {
		echo '<'.$container.' class="'.$class.'">';
	}
	// The closing container
	if ($position == 'end') {
		echo '</'.$container.'> <!-- /'.$class.' -->';
	}
}
endif; // rf_default_template_wrapper
add_action('output_layout', 'rf_default_template_wrapper', 1 );


#-----------------------------------------------------------------
# Breadcrumbs in Destinations header
#-----------------------------------------------------------------

if ( ! function_exists( 'rf_destination_header_breadcrumbs' ) ) :
function rf_destination_header_breadcrumbs() {
	global $post;

	// requires the Travel Destinations plugin
	if ( !function_exists('get_the_destination_ID') ) {
		return;
	}

	$queryID = get_queried_object_id();

	if ($queryID) {
		$id = get_the_destination_ID( $queryID );
		$crumbs = '';

		if ( isset($id) && !empty($id) ) {

			// get destination data
			$destination = get_hero_data( $id );

			// Add the breadcrumbs
			$breadcrumbs = (isset($destination['breadcrumb'])) ? $destination['breadcrumb'] : '';

			// breadcrumb trail
			if (!empty($breadcrumbs)) {
				foreach ($breadcrumbs as $crumb) {
					if (isset($crumb['title']) && isset($crumb['link'])) {
						$crumbs .= '<li><a href="'.esc_url($crumb['link']).'">'.esc_html($crumb['title']).'</a></li>';
					}
				}
			}
			// current destination
			if (empty($breadcrumbs) || !is_singular('destination')) { // is_singular(array( 'destination', 'guide-lists' ))
				$crumbs .= '<li><a href="'. get_permalink($id) .'">'. destination_get_the_title() .'</a></li>';
			}

			if (!empty($crumbs)) {
				?>
				<ul class="breadcrumbs">
					<li class="no-arrow"><i class="icon fa fa-map-marker"></i></li>
					<?php 
					// breadcrumb trail
					echo  $crumbs;
					?>
				</ul>
				<?php
			}
		}
	}
}
endif; 
add_action('after_header_intro_text', 'rf_destination_header_breadcrumbs');

