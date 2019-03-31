
<?php /* Cover */

global $wp_customize;

/* Retrive fields */

/* Icon 1 */
$wlow_home_icons_1 = get_theme_mod('wlow__home__icons_1', esc_html__('fa-rss','wlow'));
$wlow_home_link_1 = get_theme_mod('wlow__home__link_1', esc_url('#'));

/* Icon 2 */
$wlow_home_icons_2 = get_theme_mod('wlow__home__icons_2', esc_html__('fa-map-marker','wlow'));
$wlow_home_link_2 = get_theme_mod('wlow__home__link_2', esc_url('#'));

/* Icon 3 */
$wlow_home_icons_3 = get_theme_mod('wlow__home__icons_3', esc_html__('fa-envelope','wlow'));
$wlow_home_link_3 = get_theme_mod('wlow__home__link_3', esc_url('#'));

/* Icon 4 */
$wlow_home_icons_4 = get_theme_mod('wlow__home__icons_4', esc_html__('fa-phone','wlow'));
$wlow_home_link_4 = get_theme_mod('wlow__home__link_4', esc_url('#'));

/* Title & Subtitle*/
$wlow_home_cover_title 		= get_theme_mod('wlow__home__cover__title', esc_html__('The Amazing Parallax Theme','wlow'));
$wlow_home_cover_subtitle = get_theme_mod('wlow__home__cover__subtitle', esc_html__('With awesome navigation, Desktop & Mobile','wlow'));

/* Button */
$wlow_home_cover_buttonlabel 	= get_theme_mod('wlow__home__cover__button-label', esc_html__('See the features','wlow'));
$wlow_home_cover_buttonlink 	= get_theme_mod('wlow__home__cover__button-link', esc_url( home_url( '/' ) ).'#focus');

/* Iamge */
$wlow_home_cover_image 	= get_theme_mod('wlow__home__cover__image',get_template_directory_uri() . '/img/demo/city.jpg');

?>

<section class="parallax parallax-background parallax-cover" style="background: url(<?php echo $wlow_home_cover_image; ?>) no-repeat top center fixed; background-size: cover;">
	<span class="anchor" id="cover"></span>
	<div class="parallax__filter"></div>
	<div class="parallax__caption">
		<div class="spacer"></div>
		<div class="container">

			<div class="parallax__caption__intro">

				<?php
				/* Icon 1 */
				if( !empty($wlow_home_icons_1) ){

					echo ( ! empty( $wlow_home_link_1 ) ) ? '<a href="' . $wlow_home_link_1 . '">' : '';

					echo '<i class="fa ' .$wlow_home_icons_1 . '"></i>';

					echo ( ! empty( $wlow_home_link_1 ) ) ? '</a>' : '';

				} ?>

				<?php
				/* Icon 2 */
				if( !empty($wlow_home_icons_2) ){

					echo ( ! empty( $wlow_home_link_2 ) ) ? '<a href="' . $wlow_home_link_2 . '">' : '';

					echo '<i class="fa ' .$wlow_home_icons_2 . '"></i>';

					echo ( ! empty( $wlow_home_link_2 ) ) ? '</a>' : '';

				} ?>

				<?php
				/* Icon 3 */
				if( !empty($wlow_home_icons_3) ){

					echo ( ! empty( $wlow_home_link_3 ) ) ? '<a href="' . $wlow_home_link_3 . '">' : '';

					echo '<i class="fa ' .$wlow_home_icons_3 . '"></i>';

					echo ( ! empty( $wlow_home_link_3 ) ) ? '</a>' : '';

				} ?>

				<?php
				/* Icon 4 */
				if( !empty($wlow_home_icons_4) ){

					echo ( ! empty( $wlow_home_link_4 ) ) ? '<a href="' . $wlow_home_link_4 . '">' : '';

					echo '<i class="fa ' .$wlow_home_icons_4 . '"></i>';

					echo ( ! empty( $wlow_home_link_4 ) ) ? '</a>' : '';

				} ?>

			</div>


				<?php

				/* Title */
				if( !empty($wlow_home_cover_title) ){
					echo '<h2 class="parallax__caption__title gigantic">';

					echo ( ! empty( $wlow_home_cover_buttonlink ) ) ? '<a class="scroll-to" href="' . $wlow_home_cover_buttonlink . '">' : '';

					echo $wlow_home_cover_title;

					echo ( ! empty( $wlow_home_cover_buttonlink ) ) ? '</a>' : '';

					echo'</h2>';
				}

				/* Subtitle */
				if( !empty($wlow_home_cover_subtitle) ){
					echo '<h3 class="parallax__caption__subtitle large light">'. $wlow_home_cover_subtitle .'</h3>';
				}

				/* Button */
				if( !empty($wlow_home_cover_buttonlabel) ){
					echo '<a class="scroll-to button animate" href="'. $wlow_home_cover_buttonlink .'">'. $wlow_home_cover_buttonlabel .'</a>';
				}

				?>

		</div>
	</div>
	<a class="container-arrow scroll-to" href="#focus">
    <span><i class="fa fa-angle-down" aria-hidden="true"></i></span>
  </a>
</section>
