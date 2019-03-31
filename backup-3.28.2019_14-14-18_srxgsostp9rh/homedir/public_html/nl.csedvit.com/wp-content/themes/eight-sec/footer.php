<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Eight_Sec
 */

?>

</div><!-- #content -->

<footer id="colophon" class="site-footer" role="contentinfo">
	<?php if(is_active_sidebar('eight_sec_footer_one') || is_active_sidebar('eight_sec_footer_two') || is_active_sidebar('eight_sec_footer_three') || is_active_sidebar('eight_sec_footer_four')):?>
		<div class="top-footer wow fadeInUp" data-wow-duration="2s">
			<div class="ed-container">
				<div class="footer-wrap clear">
					<?php
					if(is_active_sidebar('eight_sec_footer_one')){
						?>
						<div class="footer-block">
							<?php dynamic_sidebar('eight_sec_footer_one'); ?>
						</div>
						<?php
					}
					?>	        	
					<?php
					if(is_active_sidebar('eight_sec_footer_two')){
						?>
						<div class="footer-block">
							<?php dynamic_sidebar('eight_sec_footer_two'); ?>
						</div>
						<?php
					}
					?>	        	
					<?php
					if(is_active_sidebar('eight_sec_footer_three')){
						?>	
						<div class="footer-block">
							<?php dynamic_sidebar('eight_sec_footer_three'); ?>
						</div>
						<?php
					}
					?>	        	
					<?php
					if(is_active_sidebar('eight_sec_footer_four')){
						?>	
						<div class="footer-block">
							<?php dynamic_sidebar('eight_sec_footer_four'); ?>
						</div>
						<?php
					}
					?>	
				</div>
			</div>
		</div>
	<?php endif;?>
	<div class="site-info wow fadeInUp" data-wow-duration="2s">
		<div class="copyright">
			<?php
			$copyright = get_theme_mod('eight_sec_footer_setting_footer_copyright_text');			?>
			<span>
			<?php
			if($copyright && $copyright!=""){
				echo wp_kses_post($copyright);
			}
			?>
			</span>
			<?php
		?>
		<?php _e( 'WordPress Theme : ', 'eight-sec' );  ?><a  title="<?php echo __('Free WordPress Theme','eight-sec');?>" href="<?php echo esc_url( __( 'https://8degreethemes.com/wordpress-themes/eight-sec/', 'eight-sec' ) ); ?>"><?php _e( 'Eight Sec', 'eight-sec' ); ?> </a>
		<span><?php echo __(' by 8Degree Themes','eight-sec');?></span>
		</div>
		<?php 
		if(get_theme_mod('eight_sec_social_setting_option_footer','disable')=='enable'):
			?>
		<div class="ed-social-icon">
			<?php		
			do_action('eight_sec_social');
			?>
		</div>
		<?php 
		endif;
		?>
	</div><!-- .site-info -->
</footer><!-- #colophon -->
</div><!-- #page -->
<a href="#" id="go-to-top" title='<?php _e("Go to top","eight-sec");?>'>&#8679;</a>
<?php wp_footer(); ?>

</body>
</html>
