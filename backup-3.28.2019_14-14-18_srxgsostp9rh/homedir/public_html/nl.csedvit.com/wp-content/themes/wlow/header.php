<?php
/**
 * Header template for our theme
 *
 * Displays all of the <head> section and everything up till <div class="container">.
 *
 * @since wlow
 */
?><!DOCTYPE html>
<html <?php language_attributes();?>>
<head>

  <meta charset="<?php bloginfo( 'charset' ); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?php bloginfo( 'description' ); ?>" />

	<!-- Meta for IE support -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

	<?php wp_head(); ?>

</head>
<body <?php body_class(); ?> data-spy="scroll" data-target="#mainmenu">

    <header class="navbar navbar-fixed-top animate">
    	<div class="container">

  			<div class="navbar-header">
  				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse-side" data-target=".side-collapse" data-target-2=".side-collapse-container">
  					<span class="icon-bar animate"></span>
  					<span class="icon-bar animate"></span>
  					<span class="icon-bar animate"></span>
  				</button>
  				<a class="navbar-brand animate" href="<?php echo esc_url_raw(home_url()); ?>"> <?php bloginfo('name'); ?> </a>
  			</div>

        <div class="side-collapse in animate">
          <div class="top-bar clearfix animate">
            <?php /* Top Bar Navigation */
    					wp_nav_menu( array(
    					  'theme_location' => 'top-bar',
    					  'depth' => 1,
    					  'container' => false,
    					  'menu_class' => '',
    					  'fallback_cb'     => 'wlow_top_bar_menu_cb',
                )
    					);
    				?>
				  </div>
          <nav id="mainmenu" role="navigation" class="navbar-collapse">
    			 	<?php /* Main Navigation */
    					wp_nav_menu( array(
    					  'theme_location' => 'header',
    					  'depth' => 2,
    					  'container' => false,
    					  'menu_class' => 'nav navbar-nav navbar-right',
    					  'fallback_cb'       => 'wlow_wp_bootstrap_navwalker::fallback',
    					  //Process nav menu using our custom nav walker
    					  'walker' => new wlow_wp_bootstrap_navwalker())
    					);
    				?>
    			</nav><!--/.nav-collapse -->
        </div>

    	</div>
    </header>

<!-- container for slide effect -->
<div class="side-collapse-container">
  <!-- content for slide effect -->
  <div class="side-collapse-content animate">

    <?php if (is_page_template( 'page-templates/home.php' )) { ?>

  		<!-- seo title home -->
  		<h1 class="home-title"><?php bloginfo('name'); ?> -  <?php bloginfo('description'); ?></h1>

  	<?php } else { ?>

  		<div class="spacer"></div>

  	<?php } ?>

	<?php if (!is_page_template( 'page-templates/home.php' )) {  ?>

	<div class="container">

		<div class="row">

	<?php } ?>
