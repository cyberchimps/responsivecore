<?php
/**
 * mobile-first Theme Customizer
 *
 * @package mobile-first
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function responsive_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';


/*--------------------------------------------------------------
	// Theme Elements
--------------------------------------------------------------*/

	$wp_customize->add_section( 'theme_elements', array(
		'title'                 => __( 'Theme Elements', 'responsive' ),
		'priority'              => 30
	) );
	$wp_customize->add_setting( 'breadcrumb', array( 'default' => '') );
	$wp_customize->add_control( 'res_breadcrumb', array(
		'label'                 => __( 'Disable breadcrumb list?', 'responsive' ),
		'section'               => 'theme_elements',
		'settings'              => 'breadcrumb',
		'type'                  => 'checkbox'
	) );
	$wp_customize->add_setting( 'cta_button', array( 'default' => '') );
	$wp_customize->add_control( 'res_cta_button', array(
		'label'                 => __( 'Disable Call to Action Button?', 'responsive' ),
		'section'               => 'theme_elements',
		'settings'              => 'cta_button',
		'type'                  => 'checkbox'
	) );
	$wp_customize->add_setting( 'minified_css', array( 'default' => '') );
	$wp_customize->add_control( 'res_minified_css', array(
		'label'                 => __( 'Enable minified css?', 'responsive' ),
		'section'               => 'theme_elements',
		'settings'              => 'minified_css',
		'type'                  => 'checkbox'
	) );
	$wp_customize->add_setting( 'blog_post_title_toggle', array( 'default' => '') );
	$wp_customize->add_control( 'res_blog_post_title_toggle', array(
		'label'                 => __( 'Enable Blog Title', 'responsive' ),
		'section'               => 'theme_elements',
		'settings'              => 'blog_post_title_toggle',
		'type'                  => 'checkbox'
	) );

	$wp_customize->add_setting( 'blog_post_title_text', array( 'default' => '') );
	$wp_customize->add_control( 'res_blog_post_title_text', array(
		'label'                 => __( 'Title Text', 'responsive' ),
		'section'               => 'theme_elements',
		'settings'              => 'blog_post_title_text',
		'type'                  => 'text'
	) );

/*--------------------------------------------------------------
	// Logo Upload
--------------------------------------------------------------*/

	$wp_customize->add_section( 'logo_upload', array(
		'title'                 => __( 'Logo Upload', 'responsive' ),
		'priority'              => 30
	) );
	$wp_customize->add_setting( 'logo_upload_img', array( 'default' => '') );
	$wp_customize->add_control( 'res_logo_upload_img', array(
		'label'                 => __( 'Custom Header', 'responsive' ),
		'section'               => 'logo_upload',
		'settings'              => 'logo_upload_img',
		'type'                  => 'hidden',
		'description'           => __( 'Need to replace or remove default logo?', 'responsive' ) . sprintf( ' <a href="%s">' . __( 'Click here', 'responsive' ) . '</a>.',
				                   admin_url( 'themes.php?page=custom-header' ) )
	) );



/*--------------------------------------------------------------
	// Home Page
--------------------------------------------------------------*/

	$wp_customize->add_section( 'home_page', array(
		'title'                 => __( 'Home Page', 'responsive' ),
		'priority'              => 30
	) );
	$wp_customize->add_setting( 'front_page', array( 'default' => '') );
	$wp_customize->add_control( 'res_front_page', array(
		'label'                 => __( 'Enable Custom Front Page', 'responsive' ),
		'section'               => 'home_page',
		'settings'              => 'front_page',
		'type'                  => 'checkbox',
		'description'           => sprintf( __( 'Overrides the WordPress %1sfront page option%2s', 'responsive' ), '<a href="options-reading.php">', '</a>' )
	) );
	$wp_customize->add_setting( 'home_headline', array( 'default' => __( 'Hello, World!', 'responsive' )) );
	$wp_customize->add_control( 'res_home_headline', array(
		'label'                 => __( 'Headline', 'responsive' ),
		'section'               => 'home_page',
		'settings'              => 'home_headline',
		'type'                  => 'text'
	) );
	$wp_customize->add_setting( 'home_subheadline', array( 'default' => __( 'Your H2 subheadline here', 'responsive' )) );
	$wp_customize->add_control( 'res_home_subheadline', array(
		'label'                 => __( 'Subheadline', 'responsive' ),
		'section'               => 'home_page',
		'settings'              => 'home_subheadline',
		'type'                  => 'text'
	) );
	$wp_customize->add_setting( 'home_content_area', array( 'default' => __( 'Your title, subtitle and this very content is editable from Theme Option. Call to Action button and its destination link as well. Image on your right can be an image or even YouTube video if you like.', 'responsive' )) );
	$wp_customize->add_control( 'res_home_content_area', array(
		'label'                 => __( 'Content Area', 'responsive' ),
		'section'               => 'home_page',
		'settings'              => 'home_content_area',
		'type'                  => 'textarea'
	) );	
	$wp_customize->add_setting( 'cta_url', array( 'default' => '#nogo') );
	$wp_customize->add_control( 'res_cta_url', array(
		'label'                 => __( 'Call to Action (URL)', 'responsive' ),
		'section'               => 'home_page',
		'settings'              => 'cta_url',
		'type'                  => 'text'
	) );

	$wp_customize->add_setting( 'cta_text', array( 'default' => 'Call to Action') );
	$wp_customize->add_control( 'res_cta_text', array(
		'label'                 => __( 'Call to Action (Text)', 'responsive' ),
		'section'               => 'home_page',
		'settings'              => 'cta_text',
		'type'                  => 'text'
	) );

	$wp_customize->add_setting( 'featured_content', array( 'default' => '') );
	$wp_customize->add_control( 'res_featured_content', array(
		'label'                 => __( 'Featured Content', 'responsive' ),
		'section'               => 'home_page',
		'settings'              => 'featured_content',
		'type'                  => 'textarea',
		'description'           => __( 'Paste your shortcode, video or image source', 'responsive' )
	) );


