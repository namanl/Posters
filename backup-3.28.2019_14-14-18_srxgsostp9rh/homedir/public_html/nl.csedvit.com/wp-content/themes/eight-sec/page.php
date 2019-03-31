<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Eight_Sec
 */
get_header();

 ?>
<div class="ed-container">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<header class="page-header">
				<?php the_title( '<h1 class="page-title">', '</h1>' ); ?>
				<?php do_action('eight_sec_breadcrumb');?>
			</header>
			<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', 'page' );

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
