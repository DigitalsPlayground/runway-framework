<?php

#-----------------------------------------------------------------
# Include Custom CSS in Theme Header
#-----------------------------------------------------------------


// Add styles to header
//-----------------------------------------------------------------
function theme_options_custom_css() {

	$custom_css = theme_custom_styles();

	if (!empty($custom_css)) {
		wp_add_inline_style( 'theme-style', $custom_css ); // $handle must match existing CSS file.
	}
}
add_action( 'wp_enqueue_scripts', 'theme_options_custom_css', 11 );


// Get custom styles from theme options
//-----------------------------------------------------------------
if ( ! function_exists( 'theme_custom_styles' ) ) :
function theme_custom_styles() {

	// Styles variable
	$CustomStyles = '';

	#-----------------------------------------------------------------
	# Styles from Theme Options
	#-----------------------------------------------------------------

	// Accent Color - Primary
	//................................................................

	$accent_index = array('1','2','3');

	// Accent Colors
	foreach( $accent_index as $index ) {
		$accent_color[$index] = get_options_data('options-page', 'color-accent-'.$index);

		if (!empty($accent_color[$index]) && $accent_color[$index] !== '#') {

			// get the color so we can modify it.
			$color = new Color($accent_color[$index]);
			// text over accent color
			$color_alt = $color->lighten(10);
			$color_text = get_as_rgba('#ffffff', 0.75);
			$color_text_alt = $color->lighten(20);
			if ($color->isLight()) {
				$color_alt = $color->darken(10);
				$color_text = get_as_rgba('#000000', 0.75);
				$color_text_alt = $color->darken(20);
			}

			// Styles (GLOBAL)
			//................................................................
			$accentStyles  = '.color-'.$index.', .hero.color-'.$index.' { background-color: #'. $color->getHex() .'; color: '.$color_text.'; }';
			$accentStyles .= '.color-'.$index.'-text { color: #'. $color->getHex() .'; }';

			// Color 1 Only
			//................................................................
			if ($index == '1') {
				// Accent Background
				//$accentStyles .= '.bg-primary, .btn-primary, input[type=\'submit\'], .btn-primary.disabled, .btn-primary[disabled], fieldset[disabled] .btn-primary, .btn-primary.disabled:hover, .btn-primary[disabled]:hover, fieldset[disabled] .btn-primary:hover, .btn-primary.disabled:focus, .btn-primary[disabled]:focus, fieldset[disabled] .btn-primary:focus, .btn-primary.disabled:active, .btn-primary[disabled]:active, fieldset[disabled] .btn-primary:active, .btn-primary.disabled.active, .btn-primary[disabled].active, fieldset[disabled] .btn-primary.active, input[type=\'submit\'].disabled, input[type=\'submit\'][disabled], fieldset[disabled] input[type=\'submit\'], input[type=\'submit\'].disabled:hover, input[type=\'submit\'][disabled]:hover, fieldset[disabled] input[type=\'submit\']:hover, input[ type=\'submit\'].disabled:focus, input[type=\'submit\'][disabled]:focus, fieldset[disabled] input[type=\'submit\']:focus, input[type=\'submit\'].disabled:active, input[type=\'submit\'][disabled]:active, fieldset[disabled] input[type=\'submit\']:active, input[type=\'submit\'].disabled.active, input[type=\'submit\'][disabled].active, fieldset[disabled] input[type=\'submit\'].active, .dropdown-menu > .active > a, .dropdown-menu > .active > a:hover, .dropdown-menu > .active > a:focus, .nav-pills > li.active > a, .nav-pills > li.active > a:hover, .nav-pills > li.active > a:focus, .label-primary, .progress-bar, .list-group-item.active, .list-group-item.active:hover, .list-group-item.active:focus, .panel-primary > .panel-heading, #loginform p.submit input[type="submit"], #login #lostpasswordform p.submit input[type="submit"], #loginform p.submit input[type="submit"].disabled, #login #lostpasswordform p.submit input[type="submit"].disabled, #loginform p.submit input[type="submit"][disabled], #login #lostpasswordform p.submit input[type="submit"][disabled],fieldset[disabled] #loginform p.submit input[type="submit"], fieldset[disabled] #login #lostpasswordform p.submit input[type="submit"], #loginform p.submit input[type="submit"].disabled:hover, #login #lostpasswordform p.submit input[type="submit"].disabled:hover, #loginform p.submit input[type="submit"][disabled]:hover, #login #lostpasswordform p.submit input[type="submit"][disabled]:hover, fieldset[disabled] #loginform p.submit input[ type="submit"]:hover, fieldset[disabled] #login #lostpasswordform p.submit input[type="submit"]:hover, #loginform p.submit input[type="submit"].disabled:focus, #login #lostpasswordform p.submit input[type="submit"].disabled:focus, #loginform p.submit input[type="submit"][disabled]:focus, #login #lostpasswordform p.submit input[type="submit"][disabled]:focus, fieldset[disabled] #loginform p.submit input[type="submit"]:focus, fieldset[disabled] #login #lostpasswordform p.submit input[type="submit"]:focus, #loginform p.submit input[type="submit"].disabled:active, #login #lostpasswordform p.submit input[type="submit"].disabled:active, #loginform p.submit input[type="submit"][disabled]:active, #login #lostpasswordform p.submit input[type="submit"][disabled]:active, fieldset[disabled] #loginform p.submit input[type="submit"]:active, fieldset[disabled] #login #lostpasswordform p.submit input[type="submit"]:active, #loginform p.submit input[type="submit"].disabled.active, #login #lostpasswordform p.submit input[type="submit"].disabled.active, #loginform p.submit input[type="submit"][disabled].active, #login #lostpasswordform p.submit input[type="submit"][disabled].active, fieldset[disabled] #loginform p.submit input[type="submit"].active, fieldset[disabled] #login #lostpasswordform p.submit input[type="submit"].active, .btn-group .dropdown-toggle.btn-primary ~ .dropdown-menu, .btn-group .dropdown-toggleinput[type=\'submit\'] ~ .dropdown-menu { background-color: #'. $color->getHex() .'; color: '.$color_text.'; }';
				$accentStyles .= '.bg-primary, .btn-primary, input[type=\'submit\'], .btn-primary.disabled, .btn-primary[disabled], fieldset[disabled] .btn-primary, .btn-primary.disabled:hover, .btn-primary[disabled]:hover, fieldset[disabled] .btn-primary:hover, .btn-primary.disabled:focus, .btn-primary[disabled]:focus, fieldset[disabled] .btn-primary:focus, .btn-primary.disabled:active, .btn-primary[disabled]:active, fieldset[disabled] .btn-primary:active, .btn-primary.disabled.active, .btn-primary[disabled].active, fieldset[disabled] .btn-primary.active, input[type=\'submit\'].disabled, input[type=\'submit\'][disabled], fieldset[disabled] input[type=\'submit\'], input[type=\'submit\'].disabled:hover, input[type=\'submit\'][disabled]:hover, fieldset[disabled] input[type=\'submit\']:hover, input[ type=\'submit\'].disabled:focus, input[type=\'submit\'][disabled]:focus, fieldset[disabled] input[type=\'submit\']:focus, input[type=\'submit\'].disabled:active, input[type=\'submit\'][disabled]:active, fieldset[disabled] input[type=\'submit\']:active, input[type=\'submit\'].disabled.active, input[type=\'submit\'][disabled].active, fieldset[disabled] input[type=\'submit\'].active, .dropdown-menu > .active > a, .dropdown-menu > .active > a:hover, .dropdown-menu > .active > a:focus, .nav-pills > li.active > a, .nav-pills > li.active > a:hover, .nav-pills > li.active > a:focus, .label-primary, .progress-bar, .list-group-item.active, .list-group-item.active:hover, .list-group-item.active:focus, .panel-primary > .panel-heading, #loginform p.submit input[type="submit"], #login #lostpasswordform p.submit input[type="submit"], #loginform p.submit input[type="submit"].disabled, #login #lostpasswordform p.submit input[type="submit"].disabled, #loginform p.submit input[type="submit"][disabled], #login #lostpasswordform p.submit input[type="submit"][disabled],fieldset[disabled] #loginform p.submit input[type="submit"], fieldset[disabled] #login #lostpasswordform p.submit input[type="submit"], #loginform p.submit input[type="submit"].disabled:hover, #login #lostpasswordform p.submit input[type="submit"].disabled:hover, #loginform p.submit input[type="submit"][disabled]:hover, #login #lostpasswordform p.submit input[type="submit"][disabled]:hover, fieldset[disabled] #loginform p.submit input[ type="submit"]:hover, fieldset[disabled] #login #lostpasswordform p.submit input[type="submit"]:hover, #loginform p.submit input[type="submit"].disabled:focus, #login #lostpasswordform p.submit input[type="submit"].disabled:focus, #loginform p.submit input[type="submit"][disabled]:focus, #login #lostpasswordform p.submit input[type="submit"][disabled]:focus, fieldset[disabled] #loginform p.submit input[type="submit"]:focus, fieldset[disabled] #login #lostpasswordform p.submit input[type="submit"]:focus, #loginform p.submit input[type="submit"].disabled:active, #login #lostpasswordform p.submit input[type="submit"].disabled:active, #loginform p.submit input[type="submit"][disabled]:active, #login #lostpasswordform p.submit input[type="submit"][disabled]:active, fieldset[disabled] #loginform p.submit input[type="submit"]:active, fieldset[disabled] #login #lostpasswordform p.submit input[type="submit"]:active, #loginform p.submit input[type="submit"].disabled.active, #login #lostpasswordform p.submit input[type="submit"].disabled.active, #loginform p.submit input[type="submit"][disabled].active, #login #lostpasswordform p.submit input[type="submit"][disabled].active, fieldset[disabled] #loginform p.submit input[type="submit"].active, fieldset[disabled] #login #lostpasswordform p.submit input[type="submit"].active, .btn-group .dropdown-toggle.btn-primary ~ .dropdown-menu, .btn-group .dropdown-toggleinput[type=\'submit\'] ~ .dropdown-menu, .accordion-card .accordion-panel .panel .panel-body:hover .read-more { background-color: #'. $color->getHex() .'; color: '.$color_text.'; }';
				// Accent Text
				$accentStyles .= '.text-primary, .btn-primary .badge, input[type=\'submit\'] .badge, .panel-primary > .panel-heading .badge, #loginform p.submit input[type="submit"] .badge, #login #lostpasswordform p.submit input[type="submit"] .badge, h1 em, .h1 em, h2 em, .h2 em, h3 em, .h3 em, h4 em, .h4 em, h5 em, .h5 em, h6 em, .h6 em, .lead em { color: #'. $color->getHex() .'; }';
				// Alternate Text (hover: lighten/darken)
				$accentStyles .= 'a.bg-primary:hover, a.text-primary:hover { color: #'. $color_text_alt.'; }';
				// Border color
				$accentStyles .= '.btn-primary, input[type=\'submit\'],
				.btn-primary.disabled, .btn-primary[disabled], fieldset[disabled] .btn-primary, .btn-primary.disabled:hover, .btn-primary[disabled]:hover, fieldset[disabled] .btn-primary:hover, .btn-primary.disabled:focus, .btn-primary[disabled]:focus, fieldset[disabled] .btn-primary:focus, .btn-primary.disabled:active, .btn-primary[disabled]:active, fieldset[disabled] .btn-primary:active, .btn-primary.disabled.active, .btn-primary[disabled].active, fieldset[disabled] .btn-primary.active, input[type=\'submit\'].disabled, input[type=\'submit\'][disabled], fieldset[disabled] input[type=\'submit\'], input[type=\'submit\'].disabled:hover, input[type=\'submit\'][disabled]:hover, fieldset[disabled] input[type=\'submit\']:hover, input[type=\'submit\'].disabled:focus, input[type=\'submit\'][disabled]:focus, fieldset[disabled] input[type=\'submit\']:focus, input[type=\'submit\'].disabled:active, input[type=\'submit\'][disabled]:active, fieldset[disabled] input[type=\'submit\']:active, input[type=\'submit\'].disabled.active, input[type=\'submit\'][disabled].active, fieldset[disabled] input[type=\'submit\'].active, .list-group-item.active, .list-group-item.active:hover, .list-group-item.active:focus, .panel-primary, .panel-primary > .panel-heading, #loginform p.submit input[type="submit"], #login #lostpasswordform p.submit input[type="submit"], #loginform p.submit input[type="submit"].disabled, #login #lostpasswordform p.submit input[type="submit"].disabled, #loginform p.submit input[type="submit"][disabled], #login #lostpasswordform p.submit input[type="submit"][disabled],fieldset[disabled] #loginform p.submit input[type="submit"], fieldset[disabled] #login #lostpasswordform p.submit input[type="submit"], #loginform p.submit input[type="submit"].disabled:hover, #login #lostpasswordform p.submit input[type="submit"].disabled:hover, #loginform p.submit input[type="submit"][disabled]:hover, #login #lostpasswordform p.submit input[type="submit"][disabled]:hover, fieldset[disabled] #loginform p.submit input[ type="submit"]:hover, fieldset[disabled] #login #lostpasswordform p.submit input[type="submit"]:hover, #loginform p.submit input[type="submit"].disabled:focus, #login #lostpasswordform p.submit input[type="submit"].disabled:focus, #loginform p.submit input[type="submit"][disabled]:focus, #login #lostpasswordform p.submit input[type="submit"][disabled]:focus, fieldset[disabled] #loginform p.submit input[type="submit"]:focus, fieldset[disabled] #login #lostpasswordform p.submit input[type="submit"]:focus, #loginform p.submit input[type="submit"].disabled:active, #login #lostpasswordform p.submit input[type="submit"].disabled:active, #loginform p.submit input[type="submit"][disabled]:active, #login #lostpasswordform p.submit input[type="submit"][disabled]:active, fieldset[disabled] #loginform p.submit input[type="submit"]:active, fieldset[disabled] #login #lostpasswordform p.submit input[type="submit"]:active, #loginform p.submit input[type="submit"].disabled.active, #login #lostpasswordform p.submit input[type="submit"].disabled.active, #loginform p.submit input[type="submit"][disabled].active, #login #lostpasswordform p.submit input[type="submit"][disabled].active, fieldset[disabled] #loginform p.submit input[type="submit"].active, fieldset[disabled] #login #lostpasswordform p.submit input[type="submit"].active, .btn-group .dropdown-toggle.btn-primary ~ .dropdown-menu, .btn-group .dropdown-toggleinput[type=\'submit\'] ~ .dropdown-menu { border-color: #'. $color->getHex() .'; }';
				$accentStyles .= '.panel-primary > .panel-heading + .panel-collapse > .panel-body { border-top-color: #'. $color->getHex() .'; }';
				$accentStyles .= '.panel-primary > .panel-footer + .panel-collapse > .panel-body { border-bottom-color: #'. $color->getHex() .'; }';
				// Alternate Background (lighten/darken)
				$accentStyles .= '.btn-primary:hover, .btn-primary:focus, .btn-primary:active, .btn-primary.active, .open > .dropdown-toggle.btn-primary, input[type=\'submit\']:hover, input[type=\'submit\']:focus, input[type=\'submit\']:active, input[type=\'submit\'].active, .open > .dropdown-toggleinput[type=\'submit\'], .label-primary[href]:hover, .label-primary[href]:focus { background-color: #'. $color_alt .'; color: '.$color_text.'; }';
			}

			// Color 2 Only
			//................................................................
			if ($index == '2') {
				// Accent Background
				$accentStyles .= '.page-box-link:hover .page-box:before, .page-box-link:active .page-box:before, .page-box-link:focus .page-box:before, .btn-success, .btn-success[type=\'button\'], .btn-success[type=\'submit\'], .btn-success.disabled, .btn-success[disabled], fieldset[disabled] .btn-success, .btn-success.disabled:hover, .btn-success[disabled]:hover, fieldset[disabled] .btn-success:hover, .btn-success.disabled:focus, .btn-success[disabled]:focus, fieldset[disabled] .btn-success:focus, .btn-success.disabled:active, .btn-success[disabled]:active, fieldset[disabled] .btn-success:active, .btn-success.disabled.active, .btn-success[disabled].active, fieldset[disabled] .btn-success.active, .label-success, .progress-bar-success { background-color: #'. $color->getHex() .'; color: '.$color_text.'; }';
				// Accent Text
				$accentStyles .= '.hero .breadcrumbs li .icon, .page-box .more-link, .text-success, .has-success .help-block, .has-success .control-label, .has-success .radio, .has-success .checkbox, .has-success .radio-inline, .has-success .checkbox-inline, .has-success .input-group-addon, .has-success .form-control-feedback, .btn-success .badge, .rating .icon.highlighted, .ninja-forms-response-msg.ninja-forms-success-msg { color: #'. $color->getHex() .'; }';
				// Alternate Text (hover: lighten/darken)
				$accentStyles .= 'a.text-success:hover { color: #'. $color_text_alt.'; }';
				// Border color
				$accentStyles .= '.form-control:focus, input[type="text"]:focus, input[type="email"]:focus, input[type="password"]:focus, textarea:focus, select:focus, form.big-search input[type="text"]:focus, .form-control:focus, .has-success .form-control, .has-success .input-group-addon, .btn-success, .btn-success.disabled, .btn-success[disabled], fieldset[disabled] .btn-success, .btn-success.disabled:hover, .btn-success[disabled]:hover, fieldset[disabled] .btn-success:hover, .btn-success.disabled:focus, .btn-success[disabled]:focus, fieldset[disabled] .btn-success:focus, .btn-success.disabled:active, .btn-success[disabled]:active, fieldset[disabled] .btn-success:active, .btn-success.disabled.active, .btn-success[disabled].active, fieldset[disabled] .btn-success.active { border-color: #'. $color->getHex() .'; }';
				$accentStyles .= '#MainMenu.navbar #navbar-main .navbar-nav > li > a:hover, #MainMenu.navbar #navbar-main .navbar-nav > li > a:active, #MainMenu.navbar #navbar-main .navbar-nav > li > a:focus, #MainMenu.navbar #navbar-main .navbar-nav > .active > a, #MainMenu.navbar #navbar-main .navbar-nav > .active > a:hover, #MainMenu.navbar #navbar-main .navbar-nav > .active > a:focus, #MainMenu.navbar #navbar-main .navbar-nav > li.open > a, #MainMenu.navbar #navbar-main .navbar-nav > li.open > a:hover, #MainMenu.navbar #navbar-main .navbar-nav > li.open > a:focus { border-top-color: #'. $color->getHex() .'; }';
				// Alternate Background (lighten/darken)
				$accentStyles .= '.btn-success:hover, .btn-success:focus, .btn-success:active, .btn-success.active, .btn-success[type=\'button\']:hover, .btn-success[type=\'button\']:focus, .btn-success[type=\'submit\']:hover, .btn-success[type=\'submit\']:focus, .open > .dropdown-toggle.btn-success { background-color: #'. $color_alt .'; color: '.$color_text.'; }';
			}

			// Color 3 Only
			//................................................................
			if ($index == '3') {
				// Accent Background
				$accentStyles .= '.btn-default, .btn-default.disabled, .btn-default[disabled], fieldset[disabled] .btn-default, .btn-default.disabled:hover, .btn-default[disabled]:hover, fieldset[disabled] .btn-default:hover, .btn-default.disabled:focus, .btn-default[disabled]:focus, fieldset[disabled] .btn-default:focus, .btn-default.disabled:active, .btn-default[disabled]:active, fieldset[disabled] .btn-default:active, .btn-default.disabled.active, .btn-default[disabled].active, fieldset[disabled] .btn-default.active, .navbar-default, .badge, body #MainMenu.navbar.scrolled, .btn-group .dropdown-toggle.btn-default ~ .dropdown-menu, .nav-tabs > li > a, .label-default, .blog-posts article .entry-meta { background-color: #'. $color->getHex() .'; color: '.$color_text.'; }';
				$accentStyles .= '@media (max-width: 1299px) { #MainMenu .collapse-md .navbar-collapse { background-color: #'. $color->getHex() .'; color: '.$color_text.'; } }';
				// Accent Text
				$accentStyles .= '.btn-default .badge { color: #'. $color->getHex() .'; }';
				// Border color
				$accentStyles .= '.btn-default, .navbar-default, .btn-group .dropdown-toggle.btn-default ~ .dropdown-menu { border-color: #'. $color->getHex() .'; }';
				// Alternate Background (lighten/darken)
				$accentStyles .= '.btn-default:hover, .btn-default:focus, .btn-default:active, .btn-default.active, .open > .dropdown-toggle.btn-default, .btn-group .dropdown-toggle.btn-default ~ .dropdown-menu > li > a:hover { background-color: #'. $color_alt .'; color: '.$color_text.'; }';
			}

			// Add styles to CSS variable
			$CustomStyles .= $accentStyles;
		}

		unset($color);
	}



	// Links
	//................................................................

	$linkColor = get_options_data('options-page', 'link-color');
	if (!empty($linkColor) && $linkColor != '#') {
		$linkStyles = "a, .widget a { color: ". $linkColor ."; }";
		// Add styles to CSS variable
		$CustomStyles .= $linkStyles;
	}
	// Hover (links)
	$hoverColor = get_options_data('options-page', 'link-hover-color');
	if (!empty($hoverColor) && $hoverColor != '#') {
		$linkHoverStyles = "a:hover, .entry-title a:hover, .widget a:hover, .guide-list-item .media-body .media-heading a:hover, .card-details .card-title a:hover, .page-box-link:hover .page-box .more-link, .page-box-link:active .page-box .more-link, .page-box-link:focus .page-box .more-link { color: ". $hoverColor ."; }";
		// Add styles to CSS variable
		$CustomStyles .= $linkHoverStyles;
	}


	// Navigation Menus
	//................................................................
	$menuStyles = '';
	$menuBackgroundDefault = get_options_data('options-page', 'color-accent-3');
	$menuBackground = get_options_data('options-page', 'menu-background');
	$menuTextColor = get_options_data('options-page', 'menu-text-color');
	$menuAccentColor = get_options_data('options-page', 'menu-accent');
	$menuSubNavColor = get_options_data('options-page', 'menu-drop-down');
	$menuSubNavText = get_options_data('options-page', 'menu-drop-down-text');
	$menuSubNavHover = get_as_rgba('#ffffff', 0.1);
	$menuOverlayBg = get_options_data('options-page', 'menu-background-overlay');
	$menuOverlayText = get_options_data('options-page', 'menu-text-color-overlay');
	$menuOverlayOpacity = get_options_data('options-page', 'menu-background-opacity');

	// Text color
	$menuTextColor = (!empty($menuTextColor) && $menuTextColor !== '#') ? $menuTextColor : '';
	// Sub-Navigation colors
	$subNavText = (!empty($menuSubNavText) && $menuSubNavText !== '#') ? $menuSubNavText : '';
	$subNavBg = (!empty($menuSubNavColor) && $menuSubNavColor !== '#') ? $menuSubNavColor : '';
	// Menu Background Color
	$menuBackgroundDefault = (!empty($menuBackgroundDefault) && $menuBackgroundDefault !== '#') ? $menuBackgroundDefault : '';
	$menuBackground = (!empty($menuBackground) && $menuBackground !== '#') ? $menuBackground : $menuBackgroundDefault; // set to default if no color

	// Overlay Navbar Background
	$style_overlayBg = '';
	$style_overlayText = '';
	$style_borderTop = '';
	$style_brand = '';
	if (!empty($menuOverlayBg) && $menuOverlayBg !== '#') {
		$menuOpacity = (isset($menuOverlayOpacity)) ? ((int) $menuOverlayOpacity * .01) : 0.25;
		$overlayBg = get_as_rgba($menuOverlayBg, $menuOpacity);
		$style_overlayBg = "background-color: ". $overlayBg ."; ";
	}
	// Overlay Navbar Text
	if (!empty($menuOverlayText) && $menuOverlayText !== '#') {
		$style_overlayText = "color: ". $menuOverlayText ."; ";
		$style_borderTop = "border-top-color: ".$menuOverlayText."; ";
	}
	if (!empty($style_overlayText) || !empty($style_overlayBg)) {
		$menuStyles .= "body:not([class*='no-hero-image']) #MainMenu.navbar { ". $style_overlayBg . $style_overlayText ." }";
		$menuStyles .= "#MainMenu .navbar-brand { ". $style_overlayText ." }";
	}
	if (!empty($style_overlayText)) {
		$menuStyles .= "body:not([class*='no-hero-image']) #MainMenu.navbar .navbar-nav > li > a, body:not([class*='no-hero-image']) #MainMenu.navbar .navbar-nav > li > a:hover, body:not([class*='no-hero-image']) #MainMenu.navbar .navbar-nav > li > a:focus, body:not([class*='no-hero-image']) #MainMenu.navbar .navbar-nav > .open > a, body:not([class*='no-hero-image']) #MainMenu.navbar .navbar-nav > .open > a:hover, body:not([class*='no-hero-image']) #MainMenu .navbar-extra-top > .navbar .navbar-search.navbar-right button { ".$style_overlayText." }";
		// sub-menu indicator arrows
		$menuStyles .= "body:not([class*='no-hero-image']) #MainMenu.navbar .dropdown-toggle:after { ". $style_borderTop ." }";
		// menu toggle
		$menuStyles .= ".navbar-default .navbar-toggle .icon-bar { background-color:". $menuOverlayText ." }";
	}
	// Accent (active/hover item)
	if (!empty($menuAccentColor) && $menuAccentColor !== '#') {
		$menuStyles .= "#MainMenu.navbar #navbar-main .navbar-nav > li > a:hover, #MainMenu.navbar #navbar-main .navbar-nav > li > a:active, #MainMenu.navbar #navbar-main .navbar-nav > li > a:focus, #MainMenu.navbar #navbar-main .navbar-nav > .active > a, #MainMenu.navbar #navbar-main .navbar-nav > .active > a:hover, #MainMenu.navbar #navbar-main .navbar-nav > .active > a:focus, #MainMenu.navbar #navbar-main .navbar-nav > li.open > a, #MainMenu.navbar #navbar-main .navbar-nav > li.open > a:hover, #MainMenu.navbar #navbar-main .navbar-nav > li.open > a:focus { border-top-color: ".$menuAccentColor. "; }";
	}

	// Default / Docked Navbar Background
	$style_menuBackground = '';
	$style_menuText = '';
	$style_borderTop = '';
	if (!empty($menuBackground) && $menuBackground !== '#') {

		// color variations...
		$navColor = new Color($menuBackground);
		// Bg
		if (empty($subNavBg)) {
			$subNavBg = ($navColor->isDark()) ? '#'.$navColor->lighten(12) : '#'.$navColor->darken(12);
		}
		// Text
		if (empty($menuTextColor)) {
			$menuText = ($navColor->isDark()) ? get_as_rgba('#ffffff', 0.9) : get_as_rgba('#000000', 0.9);
		} else {
			$menuText = $menuTextColor;
		}
		unset($navColor);

		// styles
		$style_menuBackground = "background-color: ". $menuBackground ."; ";
	}
	// Default / Docked Navbar Text
	if (!empty($menuText) && $menuText !== '#') {
		$style_menuText = "color: ".$menuText."; ";
		$style_borderTop = "border-top-color: ".$menuText."; ";
	}
	if (!empty($style_menuBackground) || !empty($style_menuText)) {
		$menuStyles .= ".navbar-default, body #MainMenu.navbar.scrolled, body.no-hero-image #MainMenu.navbar { ". $style_menuBackground . $style_menuText ." }";
		$menuStyles .= "#MainMenu.scrolled .navbar-brand, body.no-hero-image #MainMenu.navbar .navbar-brand { ". $style_menuText ." }";
		$menuStyles .= "body #MainMenu.navbar.scrolled .navbar-nav > li > a, body #MainMenu.navbar.scrolled .navbar-nav > li > a:hover, body #MainMenu.navbar.scrolled .navbar-nav > li > a:focus, body #MainMenu.navbar.scrolled .navbar-nav > .open > a, body #MainMenu.navbar.scrolled .navbar-nav > .open > a:hover, body #MainMenu.navbar.scrolled .navbar-nav > .open > a:focus, body.no-hero-image #MainMenu.navbar .navbar-nav > li > a, body.no-hero-image #MainMenu.navbar .navbar-nav > li > a:hover, body.no-hero-image #MainMenu.navbar .navbar-nav > li > a:focus, body.no-hero-image #MainMenu.navbar .navbar-nav > .open > a, body.no-hero-image #MainMenu.navbar .navbar-nav > .open > a:hover, body.no-hero-image #MainMenu.navbar .navbar-nav > .open > a:focus, #MainMenu.navbar .navbar-extra-top > .navbar .navbar-search.navbar-right button { ". $style_menuText ." }";
		// sub-menu indicator arrows
		$menuStyles .= ".navbar-default.navbar .dropdown-toggle:after, body #MainMenu.navbar.scrolled .dropdown-toggle:after, body.no-hero-image #MainMenu.navbar .dropdown-toggle:after { ". $style_borderTop ." }";
		// menu toggle
		$menuStyles .= "body #MainMenu.navbar.scrolled .navbar-toggle .icon-bar, body.no-hero-image #MainMenu.navbar .navbar-toggle .icon-bar { background-color:". $menuText ." }";
	}

	// Sub-menu background
	$style_subNavBg = '';
	$style_subNavText = '';
	$style_menuSubNavHover = '';
	$style_borderLeft = '';
	$style_borderTop = '';
	if (!empty($subNavBg)) {
		// color variations...
		$SubNavColor = new Color($subNavBg);
		if (empty($subNavText)) {
			$subNavText = ($SubNavColor->isDark()) ? get_as_rgba('#ffffff', 0.9) : get_as_rgba('#000000', 0.9);
		}
		$menuSubNavHover = '#'.$SubNavColor->darken(8); // get_as_rgba('#ffffff', 0.1);
		unset($SubNavColor);

		// styles
		$style_subNavBg = "background-color: ". $subNavBg ."; ";
		$style_menuSubNavHover = "background-color: ". $menuSubNavHover ."; ";

	}
	// Sub-menu text
	if (!empty($subNavText)) {
		$style_subNavText = "color: ".$subNavText."; ";
		$style_borderLeft = "border-left-color: ".$subNavText."; border-top-color: transparent !important; ";
		$style_borderTop  = "border-top-color: ".$subNavText." !important; ";
	}
	if (!empty($style_subNavBg) || !empty($style_subNavText) || !empty($style_menuSubNavHover)) {
		$menuStyles .= ".navbar-default .dropdown-menu { ". $style_subNavBg . $style_subNavText ." }";
		$menuStyles .= "@media (max-width: 1299px) { ".
		                   "#MainMenu .collapse-md .navbar-collapse { ". $style_subNavBg . $style_subNavText ." } ".
		                   "#MainMenu .collapse-md .navbar-collapse .navbar-nav li > a, body:not([class*='no-hero-image']) #MainMenu.navbar .collapse .navbar-nav > li > a, body:not([class*='no-hero-image']) #MainMenu.navbar .collapse .navbar-nav > li > a:hover, body:not([class*='no-hero-image']) #MainMenu.navbar .collapse .navbar-nav > li > a:focus, body:not([class*='no-hero-image']) #MainMenu.navbar .collapse .navbar-nav > .open > a, body:not([class*='no-hero-image']) #MainMenu.navbar .collapse .navbar-nav > .open > a:hover, body #MainMenu.navbar.scrolled .collapse .navbar-nav > li > a, body #MainMenu.navbar.scrolled .collapse .navbar-nav > li > a:hover, body #MainMenu.navbar.scrolled .collapse .navbar-nav > li > a:focus, body #MainMenu.navbar.scrolled .collapse .navbar-nav > .open > a, body #MainMenu.navbar.scrolled .collapse .navbar-nav > .open > a:hover, body #MainMenu.navbar.scrolled .navbar-nav > .open > a:focus, body.no-hero-image #MainMenu.navbar .collapse .navbar-nav > li > a, body.no-hero-image #MainMenu.navbar .collapse .navbar-nav > li > a:hover, body.no-hero-image #MainMenu.navbar .collapse .navbar-nav > li > a:focus, body.no-hero-image #MainMenu.navbar .navbar-nav > .open > a, body.no-hero-image #MainMenu.navbar .navbar-nav > .open > a:hover, body.no-hero-image #MainMenu.navbar .navbar-nav > .open > a:focus { ". $style_subNavText ." }".
		                   "#MainMenu.navbar-default.navbar .dropdown-toggle:after, body #MainMenu.navbar.scrolled .dropdown-toggle:after, body.no-hero-image #MainMenu.navbar .dropdown-toggle:after { ". $style_borderTop ." }".
		               "}";
		$menuStyles .= ".dropdown-menu > li > a, .navbar-default .navbar-nav .dropdown-menu > li > a { ". $style_subNavText ." }";
		$menuStyles .= ".navbar-default .dropdown-menu > li > a:hover, .navbar-default .dropdown-menu > .active > a:hover, .navbar-default .navbar-nav > .open .dropdown-menu > li > a:hover, .navbar-default .navbar-nav > .open .dropdown-menu > li > a:focus { ". $style_menuSubNavHover . $style_subNavText ." }";
		// sub-menu indicator arrow
		$menuStyles .= ".navbar .dropdown-submenu > a.dropdown-toggle:after, .navbar .dropdown-submenu > a.dropdown-toggle:hover:after { ". $style_borderLeft ." }";
	}

	// Add styles to CSS variable
	if (!empty($menuStyles)) {
		$CustomStyles .= $menuStyles;
	}


	// Fonts (body)
	//................................................................

	$font = array();
	if (get_options_data('options-page', 'font-body') == 'google') {
		// get google font data
		$gFont = get_options_data('options-page', 'font-body-google');
		$gFontWeight = explode(',', $gFont['weight']);
		$font['family'] = $gFont['family'];
		$font['weight'] = (count($gFontWeight)) ? $gFontWeight[0] : 'normal';
		$font['size']   = $gFont['size'];
		$font['color']  = $gFont['color'];
	} else {
		// get standard font data
		$font['family'] = get_options_data('options-page', 'font-body-family');
		$font['weight'] = get_options_data('options-page', 'font-body-weight');
		$font['size']   = get_options_data('options-page', 'font-body-size');
		$font['color']  = get_options_data('options-page', 'font-body-color');
	}

	$elementStyles = '';
	if ( count($font) ) {
		foreach ($font as $attribute => $style) {
			if (!empty($style)) {
				$property = ($attribute != 'color') ? 'font-'.$attribute : $attribute;
				$elementStyles .= $property.': '. $style .';';
			}
		}
	}

	if ( !empty($elementStyles)) {
		$CustomStyles .= 'body { '.$elementStyles.' }';
	}


	// Fonts (heading)
	//................................................................

	$font = array();
	if (get_options_data('options-page', 'font-heading') == 'google') {
		// get google font data
		$gFont = get_options_data('options-page', 'font-heading-google');
		$gFontWeight = explode(',', $gFont['weight']);
		$font['family'] = $gFont['family'];
		$font['weight'] = (count($gFontWeight)) ? $gFontWeight[0] : 'normal';
		// $font['size']   = $gFont['size'];
		$font['color']  = $gFont['color'];
	} else {
		// get standard font data
		$font['family'] = get_options_data('options-page', 'font-heading-family');
		$font['weight'] = get_options_data('options-page', 'font-heading-weight');
		// $font['size']   = get_options_data('options-page', 'font-heading-size');
		$font['color']  = get_options_data('options-page', 'font-heading-color');
	}

	$elementStyles = '';
	if ( count($font) ) {
		foreach ($font as $attribute => $style) {
			if (!empty($style)) {
				$property = ($attribute != 'color') ? 'font-'.$attribute : $attribute;
				$elementStyles .= $property.': '. $style .';';
			}
		}
	}

	// Apply heading colors to other text...
	if (isset($font['color']) && !empty($font['color'])) {
		$CustomStyles .= '.guide-list-item .media-body .media-heading a, .page-box .entry-title, .card-details .card-title a, .icon-meta i { color: '. $font['color'] .'; }';
	}

	if ( !empty($elementStyles)) {
		$CustomStyles .= 'h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6, .search-result .search-title, .widget-title { '.$elementStyles.' }';
	}

	// Font (heading sizes)
	//................................................................

	$size_H = array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' );
	// Headings sizes
	foreach ($size_H as $h) {
		$size = trim(get_options_data('options-page', 'font-heading-size-'.$h, 'false'));
		if ($size !== 'false' && !empty($size)) {
			if (!strpos($size,'px') && !strpos($size,'em') && !strpos($size,'rem') ) {
				$size .= 'px';
			}
			$CustomStyles .= $h .' { font-size: '.$size.' }';
		}
	}



	// Custom CSS (user generated)
	//................................................................

	$userStyles = stripslashes(htmlspecialchars_decode(get_options_data('options-page', 'custom-styles'),ENT_QUOTES));

	// Add styles to CSS variable
	$CustomStyles .= $userStyles;

	// all done!
	return $CustomStyles;

}

endif; ?>