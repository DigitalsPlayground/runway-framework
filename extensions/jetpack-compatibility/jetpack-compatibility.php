<?php
/*
    Extension Name: Jetpack Compatibility Functions
    Version: 1.0
    Description: Add specific Jetpack compatibility features to the theme.

    Notes: For details see: http://jetpack.me/
*/


/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function rf_jetpack_setup() {
	if ( function_exists( 'add_theme_support' ) ) {
		add_theme_support( 'infinite-scroll', array(
			'container' => 'content',
			'footer'    => 'page',
		) );
	}
}
add_action( 'after_setup_theme', 'rf_jetpack_setup' );