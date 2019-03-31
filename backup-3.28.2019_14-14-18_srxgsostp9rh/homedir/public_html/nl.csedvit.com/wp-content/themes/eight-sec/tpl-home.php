<?php
/**
* Template Name: Homepage
* 
* @package Eight_Sec
*
*/ 
get_header();

// starting of slider section
if(get_theme_mod('eight_sec_homepage_setting_slider_section_option','no') == 'yes'):
	$slider_cat	=	esc_attr(get_theme_mod('eight_sec_homepage_setting_slider_section_category',''));
	$slider_readmore = esc_html(get_theme_mod('eight_sec_homepage_setting_slider_section_readmore',__('Get Started','eight-sec')));
	$eight_sec_show_pager = (get_theme_mod('eight_sec_homepage_setting_slider_section_pager','no') == "yes") ? "true" : "false";
	$eight_sec_show_controls = (get_theme_mod('eight_sec_homepage_setting_slider_section_control','no') == "yes") ? "true" : "false";
	if(!empty($slider_cat) || $slider_cat!= 0):
		$args = array('post_type' => 'post', 'posts_per_page' => 5, 'cat' => $slider_cat);

		$args_query = new WP_Query($args);	
		if ($args_query->have_posts()) :		
			?>
			<script type="text/javascript">
				jQuery(function($){
					$('.main-slider').bxSlider({
								pager: <?php echo esc_attr($eight_sec_show_pager); ?>,
								controls: <?php echo esc_attr($eight_sec_show_controls); ?>,
								mode: 'fade',
								auto : true
							});
				});
			</script>
			<section id="slider" class="eight_sec_plx_slider_section section">
				<ul class="main-slider">
					<?php
					while ($args_query->have_posts()):
						$args_query->the_post();
						$img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
						$img_link = $img[0];
					?>
					<li class="slide" style="background: url('<?php echo esc_url($img_link);?>') center no-repeat;">
						<div class="slide-caption">
							<div class="ed-container">
								<h2 class="caption-title"><?php the_title();?></h2>
								<div class="slide-content">
									<div class="slide-desc"><?php the_excerpt();?></div>
									<?php
									if(!empty($slider_readmore)){
									?>
										<a href="<?php the_permalink();?>" class="slide-readmore bttn"><?php echo $slider_readmore;?></a>
									<?php
										}
									?>
								</div>
							</div>
						</div>

					</li>
					<?php
					endwhile;
					wp_reset_postdata();
					?>

				</ul>

			</section>


		<?php 
		endif;
	endif;
endif;

?>
<!-- end of slider section -->

<!-- about section -->
<?php 
if(get_theme_mod('eight_sec_homepage_setting_about_section_option','no') == 'yes'):
	$about_page	=	esc_attr(get_theme_mod('eight_sec_homepage_setting_about_section_page',''));
	$about_cat	=	esc_attr(get_theme_mod('eight_sec_homepage_setting_about_section_select',''));
	$about_menu	=	esc_attr(get_theme_mod('eight_sec_homepage_setting_about_section_menu_title_text',__('ABOUT US','eight-sec')));
	if( (!empty($about_page) && ($about_page != 0)) || !empty($about_cat) ):
		$page_data = get_post($about_page);
	?>
		<section id="<?php echo eight_sec_hyphenize($about_menu);?>" class="eight_sec_plx_about_section section">				
			<div class="ed-container">
				<?php 
				if( !empty($about_page) && ($about_page != 0) ):?>
					<div class="section-title">
						<h2 class="about-sec wow fadeIn" data-wow-duration="2s"><?php echo $page_data->post_title;?></h2>
					</div>
					<div class="about-description wow fadeInDown" data-wow-duration="2s">
						<?php echo apply_filters( 'the_content', get_post_field('post_content', $page_data->ID) );?>
					</div>
				<?php 
				endif;
				if(!empty($about_cat) || $about_cat != 0):
					$args = array('post_type' => 'post', 'cat' => $about_cat, 'posts_per_page' => 4);
					$args_query =	new WP_Query($args);?>
					<div class="about-service clear wow fadeInUp" data-wow-duration="2s">
						<?php 
						while ($args_query->have_posts()) :
							$args_query->the_post(); 
						?>					
						<div class="section-content">
							<?php if(has_post_thumbnail()):
							$img_src  = wp_get_attachment_image_src(get_post_thumbnail_id(), 'medium');
							$img_link = $img_src[0];
							?>
							<div class="about-image">
								<img src="<?php echo esc_url($img_link);?>" alt='<?php the_title_attribute();?>'/> 
							</div>
							<?php
							endif;
							?>
							<div class="about-content-wrap">
								<h2 class="about-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
								<div class="about-content"><?php the_excerpt();?></div>
							</div>
						</div>	
						<?php
						endwhile;
						wp_reset_postdata();
						?>
					</div>
					<?php 					
				endif;
				?>
			</div>
		</section>

	<?php 
	endif;
