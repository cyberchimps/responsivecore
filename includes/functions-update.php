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
	if ( !isset( $responsive_options['googleplus_uid'] ) ) {
		$responsive_options['googleplus_uid'] = $responsive_options['google_plus_uid'];
	}
	if ( !isset( $responsive_options['stumbleupon_uid'] ) ) {
		$responsive_options['stumbleupon_uid'] = $responsive_options['stumble_uid'];
	}

	// Update entire array
	update_option( 'responsive_theme_options', $responsive_options );
}

add_action( 'after_setup_theme', 'responsive_update_social_icon_options' );

/**
 * Used by responsive_theme_query() to get theme data from WordPress.org API and save info to cache
 *
 * @param $args
 *
 * @return array|mixed|WP_Error
 */
/*function responsive_get_theme_information( $args ) {
	// Set the $request array
	$request = array(
		'body' => array(
			'action'  => 'theme_information',
			'request' => serialize( (object)$args )
		)
	);

	// Generate a cache key that would hold the response for this request:
	$key = 'responsive_theme_' . md5( serialize( $request ) );

	// Check transient. If it's there - use that, if not re fetch the theme
	if ( false === ( $theme = get_transient( $key ) ) ) {

		// Theme not found - we need to re-fetch it
		$response = wp_remote_post( 'http://api.wordpress.org/themes/info/1.0/', $request );

		if ( is_wp_error( $response ) ) {
			return $response;
		}

		$theme = unserialize( wp_remote_retrieve_body( $response ) );

		if ( !is_object( $theme ) && !is_array( $theme ) ) {
			return new WP_Error( 'theme_api_error', 'An unexpected error has occurred' );
		}

		// Set transient for 24 hours
		set_transient( $key, $theme, 60 * 60 * 24 );
	}

	return $theme;
}*/

/**
 * Queries WordPress.org API to get details on responsive theme where we can get the current version number
 *
 * @param $theme_slug
 */
function responsive_theme_query() {

	$themes = get_theme_updates();

	$new_version = array();
	foreach ( $themes as $stylesheet => $theme ) {
		if ( 'responsive' == $stylesheet ) {
			$new_version = $theme->update['new_version'];
		}
	}

	// If we cannot get the response return false
	if ( is_wp_error( $new_version ) ) {
		return false;
	}

	// compare the current version on wp.org to version 2. If it is version 2 or greater display a message
	if ( version_compare( $new_version, '2.0', '>' ) ) {
		return true;
	}

}

/**
 * Add admin notice
 *
 */
function responsive_admin_update_notice(){
	global $pagenow;
	// Add plugin notification only if the current user is admin and on theme.php
	if ( responsive_theme_query() && current_user_can( 'update_themes' ) && ( 'themes.php' == $pagenow || 'update-core.php' == $pagenow ) ) {
		$html = '<div class="error"><p>';
		$html .= sprintf(
				/* Translators: This is a big update. Please read the blog post before updating. */
				__( '<strong>WARNING:</strong> There is a big <strong>Responsive Theme</strong> update available. Please read the %1$s before updating.', 'flowplayer5' ),
				'<a href="' . esc_url( 'http://cyberchimps.com/2014/03/responsive-2-0-update/' ) . '">' . __( 'blog post', 'flowplayer5' ) . '</a>'
			);
		$html .= '</p></div>';
		echo $html;
	}
}
add_action( 'admin_notices', 'responsive_admin_update_notice' );
