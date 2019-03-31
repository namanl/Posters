<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Eight_Sec
 */
$blog_layout= get_theme_mod('eight_sec_blog_archive_setting_layout','blog_image_large');
$readmore = get_theme_mod('eight_sec_blog_archive_setting_readmore',__('Read More','eight-sec'));
switch ($blog_layout) {
	case 'blog_image_large':
		$img_size = 'full';
		break;
	
	default:
		$img_size = 'eight-sec-testimoial-image';
		break;
}
if(is_archive()):
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( sprintf( '<h4 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );?> 
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
		if(has_post_thumbnail()){
			$img_src = wp_get_attachment_image_src(get_post_thumbnail_id(),$img_size);
			$img_link = esc_url($img_src[0]);
		?>
			<figure class="entry-image">
				<img src= "<?php echo $img_link;?>" alt="<?php the_title_attribute();?>" title="<?php echo esc_attr(get_the_title());?>" />
			</figure>
		<?php
		}?>
		<div class="archive-content">
			<p><?php the_excerpt();?></p>
			<div class="ed-readmore">
          		<a href="<?php the_permalink(); ?>"><?php esc_html_e('Read More','eight-sec');?></a>
        	</div>
		</div>
		<footer class="entry-footer">
			<?php eight_sec_posted_on(); ?>
			<?php eight_sec_entry_footer(); ?>
		</footer><!-- .entry-footer -->			 
		
	</div><!-- .entry-content -->

</article><!-- #post-## -->
<?php 
else:
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
		<?php
			the_title( '<h4 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h4>' );			
		?>
	</header><!-- .entry-header -->
		<div class="entry-content">
			<?php
			if(has_post_thumbnail()){
				$img_src = wp_get_attachment_image_src(get_post_thumbnail_id(),'full');
				$img_link = esc_url($img_src[0]);
			?>
				<figure class="entry-image">
					<img src= "<?php echo $img_link;?>" alt="<?php the_title_attribute();?>" title="<?php echo esc_attr(get_the_title());?>" />
				</figure>
			<?php
			}
			?>
			<?php the_content( sprintf(
				/* translators: %s: Name of current post. */
				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'eight-sec' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'eight-sec' ),
				'after'  => '</div>',
			) );?>
			<footer class="entry-footer">
				<?php if ( 'post' === get_post_type() ) : ?>					
					<?php eight_sec_posted_on(); ?>
					<?php eight_sec_entry_footer(); ?>				
				<?php
				endif; ?>
				
			</footer><!-- .entry-footer -->			 
			
		</div><!-- .entry-content -->

	</article><!-- #post-## -->
<?php 
endif;
?>