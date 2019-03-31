<?php
function ocdi_import_files() {
	return array(
		array(
			'import_file_name'             => 'Eight Sec',
			//'categories'                   => array( 'Category 1', 'Category 2' ),
			'local_import_file'            => trailingslashit( get_template_directory() ) . 'welcome/demo/main/content.xml',
			'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'welcome/demo/main/widgets.wie',
			'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'welcome/demo/main/customizer_options.dat',
			'import_preview_image_url'     => 'https://8degreethemes.com/demo/eight-sec/eight-sec.jpg',
			//'import_notice'                => __( 'After you import this demo, you will have to setup the menu separately.', 'eight-sec' ),
			'preview_url'                  => 'https://8degreethemes.com/demo/eight-sec/main',
		),
	);
}
add_filter( 'pt-ocdi/import_files', 'ocdi_import_files' );


function ocdi_after_import( $selected_import ) {
	if ( 'Eight Sec' === $selected_import['import_file_name'] ) {
		// Assign menus to their locations.
		$main_menu = get_term_by( 'name', 'Menu 1', 'nav_menu' );

		set_theme_mod( 'nav_menu_locations', array(
			'primary' => $main_menu->term_id,
		)
	);

		// Assign front page and posts page (blog page).
		$front_page_id = get_page_by_title( 'Home' );

		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $front_page_id->ID );
	}
}
add_action( 'pt-ocdi/after_import', 'ocdi_after_import' );