<?php
/**
 * Helps file locations in child themes. If the file is not being overwritten by the child theme then
 * return the parent theme location of the file. Great for images.
 *
 * @package responsive
 *
 * @return string complete uri
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * [responsive_child_uri description]
 *
 * @param  [type] $dir [description].
 * @return [type]      [description]
 */
function responsive_child_uri( $dir ) {
	if ( is_child_theme() ) {
		$directory = get_stylesheet_directory() . $dir;
		$test      = is_file( $directory );
		if ( is_file( $directory ) ) {
			$file = get_stylesheet_directory_uri() . $dir;
		} else {
			$file = get_template_directory_uri() . $dir;
		}
	} else {
		$file = get_template_directory_uri() . $dir;
	}

	return $file;
}

/**
 * This function removes WordPress generated category and tag atributes.
 * For W3C validation purposes only.
 *
 * @param  [type] $output [description].
 * @return [type]         [description]
 */
function responsive_category_rel_removal( $output ) {
	$output = str_replace( ' rel="category tag"', '', $output );

	return $output;
}

add_filter( 'wp_list_categories', 'responsive_category_rel_removal' );
add_filter( 'the_category', 'responsive_category_rel_removal' );

/**
 * Filter 'get_comments_number'
 *
 * Filter 'get_comments_number' to display correct
 * number of comments (count only comments, not
 * trackbacks/pingbacks)
 *
 * Chip Bennett Contribution
 *
 * @param  [type] $count [description].
 * @return [type]        [description]
 */
function responsive_comment_count( $count ) {
	if ( ! is_admin() ) {
		global $id;
		$comments         = get_comments( 'status=approve&post_id=' . $id );
		$comments_by_type = separate_comments( $comments );

		return count( $comments_by_type['comment'] );
	} else {
		return $count;
	}
}

add_filter( 'get_comments_number', 'responsive_comment_count', 0 );

/**
 * Wp_list_comments Pings Callback
 *
 * Wp_list_comments Callback function for
 * Pings (Trackbacks/Pingbacks)
 *
 * @param  [type] $comment [description].
 * @return void          [description]
 */
function responsive_comment_list_pings( $comment ) {
	$GLOBALS['comment'] = $comment; // phpcs:ignore
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>"><?php echo esc_url( comment_author_link() ); ?></li>
	<?php
}

/**
 * Sets the post excerpt length to 40 words.
 * Adopted from Coraline
 *
 * @param  [type] $length [description].
 * @return [type]         [description]
 */
function responsive_excerpt_length( $length ) {
	return 40;
}

add_filter( 'excerpt_length', 'responsive_excerpt_length' );

/**
 * Returns a "Read more" link for excerpts
 */
function responsive_read_more() {
	return '<div class="read-more"><a href="' . get_permalink() . '">' . __( 'Read more &#8250;', 'responsive' ) . '</a></div><!-- end of .read-more -->';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and responsive_read_more_link().
 *
 * @param  [type] $more [description].
 * @return [type]       [description]
 */
function responsive_auto_excerpt_more( $more ) {
	return '<span class="ellipsis">&hellip;</span>' . responsive_read_more();
}

add_filter( 'excerpt_more', 'responsive_auto_excerpt_more' );

/**
 * Adds a pretty "Read more" link to custom post excerpts.
 *
 * @param  [type] $output [description].
 * @return [type]         [description]
 */
function responsive_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= responsive_read_more();
	}

	return $output;
}

add_filter( 'get_the_excerpt', 'responsive_custom_excerpt_more' );

/**
 * This function removes inline styles set by WordPress gallery.
 *
 * @param  [type] $css [description].
 * @return [type]      [description]
 */
function responsive_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}

add_filter( 'gallery_style', 'responsive_remove_gallery_css' );

/**
 * This function removes default styles set by WordPress recent comments widget.
 */
function responsive_remove_recent_comments_style() {
	global $wp_widget_factory;
	if ( isset( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'] ) ) {
		remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
	}
}

add_action( 'widgets_init', 'responsive_remove_recent_comments_style' );

/**
 * Wp_title() Filter for better SEO.
 *
 * Adopted from Twenty Twelve
 *
 * @see http://codex.wordpress.org/Plugin_API/Filter_Reference/wp_title
 */
if ( ! function_exists( 'responsive_wp_title' ) && ! defined( 'AIOSEOP_VERSION' ) ) :

	/**
	 * [responsive_wp_title description]
	 *
	 * @param  [type] $title [description].
	 * @param  [type] $sep   [description].
	 * @return [type]        [description]
	 */
	function responsive_wp_title( $title, $sep ) {
		global $page, $paged;

		if ( is_feed() ) {
			return $title;
		}

		// Add the site name.
		$title .= get_bloginfo( 'name' );

		// Add the site description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) ) {
			$title .= " $sep $site_description";
		}

		// Add a page number if necessary.
		if ( $paged >= 2 || $page >= 2 ) {
			/* translators: 1: $paged */
			$title .= " $sep " . sprintf( __( 'Page %s', 'responsive' ), max( $paged, $page ) );
		}

		return $title;
	}

	add_filter( 'wp_title', 'responsive_wp_title', 10, 2 );

endif;

/**
 * This function removes .menu class from custom menus
 * in widgets only and fallback's on default widget lists
 * and assigns new unique class called .menu-widget
 *
 * Marko Heijnen Contribution
 */
class Responsive_Widget_Menu {

	/**
	 * [__construct description]
	 */
	public function __construct() {
		add_action( 'widget_display_callback', array( $this, 'menu_different_class' ), 10, 2 );
	}

	/**
	 * [menu_different_class description]
	 *
	 * @param  [type] $settings [description].
	 * @param  [type] $widget   [description].
	 * @return [type]           [description]
	 */
	public function menu_different_class( $settings, $widget ) {
		if ( $widget instanceof WP_Nav_Menu_Widget ) {
			add_filter( 'wp_nav_menu_args', array( $this, 'wp_nav_menu_args' ) );
		}

		return $settings;
	}

	/**
	 * [wp_nav_menu_args description]
	 *
	 * @param  [type] $args [description].
	 * @return [type]       [description]
	 */
	public function wp_nav_menu_args( $args ) {
		remove_filter( 'wp_nav_menu_args', array( $this, 'wp_nav_menu_args' ) );

		if ( 'menu' == $args['menu_class'] ) {
			$args['menu_class'] = apply_filters( 'responsive_menu_widget_class', 'menu-widget' );
		}

		return $args;
	}
}

$GLOBALS['nav_menu_widget_classname'] = new Responsive_Widget_Menu();

/**
 * Removes div from wp_page_menu() and replace with ul.
 *
 * @param  [type] $page_markup [description].
 * @return [type]              [description]
 */
function responsive_wp_page_menu( $page_markup ) {
	preg_match( '/^<div class=\"([a-z0-9-_]+)\">/i', $page_markup, $matches );
	$divclass   = $matches[1];
	$replace    = array( '<div class="' . $divclass . '">', '</div>' );
	$new_markup = str_replace( $replace, '', $page_markup );
	$new_markup = preg_replace( '/^<ul>/i', '<ul class="' . $divclass . '">', $new_markup );

	return $new_markup;
}

add_filter( 'wp_page_menu', 'responsive_wp_page_menu' );
