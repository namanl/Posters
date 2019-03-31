<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Eight_Sec
 */

get_header(); ?>
<div class="ed-container">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'eight-sec' ); ?></h1>
					<?php do_action('eight_sec_breadcrumb');?>
				</header><!-- .page-header -->

				<div class="page-content">
					<p><?php esc_html_e( 'It looks like nothing was found at this location.', 'eight-sec' ); ?></p>
					<div class="error-404-text">
						<p><?php esc_html_e( 'error', 'eight-sec' ); ?></p>
						<h1><?php esc_html_e( '404', 'eight-sec' ); ?></h1>
					</div>
				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->
</div>

<?php
get_footer();
