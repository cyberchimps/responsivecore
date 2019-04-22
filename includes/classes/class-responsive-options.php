<?php
/**
 * Theme Options Class
 *
 * Creates the options from supplied arrays
 *
 * Requires a sections array and an options array
 *
 * @file           class-responsive-options.php
 * @package        Responsive
 * @author         CyberChimps
 * @copyright      CyberChimps
 * @license        license.txt
 * @version        Release: 1.0
 * @since          available since Release 1.9.5
 */

/**
 * [Responsive_Options description]
 */
class Responsive_Options {

	/**
	 * [public description]
	 *
	 * @var [type]
	 */
	public $sections;
	/**
	 * [public description]
	 *
	 * @var [type]
	 */
	public $options;
	/**
	 * [public description]
	 *
	 * @var [type]
	 */
	public $responsive_options;

	/**
	 * Pulls in the arrays for the options and sets up the responsive options
	 *
	 * @param [type] $sections [description].
	 * @param [type] $options  [description].
	 */
	public function __construct( $sections, $options ) {
		$this->sections           = $sections;
		$this->options            = $options;
		$this->responsive_options = get_option( 'responsive_theme_options' );
		// Set confirmaton text for restore default option as attributes of submit_button().
		$this->attributes['onclick'] = 'return confirm("' . __( 'Do you want to restore?', 'responsive' ) . '\n' . __( 'All theme settings will be lost!', 'responsive' ) . '\n' . __( 'Click OK to Restore.', 'responsive' ) . '")';
	}

	/**
	 * Displays the options, called from class instance
	 *
	 * Loops through sections array
	 *
	 * @return void description
	 */
	public function render_display() {
		$html = '';
		$i    = 1;
		foreach ( $this->sections as $section ) {
			$this->display_title( $section['id'], $section['title'], $i++ );
		}
		$i = 1;
		echo '<ul>';
		foreach ( $this->sections as $section ) {
			$sub = $this->options[ $section['id'] ];
			$this->display_data( $section['id'], $sub, $i++ );
		}
		echo '</ul>';
	}

	/**
	 * [display_title description]
	 *
	 * @param  [type] $id    [description].
	 * @param  [type] $title [description].
	 * @param  [type] $i     [description].
	 * @return void        [description]
	 */
	protected function display_title( $id, $title, $i ) {

		$check = '';
		if ( '1' == $i ) {
			$check = 'checked=checked';
		}

		echo wp_kses_post( '<input type="radio"' . $check . ' name="sky-tabs" id="sky-' . $id . '"  class="sky-tab-content-' . $i . '">' );
		echo wp_kses_post( '<label for="sky-' . $id . '"><span><span><i class="fa fa-bolt"></i>' . esc_html( $title ) . ' </span></span></label>' );

	}

	/**
	 * Creates main sections title and container
	 *
	 * Loops through the options array
	 *
	 * @param  [type] $id  [description].
	 * @param  [type] $sub [description].
	 * @param  [type] $i   [description].
	 * @return void      [description]
	 */
	protected function display_data( $id, $sub, $i ) {

		echo wp_kses_post( '<li class="sky-tab-content-' . $i . '"><div class="typography">' ); // echo<p>;.
		foreach ( $sub as $opt ) {
			echo wp_kses_post( $this->sub_heading( $this->parse_args( $opt ) ) );
			echo wp_kses_post( $this->section( $this->parse_args( $opt ) ) );
		}
		echo wp_kses_post( $this->save() );
		// echo</p>';.
		echo '</div>	 </li>';

	}

	/**
	 * Creates the title section for each option input
	 *
	 * @param  [type] $args [description].
	 * @return void       [description].
	 */
	protected function sub_heading( $args ) {

		// If width is not set or it's not set to full then go ahead and create default layout.
		if ( ! isset( $args['width'] ) || 'full' != $args['width'] ) {
			echo '<div class="grid col-300">';

			echo esc_html( $args['title'] );

			echo esc_html( $args['subtitle'] );

			echo '</div><!-- end of .grid col-300 -->';

		}
	}

	/**
	 * Creates option section with inputs
	 *
	 * Calls option type
	 *
	 * @param  [type] $options [description].
	 * @return void          [description].
	 */
	protected function section( $options ) {

		// If the width is not set to full then create normal grid size, otherwise create full width.
		$html = ( ! isset( $options['width'] ) || 'full' != $options['width'] ) ? '<div class="grid col-620 fit">' : '<div class="grid col-940">';

		$html .= $this->{$options['type']}( $options );

		$html .= '</div>';

		echo wp_kses_post( $html );

	}

	/**
	 * Creates text input
	 *
	 * @param  [type] $args [description].
	 * @return [type]       [description]
	 */
	protected function text( $args ) {

		extract( $args );

		$value = ( ! empty( $this->responsive_options[ $id ] ) ) ? ( $this->responsive_options[ $id ] ) : '';

		$html = '<input id="' . esc_attr( 'responsive_theme_options[' . $id . ']' ) . '" class="regular-text" type="text" name="' . esc_attr( 'responsive_theme_options[' . $id . ']' ) . '" value="'
			. esc_html( $value ) . '"
        placeholder="' .
			esc_attr( $placeholder ) . '" />
                 <label class="description" for="' . esc_attr( 'responsive_theme_options[' . $id . ']' ) . '">' . esc_html( $description ) . '</label>';

		return $html;
	}

