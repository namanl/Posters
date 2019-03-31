<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div class="container">
 *
 * @package SKT Elastic
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div class="header">
  <div class="container">
    <div class="logo">
		<?php the_custom_logo(); ?>
        <div class="clear"></div>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
        <h2><?php bloginfo('name'); ?></h2>
        <p><?php bloginfo( 'description' ); ?></p>                          
        </a>
    </div>
         <div class="toggle"><a class="toggleMenu" href="#" style="display:none;"><?php esc_html_e('Menu','skt-elastic'); ?></a></div> 
        <div class="sitenav">
          <?php wp_nav_menu( array('theme_location' => 'primary') ); ?>         
        </div><!-- .sitenav--> 
        <div class="clear"></div> 
  </div> <!-- container -->
</div><!--.header -->