endif;


?>
<!-- end of about section -->

<!-- portfolio section -->
<?php 
if(get_theme_mod('eight_sec_homepage_setting_portfolio_section_option','no') == 'yes'):
	$portfolio_page	=	esc_attr(get_theme_mod('eight_sec_homepage_setting_portfolio_section_page',''));
	$portfolio_cat	=	esc_attr(get_theme_mod('eight_sec_homepage_setting_portfolio_section_select',''));
	$portfolio_menu	=	esc_attr(get_theme_mod('eight_sec_homepage_setting_portfolio_section_menu_title_text',__('PORTFOLIO','eight-sec')));
	$portfolio_viewall = esc_html(get_theme_mod('eight_sec_homepage_setting_portfolio_section_viewall',__('View all','eight-sec')));
		if( (!empty($portfolio_page) && ($portfolio_page != 0)) || !empty($portfolio_cat)):
		$portfolio_data = get_post($portfolio_page);	
			?>
			<section id="<?php echo eight_sec_hyphenize($portfolio_menu);?>" class="eight_sec_plx_portfolio_section section">
				<div class="ed-container">
					<?php 		
					if( !empty($portfolio_page)  && ($portfolio_page != 0) ):?>
						<div class="section-title">
							<h2 class="portfolio-sec wow fadeIn" data-wow-duration="6s"><?php echo $portfolio_data->post_title;?></h2>
						</div>					
						<?php 
						if(!empty($portfolio_viewall)):?>
							<a class="portfolio-viewall bttn" href="<?php echo esc_url(get_category_link($portfolio_cat)); ?>"><?php echo $portfolio_viewall; ?></a>
						<?php endif;?>
						<div class="portfolio-description wow fadeInDown" data-wow-duration="2s" >
						<?php echo apply_filters( 'the_content', get_post_field('post_content', $portfolio_data->ID) );?></div>
					<?php 					
					endif;
					if(!empty($portfolio_cat) || $portfolio_cat != 0):
						$args = array('post_type' => 'post', 'posts_per_page' => 6, 'cat' => $portfolio_cat);
						$args_query = new WP_Query($args);	
						if ($args_query->have_posts()) :?>
							<div class="portfolio-wrap clear wow fadeInUp" data-wow-duration="2s">
								<?php
								while($args_query->have_posts()):
									$args_query->the_post();
									$img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
									$img_link = $img[0];

								?>
								<div class="portfolio-content-img">
									<?php
									if(has_post_thumbnail()):
										?>
										<div class="portfolio-image">
											<img src="<?php echo esc_url($img_link);?>" alt = '<?php the_title_attribute();?>' />
										</div>
										<div class="portfolio-content-wrap">
											<h4 class="portfolio-title">
												<a href="<?php the_permalink();?>">
													<?php the_title();?>
												</a>
											</h4>
											<div class="portfolio-content">
												<?php the_excerpt();?>
											</div>
										</div>
									<?php
									endif;
									?>
								</div>
								
								<?php
								endwhile;
								wp_reset_postdata();
								?>
							</div>
						<?php 
						endif;
					endif;
				?>
				</div>
			</section>
		<?php 
		endif;
endif;?>
<!-- end of portfolio section -->

