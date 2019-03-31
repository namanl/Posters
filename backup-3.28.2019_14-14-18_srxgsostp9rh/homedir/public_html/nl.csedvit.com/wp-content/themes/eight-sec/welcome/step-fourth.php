<?php
/**
 * Changelog
 */

	$eight_sec_lite = wp_get_theme( 'eight-sec' );
	?>
	<div class="featured-section changelog">
		<?php
		WP_Filesystem();
		global $wp_filesystem;
		$eight_sec_changelog       = $wp_filesystem->get_contents( get_template_directory() . '/readme.txt' );
		$changelog_start = strpos($eight_sec_changelog,'== Changelog ==');
		$eight_sec_changelog_before = substr($eight_sec_changelog,0,($changelog_start+15));
		$eight_sec_changelog = str_replace($eight_sec_changelog_before,'',$eight_sec_changelog);
		$eight_sec_changelog = str_replace('**','<br/>**',$eight_sec_changelog);
		$eight_sec_changelog = str_replace('= 1.0','<br/><br/>= 1.0',$eight_sec_changelog);
		echo $eight_sec_changelog;
		echo '<hr />';
		?>
	</div>