<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Eight_Sec
 */

get_header(); ?>
<div class="ed-container">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<header class="page-header">
			<?php
				if ( is_single() ) {
					the_title( '<h1 class="page-title">', '</h1>' );
				} 
				do_action('eight_sec_breadcrumb');?>
				</header>

			<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', 'single' );

				the_post_navigation();

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->
	<div class="right-sidebar">
		<?php get_sidebar();?>
	</div>
</div>
<?php
get_footer();
?>
