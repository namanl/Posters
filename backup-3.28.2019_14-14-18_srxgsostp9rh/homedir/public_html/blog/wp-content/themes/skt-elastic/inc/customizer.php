<?php
/**
 * Event Planners Theme Customizer
 *
 * @package SKT Elastic
 */
function skt_elastic_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'skt_elastic_custom_header_args', array(
		'default-text-color'     => '949494',
		'width'                  => 1600,
		'height'                 => 200,
		'wp-head-callback'       => 'skt_elastic_header_style',
 		'default-text-color' => false,
 		'header-text' => false,
	) ) );
}
add_action( 'after_setup_theme', 'skt_elastic_custom_header_setup' );
if ( ! function_exists( 'skt_elastic_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see skt_elastic_custom_header_setup().
 */
function skt_elastic_header_style() {
	$header_text_color = get_header_textcolor();
	?>
	<style type="text/css">
	<?php
		//Check if user has defined any header image.
		if ( get_header_image() ) :
	?>
		.header {
			background: url(<?php echo esc_url(get_header_image()); ?>) no-repeat;
			background-position: center top;
		}
	<?php endif; ?>	
	</style>
	<?php
}
endif; // skt_elastic_header_style 
/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */ 
/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function skt_elastic_customize_register( $wp_customize ) {
	//Add a class for titles
    class skt_elastic_Info extends WP_Customize_Control {
        public $type = 'info';
        public $label = '';
        public function render_content() {
        ?>
			<h3 style="text-decoration: underline; color: #DA4141; text-transform: uppercase;"><?php echo esc_html( $this->label ); ?></h3>
        <?php
        }
    }
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->add_setting('color_scheme',array(
			'default'	=> '#000000',
			'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control(
		new WP_Customize_Color_Control($wp_customize,'color_scheme',array(
			'label' => esc_html__('Color Scheme','skt-elastic'),			
			 'description'	=> esc_html__('More color options in PRO Version','skt-elastic'),	
			'section' => 'colors',
			'settings' => 'color_scheme'
		))
	);
	// Slider Section		
	$wp_customize->add_section( 'slider_section', array(
            'title' => esc_html__('Slider Settings', 'skt-elastic'),
            'priority' => null,
            'description'	=> esc_html__('Featured Image Size Should be ( 1400 X 789 ) More slider settings available in PRO Version','skt-elastic'),		
        )
    );
	$wp_customize->add_setting('page-setting1',array(
			'default' => '0',
			'capability' => 'edit_theme_options',	
			'sanitize_callback'	=> 'skt_elastic_sanitize_integer'
	));
	$wp_customize->add_control('page-setting1',array(
			'type'	=> 'dropdown-pages',
			'label'	=> esc_html__('Select page for slide one:','skt-elastic'),
			'section'	=> 'slider_section'
	));	
	$wp_customize->add_setting('page-setting2',array(
			'default' => '0',
			'capability' => 'edit_theme_options',			
			'sanitize_callback'	=> 'skt_elastic_sanitize_integer'
	));
	$wp_customize->add_control('page-setting2',array(
			'type'	=> 'dropdown-pages',
			'label'	=> esc_html__('Select page for slide two:','skt-elastic'),
			'section'	=> 'slider_section'
	));	
	$wp_customize->add_setting('page-setting3',array(
			'default' => '0',
			'capability' => 'edit_theme_options',	
			'sanitize_callback'	=> 'skt_elastic_sanitize_integer'
	));
	$wp_customize->add_control('page-setting3',array(
			'type'	=> 'dropdown-pages',
			'label'	=> esc_html__('Select page for slide three:','skt-elastic'),
			'section'	=> 'slider_section'
	));	
	//Slider hide
	$wp_customize->add_setting('hide_slides',array(
			'sanitize_callback' => 'skt_elastic_sanitize_checkbox',
			'default' => true,
	));	 
	$wp_customize->add_control( 'hide_slides', array(
    	   'section'   => 'slider_section',    	 
		   'label'	=> esc_html__('Uncheck To Show Slider','skt-elastic'),
    	   'type'      => 'checkbox'
     )); // Slider Section		 
	 
	$wp_customize->add_section('footer_main',array(
			'title'	=> esc_html__('Footer Area','skt-elastic'),
			'description'	=> esc_html__('Manager Footer From Widgets >> Footer Column 1, Footer Column 2, Footer Column 3','skt-elastic'),			
			'priority'	=> null,
	));	
	
    $wp_customize->add_setting('skt_elastic_options[footer-info]', array(
            'type' => 'info_control',
            'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
        )
    );
    $wp_customize->add_control( new skt_elastic_Info( $wp_customize, 'footer_main', array(
        'section' => 'footer_main',
        'settings' => 'skt_elastic_options[footer-info]',
        'priority' => null
        ) )
    );  	
	
}
add_action( 'customize_register', 'skt_elastic_customize_register' );
//Integer
function skt_elastic_sanitize_integer( $input ) {
    if( is_numeric( $input ) ) {
        return intval( $input );
    }
}
function skt_elastic_sanitize_checkbox( $checked ) {
	// Boolean check.
	return ( ( isset( $checked ) && true == $checked ) ? true : false );
}

//setting inline css.
function skt_elastic_custom_css() {
    wp_enqueue_style(
        'skt-elastic-custom-style',
        get_template_directory_uri() . '/css/skt-elastic-custom-style.css'
    );
        $color = get_theme_mod( 'color_scheme' ); //E.g. #e64d43
		$header_text_color = get_header_textcolor();
        $custom_css = "
					#sidebar ul li a:hover,				
					.phone-no strong,					
					.left a:hover,
					.blog_lists h4 a:hover,
					.recent-post h6 a:hover,
					.recent-post a:hover,
					.design-by a,
					.site-description,
					.logo h2 span,
					.fancy-title h2 span,
					.postmeta a:hover,
					.recent-post .morebtn:hover, .sitenav ul li a:hover, .sitenav ul li.current_page_item a, .sitenav ul li.menu-item-has-children.hover, .sitenav ul li.current-menu-parent a.parent, .left-fitbox a:hover h3, .right-fitbox a:hover h3, .tagcloud a, .cols-3 ul li a:hover
					{ 
						 color: {$color} !important;
					}
					.pagination .nav-links span.current, .pagination .nav-links a:hover,
					#commentform input#submit:hover,
					.nivo-controlNav a.active,								
					.wpcf7 input[type='submit'],
					a.ReadMore,
					.section2button,
					input.search-submit
					{ 
					   background-color: {$color} !important;
					}
					.titleborder span:after{border-bottom-color: {$color} !important;}
				";
        wp_add_inline_style( 'skt-elastic-custom-style', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'skt_elastic_custom_css' );          
/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function skt_elastic_customize_preview_js() {
	wp_enqueue_script( 'skt_elastic_customizer', get_template_directory_uri() . '/js/customize-preview.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'skt_elastic_customize_preview_js' );