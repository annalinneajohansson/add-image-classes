<?php
/*
Plugin Name: Add image classes
Plugin URI: 
Description: Define additional css classes added to images on post insertion
Version: 1
Author: Anna Johansson
Author URI: http://annathewebdesigner.com
*/

add_action('admin_init', 'atw_ic_setup');

function atw_ic_setup() {

    load_plugin_textdomain('atw_ic', false, basename(dirname(__FILE__)) . '/languages');

    register_setting(
        'media',              // settings page
        'atw_ic_options'
    );
    add_settings_field(
        'atw_ic',      	// field id
        __('CSS classes', 'atw_ic'), 
        'atw_ic_input', // display callback function
        'media',		// settings page
        'default'       // settings section
    );
    // display callback function:
    function atw_ic_input() {
        $options = get_option( 'atw_ic_options' );
        echo "<input name='atw_ic_options[classes]' size='45' type='text' value='" . wp_kses($options['classes'], array()) . "' />";
		echo '<p class="description">' . __('Separate classes with a space.') . '</p>'; 
    }
}

add_filter( 'get_image_tag_class', 'add_generic_image_class' );

function add_generic_image_class( $class ) {
	
	$options = get_option('atw_ic_options');
	$additional_classes = $options['classes'];
	
    $class .= " $additional_classes";
	return $class;
}
