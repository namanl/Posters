<?php
 // init process for registering our button
 add_action('init', 'ccpuz_wpse72394_shortcode_button_init');
 function ccpuz_wpse72394_shortcode_button_init() {
      if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') && get_user_option('rich_editing') == 'true')
           return;
      add_filter("mce_external_plugins", "ccpuz_wpse72394_register_tinymce_plugin", 99);
      add_filter('mce_buttons', 'ccpuz_wpse72394_add_tinymce_button');
}


//This callback registers our plug-in
function ccpuz_wpse72394_register_tinymce_plugin($plugin_array) {
    global $post;
    if( $post == NULL )
        return $plugin_array;

    echo '<script type="text/javascript">var ccpuz_wpse72394_button_ajax_url = "'. admin_url('admin-ajax.php') .'"; var ccpuz_post_id = "'. $post->ID .'"</script>';
    $plugin_array['ccpuz_wpse72394_button'] = plugins_url('/shortcode.js', __FILE__ );
    return $plugin_array;
}

//This callback adds our button to the toolbar
function ccpuz_wpse72394_add_tinymce_button($buttons) {
            //Add the button ID to the $button array
    $buttons[] = "ccpuz_wpse72394_button";
    return $buttons;
}

add_filter( 'wp_head', 'ccpuz_add_cf' );
function ccpuz_add_cf($content){
	global $post;
	
	if( is_single() || is_page() ){
//	echo '
//
//	';
	}else{
	return $content;
	}
}

// Get form
add_action( 'wp_ajax_ccpuz_get_crossword_mce_from', 'ccpuz_get_crossword_mce_from' );
function ccpuz_get_crossword_mce_from() {
  $post_id= isset( $_POST['post_id'] ) ? $_POST['post_id'] : 0;
  ob_start();
  ?>
    <div class="tw-bs">
      <div class="form-horizontal">
          <fieldset>

          <div class="control-group">
            <label class="control-label" for="select01">Select Method</label>
            <div class="controls">
              <select id="crossword_method" name="crossword_method">
              <option value="url" <?php echo ( get_post_meta( $post_id, 'crossword_method', true ) == 'url' ? ' selected ' : '' ); ?> >URL</option>
              <option value="local" <?php echo ( get_post_meta( $post_id, 'crossword_method', true ) == 'local' ? ' selected ' : '' ); ?> >Local File</option>

              </select>
            </div>
            </div>

            <div class="control-group ccpuz_url_class">
            <label class="control-label" for="fileInput">URL Upload</label>
            <div class="controls">
              <input type="text" class="input-xlarge" name="ccpuz_url_upload_field" id="ccpuz_url_upload_field" value="<?php echo get_post_meta( $post_id, 'ccpuz_url_upload_field', true ); ?>">
              <!--
              <button type="button" class="btn btn-primary" id="url_upload_button" >Upload File</button> -->

            </div>
            </div>
          <div class="control-group ccpuz_file_class">

            <label class="control-label" for="fileInput">HTML File</label>
            <div class="controls">
              <input class="input-file" id="ccpuz_html_file" name="ccpuz_html_file" type="file">
            </div>
            <label class="control-label" for="fileInput">JS File</label>
            <div class="controls">
              <input class="input-file" id="ccpuz_js_file" name="ccpuz_js_file" type="file">
            </div>
            </div>


          <!-- <div class="form-actions">
            <button type="button" id="ccpuz_insert_code" class="btn btn-primary">Insert</button>
            </div> -->


          </fieldset>
      </div>
    </div>
  <?php
  echo ob_get_clean();
}

