<?php
/**
 * Version Control
 *
 * @file           version.php
 * @package        WordPress
 * @subpackage     Responsive
 * @author         Emil Uzelac
 * @copyright      2003 - 2014 CyberChimps
 * @license        license.txt
 * @version        Release: 1.2
 * @filesource     wp-content/themes/responsive/includes/version.php
 * @link           N/A
 * @since          available since Release 1.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<?php
/**
 * [responsive_template_data description]
 *
 * @return void [description].
 */
function responsive_template_data() {
	echo '<!-- We need this for debugging -->' . "\n";
	echo '<!-- ' . esc_html( get_responsive_template_name() . ' ' . get_responsive_template_version() ) . ' -->' . "\n";
}

add_action( 'wp_head', 'responsive_template_data' );

/**
 * [responsive_theme_data description]
 *
 * @return void [description]
 */
function responsive_theme_data() {
	if ( is_child_theme() ) {
		echo '<!-- ' . esc_html( get_responsive_theme_name() . ' ' . get_responsive_theme_version() ) . ' -->' . "\n";
	}
}

add_action( 'wp_head', 'responsive_theme_data' );

/**
 * [get_responsive_theme_name description]
 *
 * @return [type] [description]
 */
function get_responsive_theme_name() {
	$theme = wp_get_theme();

	return $theme->get( 'Name' );
}

/**
 * [get_responsive_theme_version description]
 *
 * @return [type] [description]
 */
function get_responsive_theme_version() {
	$theme = wp_get_theme();

	return $theme->get( 'Version' );
}

/**
 * [get_responsive_template_name description]
 *
 * @return [type] [description]
 */
function get_responsive_template_name() {
	$theme  = wp_get_theme();
	$parent = $theme->parent();
	if ( $parent ) {
		$theme = $parent;
	}

	return $theme->get( 'Name' );
}

/**
 * [get_responsive_template_version description]
 *
 * @return [type] [description]
 */
function get_responsive_template_version() {
	$theme  = wp_get_theme();
	$parent = $theme->parent();
	if ( $parent ) {
		$theme = $parent;
	}

	return $theme->get( 'Version' );
}