	/**
	 * Creates textarea input
	 *
	 * @param  [type] $args [description].
	 * @return [type]       [description]
	 */
	protected function textarea( $args ) {

		extract( $args );

		$class[] = 'large-text';
		$classes = implode( ' ', $class );

		$value = ( ! empty( $this->responsive_options[ $id ] ) ) ? $this->responsive_options[ $id ] : '';

		$html = '<p>' . esc_html( $heading ) . '</p>
                <textarea id="' . esc_attr( 'responsive_theme_options[' . $id . ']' ) . '" class="' . esc_attr( $classes ) . '" cols="50" rows="10" name="' . esc_attr(
			'responsive_theme_options[' . $id .
				']'
		) . '"
                 placeholder="' . $placeholder . '">' .
			esc_html( $value ) .
			'</textarea>
			<label class="description" for="' . esc_attr( 'responsive_theme_options[' . $id . ']' ) . '">' . esc_html( $description ) . '</label>';

		return $html;
	}

	/**
	 * Creates select dropdown input
	 *
	 * Loops through options
	 *
	 * @param  [type] $args [description].
	 * @return [type]       [description]
	 */
	protected function select( $args ) {

		extract( $args );
		if ( 'featured_area_layout' == $args['id'] ) {
			$layout_class = 'responsive_layouts';
		} else {
			$layout_class = '';
		}

		$html = '<select class=' . $layout_class . ' id="' . esc_attr( 'responsive_theme_options[' . $id . ']' ) . '" name="' . esc_attr( 'responsive_theme_options[' . $id . ']' ) . '">';
		foreach ( $options as $key => $value ) {
			$html .= '<option' . selected( $this->responsive_options[ $id ], $key, false ) . ' value="' . esc_attr( $key ) . '">' . esc_html( $value ) . '</option>';
		}
		$html .= '</select>';

		return $html;

	}

	/**
	 * Creates checkbox input
	 *
	 * @param  [type] $args [description].
	 * @return [type]       [description]
	 */
	protected function checkbox( $args ) {

		extract( $args );

		$checked = ( isset( $this->responsive_options[ $id ] ) ) ? checked( '1', esc_attr( $this->responsive_options[ $id ] ), false ) : checked( 0, 1 );

		$html = '<input id="' . esc_attr( 'responsive_theme_options[' . $id . ']' ) . '" name="' . esc_attr( 'responsive_theme_options[' . $id . ']' ) . '" type="checkbox" value="1" ' . $checked . '
         />
                <label class="description" for="' . esc_attr( 'responsive_theme_options[' . $id . ']' ) . '">' . wp_kses_post( $description ) . '</label>';

		return $html;
	}

	/**
	 * [radio_grid description]
	 *
	 * @param  [type] $args [description].
	 * @return [type]       [description]
	 */
	protected function radio_grid( $args ) {

		extract( $args );

		$saved_value = ( ! empty( $this->responsive_options[ $id ] ) ) ? $this->responsive_options[ $id ] : 'default-layout';

		$html = '<div class="responsive-layouts-wrapper">';

		if ( ! empty( $values ) ) {

			foreach ( $values as $radio_input => $key ) {

				if ( $saved_value == $radio_input ) {
					$selected = 'selected-grid';
					$checked  = 'checked = checked';
				} else {
					$selected = '';
					$checked  = '';
				}

				$grid_layout_image = get_template_directory_uri() . '/pro/lib/images/' . $radio_input . '.png';

				$html .= '<div class="radio-grids-option-wrapper">';
				$html .= '<div class="radio-grid-description">' . $key . '</div>';
				$html .= '<img class="' . $selected . '" src = "' . $grid_layout_image . '" onclick="document.getElementById(\'' . $radio_input . '\').checked=true;"/>';
				$html .= '<input type="radio" id="' . $radio_input . '" name="responsive_theme_options[' . $id . ']" class="radio-grids" ' . $checked . ' value="' . $radio_input . '" style="display: none;">';
				$html .= '</div>';
			}
		}

		$html .= '</div>';

		return $html;
	}
	/**
	 * Creates description only. No input
	 *
	 * @param  [type] $args [description].
	 * @return [type]       [description]
	 */
	protected function description( $args ) {

		extract( $args );

		$html = '<p>' . wp_kses_post( $description ) . '</p>';

		return $html;
	}

	/**
	 * Creates save, reset and upgrade buttons
	 *
	 * @return void [description]
	 */
	protected function save() {
		$allowed_html = array(
			'div'    => array(
				'class' => array(),
				'id'    => array(),
			),

			'p'      => array(
				'class' => array(),
				'id'    => array(),
			),

			'input'  => array(
				'class' => array(),
				'id'    => array(),
				'name'  => array(),
				'value' => array(),
			),

			'button' => array(
				'class' => array(),
				'id'    => array(),
				'value' => array(),
			),

			'a'      => array(
				'href'  => array(),
				'title' => array(),
			),

			'br'     => array(),
			'em'     => array(),
			'strong' => array(),
		);

		echo wp_kses(
			'<div class="grid col-940">
                <p class="submit">
				' . get_submit_button( __( 'Save Options', 'responsive' ), 'primary', 'responsive_theme_options[submit]', false ) .
					get_submit_button( __( 'Restore Defaults', 'responsive' ), 'secondary', 'responsive_theme_options[reset]', false, $this->attributes ) . '
                <!--<a href="http://cyberchimps.com/store/responsivepro/" class="button upgrade">' . __( 'Upgrade', 'responsive' ) . '</a>-->
                </p>
                </div>',
			$allowed_html
		);

	}

	/**
	 * [responsive_pro_categorylist_validate description]
	 *
	 * @return [type] [description]
	 */
	public static function responsive_pro_categorylist_validate() {
		// An array of valid results.
		$args                  = array(
			'type'         => 'post',
			'orderby'      => 'name',
			'order'        => 'ASC',
			'hide_empty'   => 1,
			'hierarchical' => 1,
			'taxonomy'     => 'category',
		);
		$option_categories     = array();
		$category_lists        = get_categories( $args );
		$option_categories[''] = esc_html( __( 'Choose Category', 'responsive' ) );
		foreach ( $category_lists as $category ) {
			$option_categories[ $category->term_id ] = $category->name;
		}
		return $option_categories;
	}

	/**
	 * Default layouts static function
	 *
	 * @return array
	 */
	public static function valid_layouts() {
		$layouts = array(
			'default'                   => __( 'Default', 'responsive' ),
			'content-sidebar-page'      => __( 'Content/Sidebar', 'responsive' ),
			'sidebar-content-page'      => __( 'Sidebar/Content', 'responsive' ),
			'content-sidebar-half-page' => __( 'Content/Sidebar Half Page', 'responsive' ),
			'sidebar-content-half-page' => __( 'Sidebar/Content Half Page', 'responsive' ),
			'full-width-page'           => __( 'Full Width Page (no sidebar)', 'responsive' ),
		);

		return apply_filters( 'responsive_valid_layouts', $layouts );
	}
	/**
	 * Default blog layouts static function
	 *
	 * @return array
	 */
	public static function blog_valid_layouts() {
		$bloglayouts = array(
			'default'                   => __( 'Default', 'responsive' ),
			'content-sidebar-page'      => __( 'Content/Sidebar', 'responsive' ),
			'sidebar-content-page'      => __( 'Sidebar/Content', 'responsive' ),
			'content-sidebar-half-page' => __( 'Content/Sidebar Half Page', 'responsive' ),
			'sidebar-content-half-page' => __( 'Sidebar/Content Half Page', 'responsive' ),
			'full-width-page'           => __( 'Full Width Page (no sidebar)', 'responsive' ),
			'blog-3-col'                => __( 'Blog 3 Column', 'responsive' ),
		);

		return apply_filters( 'responsive_blog_valid_layouts', $bloglayouts );
	}

	/**
	 * Makes sure that every option has all the required args
	 *
	 * @param  [type] $args [description].
	 * @return [type]       [description]
	 */
	protected function parse_args( $args ) {
		$default_args = array(
			'title'       => '',
			'subtitle'    => '',
			'heading'     => '',
			'type'        => 'text',
			'id'          => '',
			'class'       => array(),
			'description' => '',
			'placeholder' => '',
			'options'     => array(),
		);

		$result = array_merge( $default_args, $args );

		return $result;
	}

	/**
	 * Creates editor input
	 *
	 * @param  [type] $args [description].
	 * @return [type]       [description]
	 */
	protected function editor( $args ) {

		extract( $args );

		$class[] = 'large-text';
		$classes = implode( ' ', $class );

		$value = ( ! empty( $this->responsive_options[ $id ] ) ) ? $this->responsive_options[ $id ] : '';

		$editor_settings = array(
			'textarea_name' => 'responsive_theme_options[' . $id . ']',
			'media_buttons' => true,
			'tinymce'       => array( 'plugins' => 'wordpress' ),
			'editor_class'  => esc_attr( $classes ),
		);
		if ( 'home_content_area' == $args['id'] ) {
			$editor_class = 'res_home_content_area';
		} elseif ( 'featured_content' == $args['id'] ) {
			$editor_class = 'res_featured_content_area';
		}

		$html = '<div class="tinymce-editor ' . $editor_class . '">';
		ob_start();
		$html .= wp_editor( $value, 'responsive_theme_options_' . $id . '_', $editor_settings );
		$html .= ob_get_contents();
		$html .= '<label class="description" for="' . esc_attr( 'responsive_theme_options[' . $id . ']' ) . '">' . esc_html( $description ) . '</label>';
		$html .= '</div>';
		ob_clean();
		return $html;
	}
}