// save form
add_action( 'wp_ajax_ccpuz_save_crossword_mce_from', 'ccpuz_save_crossword_mce_from' );
function ccpuz_save_crossword_mce_from() {
    global $current_user;
    $post_id= isset( $_POST['post_id'] ) ? $_POST['post_id'] : 0;
    $post_type = get_post_type( $post_id );

    $should_be = 0;
    if( substr_count( get_post($post_id)->post_content, '[crossword]' ) > 0 ){
        $should_be = 1;
    }

    if( isset($_POST['crossword_method']) ){
        update_post_meta( $post_id, 'crossword_method', $_POST['crossword_method'] );
    }

    if( isset($_POST['crossword_method']) && $_POST['crossword_method'] == 'url' ){
        $url = isset($_POST['ccpuz_url_upload_field']) ? filter_var($_POST['ccpuz_url_upload_field'], FILTER_SANITIZE_URL) : '';
        if( filter_var($url, FILTER_VALIDATE_URL) !== false ){
            if (preg_match('#(crossword|crossword\-puzzle|crosswordpuzzle|crucigrama|cruciverb|karebulmaca|kruiswoordraadsel|motscroise|palavrascruzadas|pussel).info#', $_POST['ccpuz_url_upload_field'])){
                //var_dump(file_get_contents( $_POST['ccpuz_file_upload_field'] ));
                $response = wp_remote_get( $_POST['ccpuz_url_upload_field'] );
                $file_source= wp_remote_retrieve_body($response);
                preg_match ( '/src="[^"]+"/i' , $file_source , $arr );

                $res_command = get_string_between( $file_source, '$(function(){', '})' );

                $id = get_string_between( $res_command, '$("', '")');
                $res_command = str_replace($id, '#CrosswordCompilerPuz', $res_command);
                $res_command = preg_replace( '/$\("#[^"]+"\)/i', '$("#SSS")', $res_command );
                $res_command = preg_replace( '/ROOTIMAGES: "[^"]+"/i', 'ROOTIMAGES: ""', $res_command );
                $res_command = preg_replace( '/PROGRESS:[^,]+"/i', '', $res_command );

                //var_Dump( $res_command );

                $res_command = str_replace( 'ROOTIMAGES: "', 'ROOTIMAGES: "'.plugins_url( 'inc/CrosswordCompilerApp/CrosswordImages/', __FILE__ ), $res_command );
                $res_command =str_replace('\\', '\\\\', $res_command);

                foreach( $arr as $single ){
                    if( substr_count( $single, '_xml.js' ) > 0 ){
                        $js_url = 'http://crossword.info'.str_replace('src=', '', str_replace('"', '', $single ) );
                        $upload_dir = wp_upload_dir();
                        $filename   = sanitize_file_name( basename($js_url) ) ;

                        if( wp_mkdir_p( $upload_dir['path'] ) ) {
                            $file = $upload_dir['path'] . '/' . $filename;
                            $url = $upload_dir['url'] . '/' . $filename;
                        } else {
                            $file = $upload_dir['basedir'] . '/' . $filename;
                            $url = $upload_dir['baseurl'] . '/' . $filename;
                        }

                        $response = wp_remote_get($js_url );
                        $image_data = wp_remote_retrieve_body($response);
                        @file_put_contents( $file, $image_data );
                    }
                }
            }

            if( $response == null ) {
                echo 'Oops, something wrong: must give full crossword.info puzzle URL.', 'Error: Something went wrong.';
                exit;
            }

            if( !isset($url) && !get_post_meta( $post_id, 'ccpuz_url_upload_field', true ) && $should_be == 1 ){
                echo 'Oops, something wrong: must give full crossword.info puzzle URL.', 'Error: Something went wrong.';
                exit;
            }

            ### adding custom fields
            $str_parent = ' jQuery(".entry-content").attr( "class", "entry-content puzzle"); ';
            ccpuz_applet();
            update_post_meta( $post_id, 'ccpuz_js_url', $url );
            update_post_meta( $post_id, 'ccpuz_js_run', '<script>jQuery(document).ready(function($) { '.$str_parent.' '.$res_command.' });</script>' );

            update_post_meta( $post_id, 'ccpuz_url_upload_field', $_POST['ccpuz_url_upload_field'] );
        } else {
            echo 'Oops, Please input url! ', 'Error: Something went wrong.';
            exit;
        }
    }

    if( isset($_POST['crossword_method']) && $_POST['crossword_method'] == 'local' ){

        if( $_FILES["ccpuz_html_file"]["tmp_name"] ){
            $file_source = file_get_contents( $_FILES["ccpuz_html_file"]["tmp_name"] );
            $res_command = get_string_between( $file_source, '$(function(){', '})' );
            $res_command = preg_replace( '/ROOTIMAGES: "[^"]+"/i', 'ROOTIMAGES: ""', $res_command );
            $res_command = str_replace( 'ROOTIMAGES: "', 'ROOTIMAGES: "'.plugins_url( 'inc/CrosswordCompilerApp/CrosswordImages/', __FILE__ ), $res_command );
            $str_parent = ' $(".entry-content").attr( "class", "entry-content puzzle"); ';
            if( !$res_command ){
                echo 'Oops, Something wrong with html file.', 'Error: Something wrong with puzzle html file.';
                exit;
            }
            update_post_meta( $post_id, 'ccpuz_js_run', '<script>jQuery(document).ready(function($) { '.$str_parent.' '.$res_command.' });</script>' );
        } else{

            if( get_post_meta( $post_id, 'ccpuz_js_run', true) == ''  && $should_be == 1 ){
                echo 'Oops, Add HTML file exported by Crossword Compiler.', 'Error: Something went wrong.';
                exit;
            }
        }
        if( $_FILES["ccpuz_js_file"]["name"] ){
            $upload_dir = wp_upload_dir();
            $filename   = sanitize_file_name( $_FILES["ccpuz_js_file"]["name"] ) ;
            if( wp_mkdir_p( $upload_dir['path'] ) ) {
                $file = $upload_dir['path'] . '/' . $filename;
                $url = $upload_dir['url'] . '/' . $filename;
            }else {
                $file = $upload_dir['basedir'] . '/' . $filename;$url = $upload_dir['baseurl'] . '/' . $filename;
            }
            $image_data = @file_get_contents( $_FILES["ccpuz_js_file"]["tmp_name"] );
            @file_put_contents( $file, $image_data );
            ccpuz_applet();
            update_post_meta( $post_id, 'ccpuz_js_url', $url );
        } else{
            if( get_post_meta( $post_id, 'ccpuz_js_url', true) == '' && $should_be == 1 ){
                echo 'Oops, Add puzzle .js file exported by Crossword Compiler.', 'Error: Something went wrong.';
                exit;
            }

        }

    }

    echo 1;
    exit;
}

