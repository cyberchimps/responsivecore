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
 * Responsive 2.0 update check
 *
 * Queries WordPress.org API to get details on responsive theme where we can get the current version number
 *
 * @return bool
 */
function responsive_theme_query() {

	$themes = get_theme_updates();

	$new_version = false;

	foreach ( $themes as $stylesheet => $theme ) {
		if ( 'responsive' == $stylesheet ) {
			$new_version = $theme->update['new_version'];
		}
	}

	// Check if we had a response and compare the current version on wp.org to version 2. If it is version 2 or greater display a message
	if ( $new_version && version_compare( $new_version, '2', '>=' ) ) {
		return true;
	}

	return false;

}

/**
 * Responsive 2.0 update warning message
 *
 * Displays warning message in the update notice
 */
function responsive_admin_update_notice(){
	global $pagenow;
	// Add plugin notification only if the current user is admin and on theme.php
	if ( responsive_theme_query() && current_user_can( 'update_themes' ) && ( 'themes.php' == $pagenow || 'update-core.php' == $pagenow ) ) {
		$html = '<div class="error"><p>';
		$html .= sprintf(
				/* Translators: This is a big update. Please read the blog post before updating. */
				__( '<strong>WARNING:</strong> There is a big <strong>Responsive Theme</strong> update available. Please read the %1$s before updating.', 'responsive' ),
				'<a href="' . esc_url( 'http://cyberchimps.com/2014/03/responsive-2-0-update/' ) . '">' . __( 'blog post', 'responsive' ) . '</a>'
			);
		$html .= '</p></div>';
		echo $html;
	}
}
add_action( 'admin_notices', 'responsive_admin_update_notice' );