<!-- team section -->
<?php 
if(get_theme_mod('eight_sec_homepage_setting_team_section_option','no') == 'yes'):
	$team_page	=	esc_attr(get_theme_mod('eight_sec_homepage_setting_team_section_page',''));
	$team_menu	=	esc_attr(get_theme_mod('eight_sec_homepage_setting_team_section_menu_title_text',esc_html__('TEAM','eight-sec')));
	$team_cat	=	esc_attr(get_theme_mod('eight_sec_homepage_setting_team_section_select'));
	$team_viewall = esc_attr(get_theme_mod('eight_sec_homepage_setting_team_section_viewall',esc_html__('View all','eight-sec')));
	if((!empty($team_page) && ($team_page != 0)) || !empty($team_cat)):
		$team_data = get_post($team_page);		
	?>
			<section id="<?php echo eight_sec_hyphenize($team_menu);?>" class="eight_sec_plx_team_section section">
				<div class="ed-container">
					<?php					
					if( !empty($team_page) && ($team_page != 0) ):?>
						<div class="section-title">
							<h2 class="team-sec wow fadeIn" data-wow-duration="6s"><?php echo $team_data->post_title;?></h2>
						</div>
						<?php if(!empty($team_viewall)):?>
							<a class="team-viewall bttn" href="<?php echo esc_url(get_category_link($team_cat)); ?>"><?php echo $team_viewall; ?></a>
						<?php endif;?>
						<div class="team-description wow fadeInDown" data-wow-duration="2s" >
						<?php echo apply_filters( 'the_content', get_post_field('post_content', $team_data->ID) );?></div>
					<?php
					endif;
					if(!empty($team_cat) || $team_cat != 0):
						$args = array('post_type' => 'post', 'posts_per_page' => 3, 'cat' => $team_cat);
						$args_query = new WP_Query($args);	
						if ($args_query->have_posts()) :		
					?>
							<div class="team-wrap clear wow fadeInUp" data-wow-duration="2s">
								<?php
								while($args_query->have_posts()):
									$args_query->the_post();
									$img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'eight-sec-team-image');
									$img_link = esc_url($img[0]);

								?>
								<div class="team-content-img">
									<a href="<?php the_permalink();?>">						
										<?php
										if(has_post_thumbnail()):
											?>
										<div class="team-image">
											<img src="<?php echo $img_link;?>" alt = '<?php the_title_attribute();?>' />
										</div>
										<?php
										endif;
										?>
									</a>	
									<div class="team-content-wrap">
										<h4 class="team-title">
											<a href="<?php the_permalink();?>">
												<?php the_title();?>
											</a>
										</h4>
										<div class="team-content">
											<?php the_excerpt();?>
										</div>
									</div>
								</div>
								<?php
								endwhile;
								wp_reset_postdata();
								?>
							</div>
						<?php 
						endif;
					endif;
				?>
				</div>
			</section>

		<?php 
	endif;
endif;?>
<!-- end of team section -->

<!-- cta section -->
<?php 
if(get_theme_mod('eight_sec_homepage_setting_cta_section_option','no') == 'yes'):
	$cta_menu	=	esc_attr(get_theme_mod('eight_sec_homepage_setting_cta_section_menu_title_text',esc_html__('CTA','eight-sec')));
	$cta_page	=	esc_attr(get_theme_mod('eight_sec_homepage_setting_cta_section_page',''));
	$cta_button_link = esc_url(get_theme_mod('eight_sec_homepage_setting_cta_section_button_link','#'));
	$cta_button_text = esc_html(get_theme_mod('eight_sec_homepage_setting_cta_section_button_text'),esc_html__('Hire us','eight-sec'));
	if((!empty($cta_page) && ($cta_page != 0)) || $cta_page != 0):
		$cta_data = get_post($cta_page);		
	?>
		<section id="<?php echo eight_sec_hyphenize($cta_menu);?>" class="eight_sec_plx_cta_section section">
			<div class="ed-container">
				<div class="section-title">
					<h2 class="cta-sec wow fadeIn" data-wow-duration="6s"><?php echo $cta_data->post_title;?></h2>
				</div>
				<div class="cta-description wow fadeInDown" data-wow-duration="2s" >
						<?php echo apply_filters( 'the_content', get_post_field('post_content', $cta_data->ID) );?></div>
				<?php if(!empty($cta_button_text)):?>
					<a href="<?php echo $cta_button_link;?>" class="bttn cta-readmore wow fadeInUp" data-wow-duration="2s"><?php echo $cta_button_text;?></a>	
				<?php endif;?>
			</div>
		</section>

	<?php 
	endif;
