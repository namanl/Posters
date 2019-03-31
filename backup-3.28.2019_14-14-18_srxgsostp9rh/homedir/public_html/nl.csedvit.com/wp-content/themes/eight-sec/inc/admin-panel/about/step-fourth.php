<?php
/**
 * Changelog
 */

$eight_sec = wp_get_theme( 'eight-sec' );
?>
<div class="featured-section changelog">
<?php
	WP_Filesystem();
	global $wp_filesystem;
	$eight_sec_changelog       = $wp_filesystem->get_contents( get_template_directory() . '/readme.txt' );
	$changelog_start = strpos($eight_sec_changelog,'== Changelog ==');
	$eight_sec_changelog_before = substr($eight_sec_changelog,0,($changelog_start+18));
	$eight_sec_changelog = str_replace($eight_sec_changelog_before,'',$eight_sec_changelog);
	$eight_sec_changelog_lines = explode( PHP_EOL, $eight_sec_changelog );
	foreach ( $eight_sec_changelog_lines as $eight_sec_changelog_line ) {
		if ( substr( $eight_sec_changelog_line, 0, 7 ) === "Version" ) {
			echo '<h4>' . substr( $eight_sec_changelog_line,0, 14 ) . '</h4>';
		} else {
			echo esc_html( $eight_sec_changelog_line ), '<br/>';
		}
	}
	echo '<hr />';
	?>
</div>