/*--------------------------------------------------------------
	// Default Layouts
--------------------------------------------------------------*/

	$wp_customize->add_section( 'default_layouts', array(
		'title'                 => __( 'Default Layouts', 'responsive' ),
		'priority'              => 30
	) );
	$wp_customize->add_setting( 'static_page_layout_default' );
	$wp_customize->add_control( 'res_static_page_layout_default', array(
		'label'                 => __( 'Default Static Page Layout', 'responsive' ),
		'section'               => 'default_layouts',
		'settings'              => 'static_page_layout_default',
		'type'                  => 'select',
		'choices'              => Responsive_Options::valid_layouts()
	) );
	$wp_customize->add_setting( 'single_post_layout_default' );
	$wp_customize->add_control( 'res_single_post_layout_default', array(
		'label'                 => __( 'Default Single Blog Post Layout', 'responsive' ),
		'section'               => 'default_layouts',
		'settings'              => 'single_post_layout_default',
		'type'                  => 'select',
		'choices'               => Responsive_Options::valid_layouts()
	) );
	$wp_customize->add_setting( 'blog_posts_index_layout_default' );
	$wp_customize->add_control( 'res_hblog_posts_index_layout_default', array(
		'label'                 => __( 'Default Blog Posts Index Layout', 'responsive' ),
		'section'               => 'default_layouts',
		'settings'              => 'blog_posts_index_layout_default',
		'type'                  => 'select',
		'choices'               => Responsive_Options::valid_layouts()
	) );

