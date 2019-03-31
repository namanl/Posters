<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Eight_Sec
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'eight-sec' ); ?></a>
	<?php 
            
        $ed_logo_alignment = '';
        $ed_nav_alignment = '';
        $ed_nav = get_theme_mod('eight_sec_header_setting_logo_alignment','left');
        if($ed_nav=='left'){
            $ed_logo_alignment = 'logo-left';
            $ed_nav_alignment = 'menu-right';
        }
        elseif($ed_nav=='right'){
            $ed_logo_alignment = 'logo-right';
            $ed_nav_alignment = 'menu-left';
        }
        else{
            $ed_logo_alignment = 'logo-center';
            $ed_nav_alignment = 'menu-center';
        }
       
    ?>
	<header id="masthead" class="site-header <?php echo $ed_logo_alignment; ?>" role="banner">
		<div class="site-branding">
			<?php if(function_exists('the_custom_logo')):?>
				<div class="site-logo">
					<?php if ( has_custom_logo() ) : ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
							<?php the_custom_logo(); ?>
						</a>
					<?php endif; // End logo check. ?>
				</div>
			<?php endif;?>
			<div class="site-text">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<h1 class="site-title"><?php bloginfo( 'name' ); ?></h1>
					<p class="site-description"><?php bloginfo( 'description' ); ?></p>
				</a>
			</div>
		</div><!-- .site-branding -->
		
		
		<nav id="site-navigation" class="main-navigation <?php echo $ed_nav_alignment;?>" role="navigation">
			<div class="toggle-btn">
				<span class="toggle-bar toggle-bar1"></span>
				<span class="toggle-bar toggle-bar2"></span>
				<span class="toggle-bar toggle-bar3"></span>
			</div>
			<?php 
				if(get_theme_mod('eight_sec_header_setting_menu_section_option',0)):?>
				  	<ul class="nav plx_nav menu">
	                    <span class="siteurl" url="<?php echo esc_url(home_url('/')); ?>" style="display: none;"></span>
				  		<li class="eight_sec_menu menu-item" id="eight_sec_slider"><a data-scroll data-options='{ "speed: 500,easing": "easeInQuad" }' href="<?php echo esc_url(home_url('/')); ?>#slider"><?php _e('HOME','eight-sec');?></a></li>
				  		<?php 
				  		$enabled_sections = eight_sec_menu();
				  		if($enabled_sections != ''):
				  			foreach ($enabled_sections as $enabled_section) {
					  			if($enabled_section['menu_text'] != '') : ?>
		                            <li class="eight_sec_menu menu-item" id="eight_sec_menu_<?php echo $enabled_section['section'] ?>"><a class='<?php echo $enabled_section['id'];?>' data-scroll data-options='{ "easing": "easeInQuad" }' href="<?php echo esc_url(home_url('/')); ?>#<?php echo eight_sec_hyphenize($enabled_section['menu_text']);?>" ><?php echo $enabled_section['menu_text']; ?></a></li>
	                            <?php endif; ?>
						<?php
							}
						endif;
						?>
				  	</ul>		
			<?php							
				else:
		?>
					<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
		<?php  
				endif;
		?>
		</nav><!-- #site-navigation -->
		<?php 
        if( get_theme_mod( 'eight_sec_header_setting_search_options', 0 ) == 1 ){  
        ?>
        	<div class="ed-search-wrap">                                   
            	<?php get_search_form();?>
			</div>
		<?php
		}
        ?>
        <div class="header-sticky-overlay"></div>
	</header><!-- #masthead -->

	<div id="content" class="site-content">
