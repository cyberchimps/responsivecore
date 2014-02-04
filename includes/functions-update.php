<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * Update social icon options
 *
 * @since    1.9.4.9
 */
function responsive_update_social_icon_options() {
	$responsive_options = responsive_get_options();
	// If new option does not exist then copy the option
	if ( ! isset( $responsive_options['googleplus_uid'] ) ) {
		$responsive_options['googleplus_uid'] = $responsive_options['google_plus_uid'];
	}
	if ( ! isset( $responsive_options['stumbleupon_uid'] ) ) {
		$responsive_options['stumbleupon_uid'] = $responsive_options['stumble_uid'];
	}

	// Update entire array
	update_option( 'responsive_theme_options', $responsive_options );
}
add_action( 'after_setup_theme', 'responsive_update_social_icon_options' );
