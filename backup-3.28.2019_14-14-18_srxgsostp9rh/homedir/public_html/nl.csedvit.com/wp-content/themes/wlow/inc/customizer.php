<?php
/**
 * Contains methods for customizing the theme customization screen.
 *
 * @link http://codex.wordpress.org/Theme_Customization_API
 */

/* ------------------------------------------------------------------------- *
 *  Theme Options
/* ------------------------------------------------------------------------- */

function wlow_register_theme_customizer( $wp_customize ) {


	/* Start Panel */
	$wp_customize->add_panel('wlow__home',
      array(
          'title' => esc_html__('Home Page', 'wlow' ),
          'priority' => 31,
          )
      );
			/* Cover */
      $wp_customize->add_section( 'wlow__home__cover',
          array(
              'title' => esc_html__('Cover', 'wlow' ),
              'priority' => 1,
              'panel' => 'wlow__home'
              )
          );

					/* Title */
          $wp_customize->add_setting('wlow__home__cover__title', array('default' => esc_html__('The Amazing Parallax Theme', 'wlow' ),'sanitize_callback' => 'sanitize_text_field'));
          $wp_customize->add_control('wlow__home__cover__title', array(
              'label' => esc_html__( 'Title', 'wlow' ),
              'section' => 'wlow__home__cover',
              'type' => 'text',
              )
          );
					/* Subtitle */
          $wp_customize->add_setting('wlow__home__cover__subtitle', array('default' => esc_html__('With awesome navigation, Desktop & Mobile', 'wlow' ),'sanitize_callback' => 'sanitize_text_field'));
          $wp_customize->add_control('wlow__home__cover__subtitle', array(
              'label' => esc_html__('Subtitle', 'wlow' ),
              'section' => 'wlow__home__cover',
              'type' => 'text',
              )
          );
					/* Button */
          $wp_customize->add_setting('wlow__home__cover__button-label', array('default' => esc_html__('See the features', 'wlow' ),'sanitize_callback' => 'sanitize_text_field'));
          $wp_customize->add_control('wlow__home__cover__button-label', array(
              'label' => esc_html__('Button Label', 'wlow' ),
              'section' => 'wlow__home__cover',
              'type' => 'text',
              )
          );
					/* Link */
          $wp_customize->add_setting('wlow__home__cover__button-link', array('default' => esc_url( home_url( '/' ) ).'#focus', 'sanitize_callback' => 'sanitize_text_field'));
          $wp_customize->add_control('wlow__home__cover__button-link', array(
              'label' => esc_html__('Button Link', 'wlow' ),
              'section' => 'wlow__home__cover',
              'type' => 'text',
              )
          );
					/* Image */
					$wp_customize->add_setting('wlow__home__cover__image', array('default' => get_template_directory_uri() . '/img/demo/city.jpg','sanitize_callback' => 'wlow_sanitize_image_url'));
					$wp_customize->add_control(
						new WP_Customize_Image_Control(
							$wp_customize,
							'wlow_cover_image',
							array(
							    'label'    => esc_html__('Background Image', 'wlow' ),
							    'settings' => 'wlow__home__cover__image',
							    'section'  => 'wlow__home__cover'
							)
						)
					);

			/* One Page */
      $wp_customize->add_section( 'wlow__home__onepage',
          array(
              'title' => esc_html__('One Page Mode', 'wlow' ),
              'description' => esc_html__('This mode remove the links and buttons in Focus, Parallax and Side Panels.', 'wlow' ),
              'priority' => 6,
              'panel' => 'wlow__home'
              )
          );

					/* Hide */
					$wp_customize->add_setting('wlow__home__onepage__on', array( 'default' => false,'sanitize_callback' => 'wlow_sanitize_checkbox'));
					$wp_customize->add_control('wlow__home__onepage__on', array(
							'label'     => esc_html__('Activate One Page Mode', 'wlow' ),
							'section'   => 'wlow__home__onepage',
							'type'      => 'checkbox'
						)
					);

			/* Icons */
			$wp_customize->add_section( 'wlow__home__icons',
          array(
              'title' => esc_html__('Icons', 'wlow' ),
              'description' => esc_html__('Select the icons and links. See http://fontawesome.io/icons/ for full list of supported icons.', 'wlow' ),
              'priority' => 5,
              'panel' => 'wlow__home'
              )
          );
					/* Icon 1 */
          $wp_customize->add_setting('wlow__home__icons_1', array('default' => esc_html__('fa-rss', 'wlow' ),'sanitize_callback' => 'sanitize_text_field'));
          $wp_customize->add_control('wlow__home__icons_1', array(
              'label' => esc_html__('Icon 1', 'wlow' ),
              'section' => 'wlow__home__icons',
              'type' => 'text',
              )
          );
          $wp_customize->add_setting('wlow__home__link_1', array('default' => esc_html__('#', 'wlow' ),'sanitize_callback' => 'sanitize_text_field'));
          $wp_customize->add_control('wlow__home__link_1', array(
              'label' => esc_html__('Link 1', 'wlow' ),
              'section' => 'wlow__home__icons',
              'type' => 'text',
              )
          );

					/* Icon 2 */
					$wp_customize->add_setting('wlow__home__icons_2', array('default' => esc_html__('fa-map-marker', 'wlow' ),'sanitize_callback' => 'sanitize_text_field'));
          $wp_customize->add_control('wlow__home__icons_2', array(
              'label' => esc_html__('Icon 2', 'wlow' ),
              'section' => 'wlow__home__icons',
              'type' => 'text',
              )
          );
          $wp_customize->add_setting('wlow__home__link_2', array('default' => esc_html__('#', 'wlow' ),'sanitize_callback' => 'sanitize_text_field'));
          $wp_customize->add_control('wlow__home__link_2', array(
              'label' => esc_html__('Link 2', 'wlow' ),
              'section' => 'wlow__home__icons',
              'type' => 'text',
              )
          );

					/* Icon 3 */
					$wp_customize->add_setting('wlow__home__icons_3', array('default' => esc_html__('fa-envelope', 'wlow' ),'sanitize_callback' => 'sanitize_text_field'));
          $wp_customize->add_control('wlow__home__icons_3', array(
              'label' => esc_html__('Icon 3', 'wlow' ),
              'section' => 'wlow__home__icons',
              'type' => 'text',
              )
          );
          $wp_customize->add_setting('wlow__home__link_3', array('default' => esc_html__('#', 'wlow' ),'sanitize_callback' => 'sanitize_text_field'));
          $wp_customize->add_control('wlow__home__link_3', array(
              'label' => esc_html__('Link 3', 'wlow' ),
              'section' => 'wlow__home__icons',
              'type' => 'text',
              )
          );

					/* Icon 4 */
					$wp_customize->add_setting('wlow__home__icons_4', array('default' => esc_html__('fa-phone', 'wlow' ),'sanitize_callback' => 'sanitize_text_field'));
          $wp_customize->add_control('wlow__home__icons_4', array(
              'label' => esc_html__('Icon 4', 'wlow' ),
              'section' => 'wlow__home__icons',
              'type' => 'text',
              )
          );
          $wp_customize->add_setting('wlow__home__link_4', array('default' => esc_html__('#', 'wlow' ),'sanitize_callback' => 'sanitize_text_field'));
          $wp_customize->add_control('wlow__home__link_4', array(
              'label' => esc_html__('Link 4', 'wlow' ),
              'section' => 'wlow__home__icons',
              'type' => 'text',
              )
          );


			/* Latest News */
			$wp_customize->add_section( 'wlow__home__latest-news',
          array(
              'title' => esc_html__('Latest News', 'wlow' ),
              'priority' => 5,
              'panel' => 'wlow__home'
              )
          );
          $wp_customize->add_setting('wlow__home__latest-news__title', array('default' => esc_html__('News', 'wlow' ),'sanitize_callback' => 'sanitize_text_field'));
          $wp_customize->add_control('wlow__home__latest-news__title', array(
              'label' => esc_html__('Title', 'wlow' ),
              'section' => 'wlow__home__latest-news',
              'type' => 'text',
              )
          );

          $wp_customize->add_setting('wlow__home__latest-news__subtitle', array('default' => esc_html__('Our Latest News', 'wlow' ),'sanitize_callback' => 'sanitize_text_field'));
          $wp_customize->add_control('wlow__home__latest-news__subtitle', array(
              'label' => esc_html__('Subtitle', 'wlow' ),
              'section' => 'wlow__home__latest-news',
              'type' => 'text',
              )
          );

					$wp_customize->add_setting('wlow__home__latest-news__hide', array( 'default' => false,'sanitize_callback' => 'wlow_sanitize_checkbox'));
					$wp_customize->add_control('wlow__home__latest-news__hide', array(
							'label'     => esc_html__('Hide latest news section?', 'wlow' ),
							'section'   => 'wlow__home__latest-news',
							'type'      => 'checkbox'
						)
					);


} // end wlow_register_theme_customizer

add_action( 'customize_register', 'wlow_register_theme_customizer' );


/**
 * Sanitizes the incoming input and returns it prior to serialization.
 *
 * @param      string    $input    The string to sanitize
 * @return     string              The sanitized string
 * @package    fb
 * @since      0.5.0
 * @version    1.0.2
 */
function wlow_sanitize_image_url( $input ) {
	return esc_url_raw( $input  );
} // end wlow_sanitize_input

function wlow_sanitize_checkbox( $input ){
	return ( isset( $input ) && true == $input ? true : false );
}


/* Customizer script */
function wlow_registers() {

	wp_enqueue_script( 'wlow_customizer_script', get_template_directory_uri() . '/js/wlow-customizer.js', array("jquery"), '20120206', true  );

}
add_action( 'customize_controls_enqueue_scripts', 'wlow_registers' );

?>