endif;?>
<!-- end of cta section -->

<!-- blog section -->
<?php 
if(get_theme_mod('eight_sec_homepage_setting_blog_section_option','no') == 'yes'):
	$blog_menu	=	esc_attr(get_theme_mod('eight_sec_homepage_setting_blog_section_menu_title_text',esc_html__('BLOG','eight-sec')));
	$blog_page	=	esc_attr(get_theme_mod('eight_sec_homepage_setting_blog_section_page',''));
	$blog_cat	=	esc_attr(get_theme_mod('eight_sec_homepage_setting_blog_section_select'));
	$blog_viewall = esc_html(get_theme_mod('eight_sec_homepage_setting_blog_section_viewall',esc_html__('View all','eight-sec')));
	if((!empty($blog_page) && ($blog_page != 0)) || !empty($blog_cat)):
		$blog_data = get_post($blog_page);		
			?>
			<section id="<?php echo eight_sec_hyphenize($blog_menu);?>" class="eight_sec_plx_blog_section section">
				<div class="ed-container">
					<?php 
					if(!empty($blog_page) && ($blog_page != 0)):?>
						<div class="section-title">
							<h2 class="blog-sec wow fadeIn" data-wow-duration="6s"><?php echo $blog_data->post_title;?></h2>
						</div>	
						<?php if(!empty($blog_viewall)):?>
							<a class="blog-viewall bttn" href="<?php echo esc_url(get_category_link($blog_cat)); ?>"><?php echo $blog_viewall; ?></a>
						<?php endif;?>
						<div class="blog-description wow fadeInDown" data-wow-duration="2s" >
						<?php echo apply_filters( 'the_content', get_post_field('post_content', $blog_data->ID) );?></div>
					<?php		
					endif;			
					if(!empty($blog_cat) || $blog_cat != 0):
						$args = array('post_type' => 'post', 'posts_per_page' => 3, 'cat' => $blog_cat);
						$args_query = new WP_Query($args);	
						if ($args_query->have_posts()) :		
							?>
						<div class="blog-wrap clear wow fadeInUp" data-wow-duration="2s">
							<?php
							while($args_query->have_posts()):
								$args_query->the_post();
							$img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
							$img_link = esc_url($img[0]);

							?>
							<div class="blog-content-img">
								<a href="<?php the_permalink();?>">						
									<?php
									if(has_post_thumbnail()):
										?>
									<div class="blog-image">
										<img src="<?php echo $img_link;?>" alt = '<?php the_title_attribute();?>' />
									</div>
									<?php
									endif;
									?>
								</a>	
								<div class="blog-content-wrap">
									<h4 class="blog-title">
										<a href="<?php the_permalink();?>">
											<?php the_title();?>
										</a>
									</h4>
									<div class="blog-content">
										<?php the_excerpt();?>
									</div>
									<div class="blog-footer">
										<div class='blog-footer-left'><a href="<?php echo esc_url( home_url( '/'.get_the_date('Y/m/d') ) );?>"><?php echo get_the_date();?></a></div>
										<div class="blog-footer-right"><?php comments_popup_link();?></div>
									</div>
								</div>
							</div>
							<?php
							endwhile;
							wp_reset_postdata();
							?>
						</div>
						<?php 
					endif;
				endif;?>
				</div>
			</section>

		<?php 
	endif;
endif;?>
<!-- end of blog section -->

