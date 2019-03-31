<?php
/**
 * Eight Sec functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Eight_Sec
 */

if ( ! function_exists( 'eight_sec_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function eight_sec_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Eight Sec, use a find and replace
	 * to change 'eight-sec' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'eight-sec', get_template_directory() . '/languages' );

	 /**
	 * Add callback for custom TinyMCE editor stylesheets. (editor-style.css)
	 * @see http://codex.wordpress.org/Function_Reference/add_editor_style
	 */
	add_editor_style();	

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );
	
	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
	add_image_size('eight-sec-team-image', 700, 540, true);
	add_image_size('eight-sec-testimoial-image', 700, 700, true);


	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'eight-sec' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'eight_sec_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	add_theme_support( 'custom-logo' , array(
	 	'header-text' => array( 'site-title', 'site-description' ),
	 	));	
	
	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	add_theme_support( 'starter-content', array(
		'widgets' => array(
			'sidebar-1' => array(
				'search',
			),

			'eight_sec_footer_one' => array(
				'text_about',
			),

			'eight_sec_footer_two' => array(
				'text_about',
			),

			'eight_sec_footer_three' => array(
				'text_about',
			),

			'eight_sec_footer_four' => array(
				'text_about',
			),
		),

		'posts' => array(
			'home'=>array(
				'template' => 'tpl-home.php',
				'post_type' => 'page',
				),
			'about' => array(
				'post_type'=>'page',
				),
		),

		'options' => array(
			'show_on_front' => 'page',
			'page_on_front' => '{{home}}',
		),

		'theme_mods' => array(
			'eight_sec_homepage_setting_slider_section_option' => 'yes',
			'eight_sec_homepage_setting_about_section_option' => 'yes',
			'eight_sec_homepage_setting_portfolio_section_option' => 'yes',
			'eight_sec_homepage_setting_team_section_option' => 'yes',
			'eight_sec_homepage_setting_cta_section_option' => 'yes',
			'eight_sec_homepage_setting_blog_section_option' => 'yes',
			'eight_sec_homepage_setting_testimonial_section_option' => 'yes',
			'eight_sec_homepage_setting_contact_section_option' => 'yes',
			'eight_sec_homepage_setting_slider_section_category' => 1,
			'eight_sec_homepage_setting_about_section_page' => '{{about}}',
		),

		'nav_menus' => array(
			'primary' => array(
				'name' => __( 'Primary Menu', 'eight-sec' ),
				'items' => array(
					'page_home',
					'page_about',
				),
			),
		),
	) );
}
endif;
add_action( 'after_setup_theme', 'eight_sec_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function eight_sec_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'eight_sec_content_width', 640 );
}
add_action( 'after_setup_theme', 'eight_sec_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function eight_sec_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'eight-sec' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'eight-sec' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );	
	register_sidebar( array(
		'name'          => esc_html__( 'Footer One', 'eight-sec' ),
		'id'            => 'eight_sec_footer_one',
		'description'   => esc_html__( 'Add widgets here.', 'eight-sec' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Two', 'eight-sec' ),
		'id'            => 'eight_sec_footer_two',
		'description'   => esc_html__( 'Add widgets here.', 'eight-sec' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Three', 'eight-sec' ),
		'id'            => 'eight_sec_footer_three',
		'description'   => esc_html__( 'Add widgets here.', 'eight-sec' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Four', 'eight-sec' ),
		'id'            => 'eight_sec_footer_four',
		'description'   => esc_html__( 'Add widgets here.', 'eight-sec' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

}
add_action( 'widgets_init', 'eight_sec_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function eight_sec_scripts() {
	$query_args = array( 
	    'family' => 'Open+Sans:400,300,300italic,400italic,600,600italic,700italic,700,800,800italic|Oswald:400,300,700|Raleway:400,300,300italic,400italic,500,500italic,600,600italic,700,700italic,800italic,800,900,900italic'
	);
	
	wp_enqueue_style( 'eight-sec-google-fonts', add_query_arg( $query_args, "//fonts.googleapis.com/css" ) );

	wp_enqueue_style( 'bxslider-css', get_template_directory_uri(). '/css/jquery.bxslider.css' );

	wp_enqueue_style( 'awesomse-font-css', get_template_directory_uri(). '/css/font-awesome.css' );

	wp_enqueue_style( 'animate-css', get_template_directory_uri(). '/css/animate.css' );

	wp_enqueue_style( 'isotope-css', get_template_directory_uri(). '/css/isotope-docs.css' );

	wp_enqueue_style( 'eight-sec-style', get_stylesheet_uri() );

	wp_enqueue_style( 'eight-sec-responsive-css', get_template_directory_uri(). '/css/responsive.css' );	

	wp_enqueue_script('bxslider-js',get_template_directory_uri().'/js/jquery.bxslider.js', array('jquery'), 'v4.1.2',true);

	wp_enqueue_script('smooth-scroll-js',get_template_directory_uri().'/js/smooth-scroll.js', array('jquery'), 'v9.1.2',true);
	
	wp_enqueue_script('wow-js',get_template_directory_uri().'/js/wow.js', array('jquery'), '1.1.2',true);

	wp_enqueue_script('isotope-js',get_template_directory_uri().'/js/isotope.pkgd.js', array('jquery'), 'v2.2.2',true);

	wp_enqueue_script( 'eight-sec-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'eight-sec-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	wp_enqueue_script('eight-sec-custom-js',get_template_directory_uri().'/js/custom.js', array('imagesloaded','jquery'), '',true);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'eight_sec_scripts' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Customizer Custom additions.
 */
require get_template_directory() . '/inc/admin-panel/eight-sec-customizer.php';

/**
 * Custom function additions.
 */
require get_template_directory() . '/inc/eight-sec-function.php';

require get_template_directory() . '/inc/admin-panel/theme-info.php';