/*--------------------------------------------------------------
	// SOCIAL MEDIA SECTION
--------------------------------------------------------------*/

	$wp_customize->add_section( 'responsive_social_media', array(
		'title'             => __( 'Social Icons', 'responsive' ),
		'priority'          => 40,
		'description'       => __( 'Enter the URL to your account for each service for the icon to appear in the header.', 'mobilefirst' ),
	) );

	// Add Twitter Setting

	$wp_customize->add_setting( 'twitter_uid', array( 'default' => '', 'sanitize_callback' => 'esc_url_raw', ) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'twitter', array(
		'label'             => __( 'Twitter', 'responsive' ),
		'section'           => 'responsive_social_media',
		'settings'          => 'twitter_uid',
		'sanitize_callback' => 'esc_url_raw'
	) ) );

	// Add Facebook Setting

	$wp_customize->add_setting( 'facebook_uid' , array( 'default' => '', 'sanitize_callback' => 'esc_url_raw', ));
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'facebook', array(
		'label'             => __( 'Facebook', 'responsive' ),
		'section'           => 'responsive_social_media',
		'settings'          => 'facebook_uid',
		'sanitize_callback' => 'esc_url_raw'
	) ) );

	// Add LinkedIn Setting

	$wp_customize->add_setting( 'linkedin_uid' , array( 'default' => '', 'sanitize_callback' => 'esc_url_raw', ));
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'linkedin', array(
		'label'             => __( 'LinkedIn', 'responsive' ),
		'section'           => 'responsive_social_media',
		'settings'          => 'linkedin_uid',
		'sanitize_callback' => 'esc_url_raw'
	) ) );

	// Add Youtube Setting

	$wp_customize->add_setting( 'youtube_uid' , array( 'default' => '', 'sanitize_callback' => 'esc_url_raw', ));
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'youtube', array(
		'label'             => __( 'Tumblr', 'responsive' ),
		'section'           => 'responsive_social_media',
		'settings'          => 'youtube_uid',
		'sanitize_callback' => 'esc_url_raw'
	) ) );

	// Add Google+ Setting

	$wp_customize->add_setting( 'googleplus_uid' , array( 'default' => '', 'sanitize_callback' => 'esc_url_raw', ));
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'googleplus', array(
		'label'             => __( 'Google+', 'responsive' ),
		'section'           => 'responsive_social_media',
		'settings'          => 'googleplus_uid',
		'sanitize_callback' => 'esc_url_raw'
	) ) );

	// Add RSS Setting

	$wp_customize->add_setting( 'rss_uid' , array( 'default' => '', 'sanitize_callback' => 'esc_url_raw' ));
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'rss', array(
		'label'             => __( 'RSS Feed', 'responsive' ),
		'section'           => 'responsive_social_media',
		'settings'          => 'rss_uid',
		'sanitize_callback' => 'esc_url_raw'
	) ) );

	// Add Instagram Setting

	$wp_customize->add_setting( 'instagram_uid' , array( 'default' => '','sanitize_callback' => 'esc_url_raw', ));
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'instagram', array(
		'label'             => __( 'Instagram', 'responsive' ),
		'section'           => 'responsive_social_media',
		'settings'          => 'instagram_uid',
		'sanitize_callback' => 'esc_url_raw'
	) ) );

	// Add Pinterest Setting

	$wp_customize->add_setting( 'pinterest_uid' , array( 'default' => '', 'sanitize_callback' => 'esc_url_raw', ));
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'pinterest', array(
		'label'             => __( 'Pinterest', 'responsive' ),
		'section'           => 'responsive_social_media',
		'settings'          => 'pinterest_uid',
		'sanitize_callback' => 'esc_url_raw'
	) ) );

	// Add StumbleUpon Setting

	$wp_customize->add_setting( 'stumbleupon_uid' , array( 'default' => '', 'sanitize_callback' => 'esc_url_raw', ));
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'stumble', array(
		'label'             => __( 'StumbleUpon', 'responsive' ),
		'section'           => 'responsive_social_media',
		'settings'          => 'stumbleupon_uid',
		'sanitize_callback' => 'esc_url_raw'
	) ) );	

	// Add Vimeo Setting

	$wp_customize->add_setting( 'vimeo_uid' , array( 'default' => '', 'sanitize_callback' => 'esc_url_raw', ));
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'vimeo', array(
		'label'             => __( 'Vimeo', 'responsive' ),
		'section'           => 'responsive_social_media',
		'settings'          => 'vimeo_uid',
		'sanitize_callback' => 'esc_url_raw'
	) ) );

	// Add SoundCloud Setting

	$wp_customize->add_setting( 'yelp_uid' , array( 'default' => '','sanitize_callback' => 'esc_url_raw', ));
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'yelp', array(
		'label'             => __( 'Yelp', 'responsive' ),
		'section'           => 'responsive_social_media',
		'settings'          => 'yelp_uid',
		'sanitize_callback' => 'esc_url_raw'
	) ) );

	// Add Foursquare Setting

	$wp_customize->add_setting( 'foursquare_uid' , array( 'default' => '', 'sanitize_callback' => 'esc_url_raw', ));
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'foursquare', array(
		'label'             => __( 'Foursquare', 'responsive' ),
		'section'           => 'responsive_social_media',
		'settings'          => 'foursquare_uid',
		'sanitize_callback' => 'esc_url_raw'
	) ) );

/*--------------------------------------------------------------
	// CSS Styles
--------------------------------------------------------------*/

	$wp_customize->add_section( 'css_styles', array(
		'title'                 => __( 'CSS Styles', 'responsive' ),
		'priority'              => 30
	) );
	$wp_customize->add_setting( 'responsive_inline_css' );
	$wp_customize->add_control( 'res_responsive_inline_css', array(
		'label'                 => __( 'Custom CSS Styles', 'responsive' ),
		'section'               => 'css_styles',
		'settings'              => 'responsive_inline_css',
		'type'                  => 'textarea'
	) );
	
/*--------------------------------------------------------------
	// Scripts
--------------------------------------------------------------*/

	$wp_customize->add_section( 'scripts', array(
		'title'                 => __( 'Scripts', 'responsive' ),
		'priority'              => 30
	) );
	$wp_customize->add_setting( 'responsive_inline_js_head' );
	$wp_customize->add_control( 'res_responsive_inline_js_head', array(
		'label'                 => __( 'Embeds to header.php', 'responsive' ),
		'section'               => 'scripts',
		'settings'              => 'responsive_inline_js_head',
		'type'                  => 'textarea'
	) );

	$wp_customize->add_setting( 'responsive_inline_js_footer' );
	$wp_customize->add_control( 'res_responsive_inline_js_footer', array(
		'label'                 => __( 'Embeds to footer.php', 'responsive' ),
		'section'               => 'scripts',
		'settings'              => 'responsive_inline_js_footer',
		'type'                  => 'textarea'
	) );


}
add_action( 'customize_register', 'responsive_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function responsive_customize_preview_js() {
	wp_enqueue_script( 'responsive_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'responsive_customize_preview_js' );