<!-- testimonial section -->
<?php 
if(get_theme_mod('eight_sec_homepage_setting_testimonial_section_option','no') == 'yes'):
	$testimonial_menu	=	esc_attr(get_theme_mod('eight_sec_homepage_setting_testimonial_section_menu_title_text',esc_html__('TESTIMONIAL','eight-sec')));
	$testimonial_page	=	esc_attr(get_theme_mod('eight_sec_homepage_setting_testimonial_section_page',''));
	$testimonial_cat	=	esc_attr(get_theme_mod('eight_sec_homepage_setting_testimonial_section_select'));
	if((!empty($testimonial_page) && ($testimonial_page != 0) ) || !empty($testimonial_cat)):
	$testimonial_data = get_post($testimonial_page);	
		?>
			<section id="<?php echo eight_sec_hyphenize($testimonial_menu);?>" class="eight_sec_plx_testimonial_section section">
				<div class="ed-container">
					<?php 
					if(!empty($testimonial_page) && ($testimonial_page != 0) ):?>
						<div class="section-title">
							<h2 class="testimonial-sec wow fadeIn" data-wow-duration="6s"><?php echo $testimonial_data->post_title;?></h2>
						</div>
						<div class="testimonial-description wow fadeInDown" data-wow-duration="2s" >
						<?php echo apply_filters( 'the_content', get_post_field('post_content', $testimonial_data->ID) );?></div>						
					<?php 					
					endif;
					$args = array('post_type' => 'post', 'posts_per_page' => 4, 'cat' => $testimonial_cat);
					if(!empty($testimonial_cat) || $testimonial_cat != 0):
						$args_query = new WP_Query($args);	
						if ($args_query->have_posts()) :		
						?>
							<ul class="testimonial-slider wow fadeInUp" data-wow-duration="2s">
								<?php
								while($args_query->have_posts()):
									$args_query->the_post();
								$img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'eight-sec-testimoial-image');
								$img_link = esc_url($img[0]);

								?>
								<li class="slide">
									<a href="<?php the_permalink();?>">						
										<?php
										if(has_post_thumbnail()):
											?>
										<div class="testimonial-image">
											<img src="<?php echo $img_link;?>" alt = '<?php the_title_attribute();?>' />
										</div>
										<?php
										endif;
										?>
									</a>						
									<div class="testimonial-content">
										<?php the_excerpt();?>
									</div>
									<h4 class="testimonial-title">
										<a href="<?php the_permalink();?>">
											<?php the_title();?>
										</a>
									</h4> 
								</li>
								<?php
								endwhile;
								wp_reset_postdata();
								?>
							</ul>
							<?php 
						endif;
					endif;?>

				</div>
			</section>

		<?php 
	endif;
endif;?>
<!-- end of testimonial section -->

<!-- contact section -->
<?php 
if(get_theme_mod('eight_sec_homepage_setting_contact_section_option','no') == 'yes'):
	$contact_menu	=	esc_attr(get_theme_mod('eight_sec_homepage_setting_contact_section_menu_title_text',esc_html__('CONTACT US','eight-sec')));
	$contact_page	=	esc_attr(get_theme_mod('eight_sec_homepage_setting_contact_section_page',''));
	$contact_form = wp_kses_post(get_theme_mod('eight_sec_homepage_settings_contact_section_form',''));

	if((!empty($contact_page) && ($contact_page != 0)) || !empty($contact_form)):
		$contact_data = get_post($contact_page);
?>
		<section id="<?php echo eight_sec_hyphenize($contact_menu);?>" class="eight_sec_plx_contact_section section">
			<div class="ed-container">
				<?php
				if(!empty($contact_page)):?>
					<div class="section-title">
						<h2 class="contact-sec wow fadeIn" data-wow-duration="6s"><?php echo $contact_data->post_title;?></h2>
					</div>
					<div class="contact-description wow fadeInDown" data-wow-duration="2s" >
						<?php echo apply_filters( 'the_content', get_post_field('post_content', $contact_data->ID) );?></div>					
				<?php 
				endif;
				if(!empty($contact_form)){
					?>
					<div class="contact-form wow fadeInUp" data-wow-duration="2s">
						<?php 
						echo do_shortcode($contact_form);?>
					</div>
					<?php
				}
				?>
			</div>				    		
		</section>

<?php 
	endif;
endif;
?>
<!-- end of contact section -->
<?php
get_footer();

?>