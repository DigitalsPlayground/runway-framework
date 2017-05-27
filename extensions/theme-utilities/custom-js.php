<?php

#-----------------------------------------------------------------
# Include Custom JavaScript in Theme Footer
#-----------------------------------------------------------------


// Add scripts to footer
//-----------------------------------------------------------------
function theme_footer_custom_js() {
	// Custom Scripts from Theme Options
	echo '<script type="text/javascript">';
	theme_footer_custom_scripts();
	echo '</script> ';
}
// Add hook for WP footer
add_action('wp_footer', 'theme_footer_custom_js', 101); // low priority to get it near the end


// Get custom JavaScript from theme options
//-----------------------------------------------------------------
if ( ! function_exists( 'theme_footer_custom_scripts' ) ) :
function theme_footer_custom_scripts() {

	// Custom JavaScript
	$customJS = htmlspecialchars_decode(get_options_data('options-page', 'custom-script'),ENT_QUOTES);
        $customJS = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "$1", $customJS);
	if (!empty($customJS)) {
		// prepare JS for output
		$customJS = str_replace(array('\r\n','\r','\n'), PHP_EOL, $customJS); // remove line breaks
		$customJS = stripslashes($customJS); // strip slashes
		echo  $customJS; // escaped above
	}

	// Fallbacks for CDN. This ensures a local copy is loaded if a script from a CDN fails.
	echo 'if (typeof jQuery.fn.fitVids === "undefined") { document.write("<script src=\''. rf_get_template_directory_uri().'/assets/js/jquery.fitvids.min.js\'>\x3C/script>"); }'; // FitVids
}
endif;



#-----------------------------------------------------------------
# Include Custom JavaScript in Theme Header
#-----------------------------------------------------------------


// Add scripts to header
//-----------------------------------------------------------------
function theme_header_custom_js() {
	// Custom Scripts from Theme Options
	echo '<script type="text/javascript">';
	theme_header_custom_scripts();
	echo '</script> ';
}
// Add hook for WP header
add_action('wp_header', 'theme_header_custom_js', 101); // low priority to get it near the end


// Get custom JavaScript from theme options
//-----------------------------------------------------------------
if ( ! function_exists( 'theme_header_custom_scripts' ) ) :
function theme_header_custom_scripts() {

	/**
	 * POSSIBLE FUTURE USE (theme option does not exist currently)
	 **********************************************************************
		// Custom JavaScript
		$customJS = htmlspecialchars_decode(get_options_data('options-page', 'custom-script-header'),ENT_QUOTES);
	        $customJS = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "$1", $customJS);
		if (!empty($customJS)) {
			echo stripslashes(esc_js($customJS));
		}
	 *
	 **********************************************************************
	*/

	// Fallbacks for CDN. This ensures a local copy is loaded if a script from a CDN fails.
	// echo 'if (typeof jQuery.fn.fitVids === "undefined") { document.write("<script src=\'js/libs/jquery.tooltip.min.js\'>\x3C/script>"); }'; // FitVids
}
endif;

