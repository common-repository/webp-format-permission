<?php
/**
 * Plugin Name: WEBP Format Permission
 * Plugin URI: https://wordpress.org/plugins/webp-format-permission
 * Description: This plugin will allow you to upload and view WEBP images
 * Version: 1.0.0
 * Requires at least: 5.0
 * Requires PHP: 7.3
 * Author: Mainul Sunvi
 * Author URI: https://profiles.wordpress.org/mainulsunvi/
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: wfp
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

function wfp_loded() {
	load_plugin_textdomain( 'wfp', false, dirname( __FILE__ ) . '/languages' );
}
add_action( 'plugins_loaded', 'wfp_loded' );

if ( ! function_exists( 'wfp_upload_mimes' ) ) {
	function wfp_upload_mimes( $existing_mimes ) {
		$existing_mimes['webp'] = 'image/webp';
		
		return $existing_mimes;
	}
}
add_filter( 'mime_types', 'wfp_upload_mimes' );

if ( ! function_exists( 'wfp_display' ) ) {
	function wfp_display( $result, $path ) {
		if ( $result === false ) {
			$displayable_image_types = array( IMAGETYPE_WEBP );
			$info = @getimagesize( $path );
			
			if ( empty( $info ) ) {
				$result = false;
			} elseif ( ! in_array( $info[2], $displayable_image_types ) ) {
				$result = false;
			} else {
				$result = true;
			}
		}
		
		return $result;
	}
}
add_filter( 'file_is_displayable_image', 'wfp_display', 10, 2 );