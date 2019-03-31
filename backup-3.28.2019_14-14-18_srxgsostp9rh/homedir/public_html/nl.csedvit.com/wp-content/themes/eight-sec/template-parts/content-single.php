<?php
/**
 * @package Eight_Sec
 */
?>


<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content">
		<?php        
		if( has_post_thumbnail() ) : 
			the_post_thumbnail();
		endif;
		?>
		<?php the_content(); ?>
		<?php
		wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'eight-sec' ),
			'after'  => '</div>',
			) );
			?>
		</div><!-- .entry-content -->

		<footer class="entry-footer">
			<?php eight_sec_posted_on(); ?>
			<?php eight_sec_entry_footer(); ?>
		</footer><!-- .entry-footer -->
</article><!-- #post-## -->