function column_block_crossword_editor_assets(){
    // Scripts.
    wp_enqueue_script(
        'gutenberg-crossword-block-script', // Handle.
        plugins_url( 'modules/js/gutenberg-crossword.js', dirname(__FILE__) ), // Block.js: We register the block here.
        array( 'wp-blocks', 'wp-element', 'wp-i18n' ) // Dependencies, defined above.
    );
    wp_localize_script( 'gutenberg-crossword-block-script', 'ajax_object', array(
        'ajax_url' => admin_url( 'admin-ajax.php' )
    ) );
    // Styles.
    wp_enqueue_style(
        'gutenberg-crossword-block-editor-style', // Handle.
        plugins_url( 'modules/css/gutenberg-crossword-editor.css', dirname(__FILE__) ), // Block editor CSS.
        array( 'wp-edit-blocks' ) // Dependency to include the CSS after it.
    );
} // End function column_block_cgb_editor_assets().

// Hook: Editor assets.
add_action('enqueue_block_editor_assets', 'column_block_crossword_editor_assets');

/**
 * Proper way to enqueue scripts and styles
 */
function crossword_custom_scripts() {
    wp_enqueue_style( 'crossword-custom', plugins_url( 'modules/css/custom.css', dirname(__FILE__) ) );
    wp_enqueue_script( 'crossword-custom', plugins_url( 'modules/js/custom.js', dirname(__FILE__) ), array('jquery'), 'version', false);
}
add_action( 'wp_enqueue_scripts', 'crossword_custom_scripts' ); 