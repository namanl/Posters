<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Eight_Sec
 */
get_header(); 
$cur_cat = get_query_var('cat');
$team_cat = get_theme_mod('eight_sec_homepage_setting_team_section_select');
$port_cat = get_theme_mod('eight_sec_homepage_setting_portfolio_section_select');
$blog_cat = get_theme_mod('eight_sec_homepage_setting_blog_section_select');
$blog_layout= get_theme_mod('eight_sec_blog_archive_setting_layout','blog_image_large');
?>
<div class="ed-container">
	<div id="primary" class="content-area <?php if(($cur_cat != $port_cat) && ($cur_cat != $team_cat)){echo esc_attr($blog_layout);} if($cur_cat == $team_cat){echo 'team-grid';}?>" >
		<main id="main" class="site-main" role="main">

		<?php 
		if ( have_posts() ) : ?>

			<header class="page-header">
				<div class="page-title">					
					<?php
						if ( is_category() ) :
								single_cat_title();

							elseif ( is_tag() ) :
								single_tag_title();

							elseif ( is_author() ) :
								printf( __( 'Author: %s', 'eight-sec' ), '<span class="vcard">' . get_the_author() . '</span>' );

							elseif ( is_day() ) :
								printf( __( 'Day: %s', 'eight-sec' ), '<span>' . get_the_date() . '</span>' );

							elseif ( is_month() ) :
								printf( __( 'Month: %s', 'eight-sec' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'eight-sec' ) ) . '</span>' );

							elseif ( is_year() ) :
								printf( __( 'Year: %s', 'eight-sec' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'eight-sec' ) ) . '</span>' );

							elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
								esch_html_e( 'Asides', 'eight-sec' );

							elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) :
								esch_html_e( 'Galleries', 'eight-sec' );

							elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
								esch_html_e( 'Images', 'eight-sec' );

							elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
								esch_html_e( 'Videos', 'eight-sec' );

							elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
								esch_html_e( 'Quotes', 'eight-sec' );

							elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
								esch_html_e( 'Links', 'eight-sec' );

							elseif ( is_tax( 'post_format', 'post-format-status' ) ) :
								esch_html_e( 'Statuses', 'eight-sec' );

							elseif ( is_tax( 'post_format', 'post-format-audio' ) ) :
								esch_html_e( 'Audios', 'eight-sec' );

							elseif ( is_tax( 'post_format', 'post-format-chat' ) ) :
								esch_html_e( 'Chats', 'eight-sec' );

							else :
								esch_html_e( 'Archives', 'eight-sec' );

							endif;
							
					?>
				</div>
				<?php do_action('eight_sec_breadcrumb');?>
			</header><!-- .page-header -->

			<?php
			if($cur_cat==$port_cat):
				get_template_part( 'template-parts/archive', 'portfolio' );

				
			else:
				/* Start the Loop */
				while ( have_posts() ) : the_post();

					/*
					 * Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
						if($cur_cat==$team_cat):
							get_template_part( 'template-parts/archive', 'team' );
				
						else:
							get_template_part( 'template-parts/content', get_post_format() );
						endif;
					
				endwhile;
			the_posts_navigation();
			endif;

			

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->
	<div class="right-sidebar">
	<?php get_sidebar();?>
	</div>
</div>
<?php

get_footer();
