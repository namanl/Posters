<?php 
$readmore = get_theme_mod('eight_sec_blog_archive_setting_readmore',__('Read More','eight-sec'));
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
	<?php the_title( sprintf( '<h4 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );?>
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
		<div class="team-content">
			<p><?php the_excerpt();?></p>
		</div>
		<div class="ed-readmore">
          	<a href="<?php the_permalink(); ?>"><?php echo esc_html($readmore);?></a>
        </div>
	</div><!-- .entry-content -->

</article><!-- #post-## -->
