<?php

# ==================================================
# Setup and install demo content
# ==================================================

if ( ! function_exists( 'theme_demo_data' ) ) :
function theme_demo_data() {
	global $shortname;


	# --------------------------------------------------
	# Theme Options
	# --------------------------------------------------

	// Row => Data  (doesn't include $shortname prefix)
	$demo_data = array(

		/*
		'some_settings' => 
			'encoded options data'
				
		'some_settings' => 
			'encoded options data'
		*/
	);

	// Loop through data and add to DB as needed
	// --------------------------------------------------
	foreach ($demo_data as $option_key => $option_data) {
		
		// Generate the 'option_name' for the row
		$option_name = $shortname . $option_key;

		// Update database if row doesn't exist
		if( !get_option( $option_name ) ) {
			update_option( $option_name, maybe_unserialize(runway_base_decode($option_data, true)) );
		}
	}



	# --------------------------------------------------
	# Extensions/Plugin Options
	# --------------------------------------------------
	
	// Row => Data  (doesn't include $shortname prefix)
	$options_data = array(

		/*
		'option' => 
			'value serialized',

		'option' => 
			'value serialized',
		*/
	);


	// Loop through data and add to DB as needed
	// --------------------------------------------------
	foreach ($options_data as $option_key => $option_data) {
		
		// Generate the 'option_name' for the row
		$option_name = $option_key;

		// Update database if row doesn't exist
		if( !get_option( $option_name ) ) {
			update_option( $option_name, maybe_unserialize( $option_data, true ) );
		}
	}



	# --------------------------------------------------
	# Ninja Forms data
	# --------------------------------------------------
	
	/**
	 * Use the built in export feature of NinjaForms to get the data. Open the resulting 
	 * file in a text editor and copy entire file content. Add the form export data as a 
	 * new value in the array.
	 *
	 * @form_alias    string    A nickname for this form.
	 * @export_data   string    The content of the export
	 */

	// $form_alias => $export_data
	$forms_data = array(

		// form alias
		'default-theme-form' => 
			// form export data
			'a:4:{s:4:"data";a:22:{s:12:"date_updated";s:19:"2015-05-07 06:18:21";s:10:"form_title";s:25:"GoExplore! - Contact Form";s:10:"show_title";s:1:"0";s:9:"save_subs";s:1:"1";s:9:"logged_in";s:1:"0";s:11:"append_page";s:0:"";s:4:"ajax";s:1:"1";s:14:"clear_complete";s:1:"1";s:13:"hide_complete";s:1:"1";s:11:"success_msg";s:42:"Your form has been successfully submitted.";s:10:"email_from";s:0:"";s:10:"email_type";s:4:"html";s:14:"user_email_msg";s:69:"Thank you so much for contacting us. We will get back to you shortly.";s:17:"user_email_fields";s:1:"0";s:15:"admin_email_msg";s:0:"";s:18:"admin_email_fields";s:1:"1";s:16:"admin_attach_csv";s:1:"0";s:15:"email_from_name";s:0:"";s:17:"not_logged_in_msg";s:0:"";s:16:"sub_limit_number";s:0:"";s:13:"sub_limit_msg";s:0:"";s:6:"status";s:0:"";}s:2:"id";N;s:5:"field";a:5:{i:0;a:7:{s:2:"id";s:1:"6";s:7:"form_id";s:1:"6";s:4:"type";s:5:"_text";s:5:"order";s:1:"0";s:4:"data";a:24:{s:5:"label";s:4:"Name";s:9:"label_pos";s:5:"above";s:13:"default_value";s:0:"";s:4:"mask";s:0:"";s:10:"datepicker";s:1:"0";s:5:"email";s:1:"0";s:10:"first_name";s:0:"";s:9:"last_name";s:0:"";s:9:"from_name";s:1:"0";s:14:"user_address_1";s:0:"";s:14:"user_address_2";s:0:"";s:9:"user_city";s:0:"";s:8:"user_zip";s:0:"";s:10:"user_phone";s:0:"";s:10:"user_email";s:0:"";s:21:"user_info_field_group";s:0:"";s:3:"req";s:1:"1";s:5:"class";s:0:"";s:9:"show_help";s:1:"0";s:9:"help_text";s:0:"";s:9:"show_desc";s:1:"0";s:8:"desc_pos";s:4:"none";s:9:"desc_text";s:0:"";s:17:"calc_auto_include";s:1:"0";}s:6:"fav_id";s:1:"0";s:6:"def_id";s:1:"0";}i:1;a:7:{s:2:"id";s:1:"7";s:7:"form_id";s:1:"6";s:4:"type";s:5:"_text";s:5:"order";s:1:"1";s:4:"data";a:28:{s:5:"label";s:5:"Email";s:9:"label_pos";s:5:"above";s:13:"default_value";s:0:"";s:4:"mask";s:0:"";s:10:"datepicker";s:1:"0";s:5:"email";s:1:"1";s:10:"first_name";s:1:"0";s:9:"last_name";s:1:"0";s:9:"from_name";s:1:"0";s:14:"user_address_1";s:1:"0";s:14:"user_address_2";s:1:"0";s:9:"user_city";s:1:"0";s:8:"user_zip";s:1:"0";s:10:"user_phone";s:1:"0";s:10:"user_email";s:1:"1";s:21:"user_info_field_group";s:1:"1";s:3:"req";s:1:"1";s:5:"class";s:0:"";s:9:"show_help";s:1:"0";s:9:"help_text";s:0:"";s:17:"calc_auto_include";s:1:"0";s:11:"calc_option";s:1:"0";s:11:"conditional";s:0:"";s:26:"user_info_field_group_name";s:0:"";s:28:"user_info_field_group_custom";s:0:"";s:9:"show_desc";s:1:"0";s:8:"desc_pos";s:4:"none";s:9:"desc_text";s:0:"";}s:6:"fav_id";s:1:"0";s:6:"def_id";s:2:"14";}i:2;a:7:{s:2:"id";s:1:"8";s:7:"form_id";s:1:"6";s:4:"type";s:9:"_textarea";s:5:"order";s:1:"2";s:4:"data";a:14:{s:5:"label";s:7:"Message";s:9:"label_pos";s:5:"above";s:13:"default_value";s:0:"";s:12:"textarea_rte";s:1:"0";s:14:"textarea_media";s:1:"0";s:18:"disable_rte_mobile";s:1:"0";s:3:"req";s:1:"1";s:5:"class";s:0:"";s:9:"show_help";s:1:"0";s:9:"help_text";s:0:"";s:9:"show_desc";s:1:"0";s:8:"desc_pos";s:4:"none";s:9:"desc_text";s:0:"";s:17:"calc_auto_include";s:1:"0";}s:6:"fav_id";s:1:"0";s:6:"def_id";s:1:"0";}i:3;a:7:{s:2:"id";s:2:"10";s:7:"form_id";s:1:"6";s:4:"type";s:7:"_submit";s:5:"order";s:1:"3";s:4:"data";a:7:{s:5:"label";s:4:"Send";s:5:"class";s:0:"";s:9:"show_help";s:1:"0";s:9:"help_text";s:0:"";s:9:"show_desc";s:1:"0";s:8:"desc_pos";s:4:"none";s:9:"desc_text";s:0:"";}s:6:"fav_id";s:1:"0";s:6:"def_id";s:1:"0";}i:4;a:7:{s:2:"id";s:2:"12";s:7:"form_id";s:1:"6";s:4:"type";s:9:"_honeypot";s:5:"order";s:1:"4";s:4:"data";a:3:{s:5:"label";s:68:"If you are a human and are seeing this field, please leave it blank.";s:15:"input_limit_msg";s:17:"character(s) left";s:13:"honeypot_save";s:0:"";}s:6:"fav_id";N;s:6:"def_id";N;}}s:13:"notifications";a:2:{i:8;a:20:{s:12:"date_updated";s:10:"2014-09-09";s:6:"active";s:1:"1";s:4:"name";s:15:"Success Message";s:4:"type";s:15:"success_message";s:12:"email_format";s:4:"html";s:10:"attach_csv";s:1:"0";s:9:"from_name";s:0:"";s:12:"from_address";s:0:"";s:8:"reply_to";s:0:"";s:2:"to";s:0:"";s:2:"cc";s:0:"";s:3:"bcc";s:0:"";s:13:"email_subject";s:0:"";s:13:"email_message";s:0:"";s:12:"redirect_url";s:0:"";s:19:"success_message_loc";s:32:"ninja_forms_display_after_fields";s:11:"success_msg";s:53:"Thanks! Your message has been successfully submitted.";s:19:"text_message_number";s:0:"";s:20:"text_message_carrier";s:1:"0";s:20:"text_message_message";s:0:"";}i:9;a:20:{s:12:"date_updated";s:10:"2014-09-09";s:6:"active";s:1:"1";s:4:"name";s:11:"Email Admin";s:4:"type";s:5:"email";s:12:"email_format";s:4:"html";s:10:"attach_csv";s:1:"0";s:9:"from_name";s:7:"field_6";s:12:"from_address";s:7:"field_7";s:8:"reply_to";s:7:"field_7";s:2:"to";s:19:"testing@example.com";s:2:"cc";s:0:"";s:3:"bcc";s:0:"";s:13:"email_subject";s:24:"Website form submission.";s:13:"email_message";s:24:"[ninja_forms_all_fields]";s:12:"redirect_url";s:0:"";s:19:"success_message_loc";s:33:"ninja_forms_display_before_fields";s:11:"success_msg";s:0:"";s:19:"text_message_number";s:0:"";s:20:"text_message_carrier";s:1:"0";s:20:"text_message_message";s:0:"";}}}',

		/*
		// form alias
		'form_alias' => 
			// form export data
			'export_data',
		*/
	);


	// Import the data 
	// --------------------------------------------------
	if (function_exists('theme_demo_import_ninja_forms')) {
		theme_demo_import_ninja_forms( $forms_data );
	}

}
endif; 


# --------------------------------------------------
# Ninja Form - demo data import
# --------------------------------------------------

if (!function_exists('theme_demo_import_ninja_forms')) :
function theme_demo_import_ninja_forms( $forms_data = array() ) {

	// Loop through data and add to DB as needed
	foreach ($forms_data as $option_alias => $option_data) {
		
		// Generate the 'option_name' for the row
		$theme_name  = wp_get_theme();
		$option_name = sanitize_key( $theme_name->get('Name').'_'.$option_alias);

		// Check for a previous import
		if( !get_option( $option_name ) ) {
			if (function_exists('ninja_forms_import_form')) {
				ninja_forms_import_form( $option_data );                                // add ninja forms data
				update_option( $option_name, maybe_unserialize( $option_data, true ) ); // backup and log import in DB
			}
		}
	}
}
endif;


# --------------------------------------------------
# Add action for data import
# --------------------------------------------------

// Call the demo data function after theme setup (admin only)
add_action( 'after_setup_theme', 'theme_demo_data' );

