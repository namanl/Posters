<?php
/**
 *
 * Plugin Name:       WHA Crossword
 * Description:       The plugin creates an easy crossword from the words of any combination.
 * Version:           1.0.0
 * Author:            WHA
 * Author URI:        http://webhelpagency.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wha-crossword
 * Domain Path:       /languages
 *
 * WHA Crossword is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * WHA Crossword is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with WHA Crossword. If not, see http://www.gnu.org/licenses/gpl-2.0.txt.
 */


if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}


// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

define('WHA_CROSSWORD_VERSION', '1.0.0');


function crossword_activation(){}

register_activation_hook(__FILE__, 'crossword_activation');

function crossword_deactivation(){}

register_deactivation_hook(__FILE__, 'crossword_deactivation');


// Add scripts & styles
add_action('admin_enqueue_scripts', 'whacw_action_admin');
function whacw_action_admin($hook_suffix) {

    global $post;

    wp_enqueue_style('crossword-style-admin', plugins_url('res/admin/crossword-admin.css', __FILE__));

    wp_enqueue_script('crossword-script-admin', plugins_url('res/admin/crossword-admin.js', __FILE__), false, '1.0', true);
    wp_localize_script('crossword-script-admin', 'crossword_vars_admin', array(
        'whacw_use_global_options' => get_post_meta($post->ID, 'whacw_use_global_options', true),
    ));

    wp_enqueue_script('color-piker', plugins_url('res/admin/jscolor.js', __FILE__), false, '1.0', true);

}



// Register scripts and styles
add_action('wp_enqueue_scripts', 'whacw_setup_wdscript');
function whacw_setup_wdscript() {

    global $post;

    wp_enqueue_media();

    wp_enqueue_style('crossword-style', plugins_url('res/crossword.css', __FILE__));
    if (is_rtl()) {
        wp_enqueue_style('crossword-style-rtl', plugins_url('res/rtl-crossword.css', __FILE__));
    }
    wp_enqueue_script('crossword-script', plugins_url('res/crossword.js', __FILE__), array('jquery'), false, '1.0', true);

    /* Adds additional data */
    wp_localize_script('crossword-script', 'crossword_vars', array(
        'whacw_bg_color' => get_option('whacw_option_bg_color'),
        'whacw_border_color' => get_option('whacw_option_border_color'),
        'whacw_txt_color' => get_option('whacw_option_text_color'),
        'whacw_align_question' => get_option('whacw_align_question'),
        'whacw_ansver' => get_option('whacw_highlight_correct_ansver'),
        'whacw_ansver_incorect' => get_option('whacw_highlight_incorrect_ansver'),
        'whacw_question_txt_color' => get_option('whacw_question_block_text_color'),
        'whacw_counter_color' => get_option('whacw_counter_color'),
    ));

    wp_localize_script('ajax-script', 'my_ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));

}



// Initialization post type
add_action('init', 'whacw_register_post_type');
function whacw_register_post_type() {

    $labels = array(
        'name' => __('Crossword', 'crossword'),
        'menu_name' => __('Crossword', 'crossword'),
        'singular_name' => __('Crossword', 'crossword'),
        'name_admin_bar' => __('Crossword', 'name admin bar', 'crossword'),
        'all_items' => __('All  Crosswords', 'crossword'),
        'search_items' => __('Search  Crosswords', 'crossword'),
        'add_new' => __('Add New', 'crossword', 'crossword'),
        'add_new_item' => __('Add New Crossword', 'crossword'),
        'new_item' => __('New  Crossword', 'crossword'),
        'view_item' => __('View  Crossword', 'crossword'),
        'edit_item' => __('Edit  Crossword', 'crossword'),
        'not_found' => __('No  Crossword Found.', 'crossword'),
        'not_found_in_trash' => __('Crossword not found in Trash.', 'crossword'),
        'parent_item_colon' => __('Parent Crossword', 'crossword'),
    );

    $args = array(
        'labels' => $labels,
        'description' => __('Holds the crossword and their data.', 'crossword'),
        'menu_position' => 5,
        'menu_icon' => 'dashicons-editor-help',
        'public' => false,
        'publicly_queryable' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'supports' => array('title', 'thumbnail'),
    );

    register_post_type('wha_crossword', $args);
}



// Create crossword page
add_filter('the_content', 'whacw_create_crossword_page');
function whacw_create_crossword_page($content) {

    global $post;

    if ('wha_crossword' !== $post->post_type) {
        return $content;
    }

    if (!is_single()) {
        return $content;
    }

    $crossword_html = whacw_whagamecrossword_func(array('id' => $post->ID));

    return $crossword_html . $content;
}



// Create shortcode crossword
function whacw_whagamecrossword_func($atts) {

    if (!isset($atts['id'])) {
        return false;
    }
    $id = $atts['id'];

    $html = '';
    $crossword = get_post_meta($id, 'wha_crossword', true);

    $rows = json_decode($crossword, true, 512, JSON_UNESCAPED_UNICODE);
    if ($rows) {
        $html .= '<div class="crossword_wrapper">';
        $html .= '<div class="row wha-crossword-row">
        <div class="wha-crossword-container">

        <br/><br/> ';

        $html .= '<div class="wha-center wha-crossword" id="wha-crossword"></div><br/>';
        $html .= '</div>';
        $html .= '</div>';

        $html .= '<div class="wha-center wha-crossword-questions">';
        $i = 1;
        foreach ($rows as $row) {
            $html .= '<div class="wha-line">
                      <input class="wha-word" data-counter="' . $i . '" type="hidden" value="' . $row['word'] . '"/>
                      <div class="wha-clue" data-counter="' . $i . '">' . $i . '. ' . $row['clue'] . '</div>
                      </div>';
            $i++;
        }
        $html .= '</div>';
        $html .= '</div><div class="clearfix"></div>';
        $html .= '<style></style>';
        $html .= "<script></script>";
        $html .= "<script>
        /* <![CDATA[ */
        var optional_crossword_vars = {
            'whacw_optional_bg_color':'" . get_post_meta($id, 'whacw_option_bg_color', true) . "',
            'whacw_optional_border_color':'" . get_post_meta($id, 'whacw_option_border_color', true) . "',
            'whacw_optional_text_color':'" . get_post_meta($id, 'whacw_option_text_color', true) . "',
            'whacw_optional_question_color':'" . get_post_meta($id, 'whacw_question_block_text_color', true) . "',
            'whacw_optional_counter_color':'" . get_post_meta($id, 'whacw_counter_color', true) . "',
            'whacw_use_global_options':'" . get_post_meta($id, 'whacw_use_global_options', true) . "',
            'whacw_correct_ansver':'" . get_post_meta($id, 'whacw_highlight_correct_ansver', true) . "',
            'whacw_incorrect_ansver':'" . get_post_meta($id, 'whacw_highlight_incorrect_ansver', true) . "',
            'whacw_align_question':'" . get_post_meta($id, 'whacw_align_question', true) . "'            
        };
        /* ]]> */
        </script>";

        if(get_post_meta($id, 'whacw_use_global_options', true) == "no") {
           $message = !empty(get_post_meta($id, 'whacw_congratulations_individual', true))?
                             get_post_meta($id, 'whacw_congratulations_individual', true):__('Congratulations!','whacw_crossword');
       } else {
           $message = !empty(get_option("whacw_congratulations_message"))?
                             get_option("whacw_congratulations_message"):__('Congratulations!','whacw_crossword');
       }

        $html .= '<div id="modal_form">
                    <span id="modal_close">X</span>
                    <div class="content">'.$message.'</div>
                  </div>
                  <div id="overlay"></div>';
    }
    return $html;
}

add_shortcode('game-crossword', 'whacw_whagamecrossword_func');



// Add Crossword option box
add_action('add_meta_boxes', 'whacw_add_custom_box_shortcode', 10);
function whacw_add_custom_box_shortcode() {
    $screens = array('wha_crossword');
    add_meta_box('myplugin_sectionid_shortcode', 'CROSSWORD SHORTCODE:', 'whacw_meta_box_shortcode_callback', $screens, 'advanced', 'high');
}
function whacw_meta_box_shortcode_callback($post, $meta) {
    $screens = $meta['args'];

    wp_nonce_field(plugin_basename(__FILE__), 'myplugin_noncename');
    $crossword = get_post_meta($post->ID, 'wha_crossword', true);
    echo '<div class="shortcode">[game-crossword id="' . $post->ID . '" ]</div>';
}


// Add Crossword option box
add_action('add_meta_boxes', 'whacw_add_custom_box', 20);
function whacw_add_custom_box() {
    $screens = array('wha_crossword');
    add_meta_box('myplugin_sectionid', 'CROSSWORD: CLUE AND WORD', 'whacw_meta_box_callback', $screens, 'advanced', 'low');
}
function whacw_meta_box_callback($post, $meta) {

    $screens = $meta['args'];

    wp_nonce_field(plugin_basename(__FILE__), 'myplugin_noncename');
    $crossword = get_post_meta($post->ID, 'wha_crossword', true);

    $items = json_decode($crossword, true, 512, JSON_UNESCAPED_UNICODE);
    echo '<div class="wha-crossword-row-admin">';
    if ($items) {
        foreach ($items as $item) {
            echo '<div class="wha-crossword-item">';
            echo '<div class="wha-crossword-block">';
            echo '<div class="wha-crossword-inner"><label>' . __('Clue','whacw_crossword') . '</label><input type="text"  name="wha-crossword-clue[]" value="' . $item['clue'] . '" required size="25" /></div>';
            echo '<div class="wha-crossword-inner"><label>' . __('Word','whacw_crossword') . '</label><input type="text"  name="wha-crossword-word[]" value="' . $item['word'] . '" size="25" required /></div>';
            echo '</div>';
            echo '<a href="#" title="Delete item" class="wha-delete-crossword-item">X</a>';
            echo '</div>';
        }
    }

    echo '<div id="wha-crossword-action-add" class="wha-crossword-action-add"><a href="#" class="wha-add-crossword-item">'.__('Add new item for crossword','whacw_crossword').'</a></div>';
    echo '</div>';
}


// Add Crossword option box
add_action('add_meta_boxes', 'whacw_add_option_box', 30);
function whacw_add_option_box() {

    $screens = array('wha_crossword');
    add_meta_box('myplugin_optionid', 'INDIVIDUAL OPTIONS', 'whacw_option_box_callback', $screens, 'advanced', 'low');
}
function whacw_option_box_callback($post, $meta) {

    $screens = $meta['args'];

    wp_nonce_field(plugin_basename(__FILE__), 'myplugin_noncename');

    $whacw_color_background = get_post_meta($post->ID, 'whacw_option_bg_color', true);
    $whacw_color_border     = get_post_meta($post->ID, 'whacw_option_border_color', true);
    $whacw_color_text       = get_post_meta($post->ID, 'whacw_option_text_color', true);
    $whacw_color_question   = get_post_meta($post->ID, 'whacw_question_block_text_color', true);
    $whacw_color_counter    = get_post_meta($post->ID, 'whacw_counter_color', true);
    $whacw_use_global       = get_post_meta($post->ID, 'whacw_use_global_options', true);
    $whacw_correct_ansver   = get_post_meta($post->ID, 'whacw_highlight_correct_ansver', true);
    $whacw_incorrect_ansver = get_post_meta($post->ID, 'whacw_highlight_incorrect_ansver', true);
    $whacw_align_question   = get_post_meta($post->ID, 'whacw_align_question', true);

    $color_array = array(
        array(
            'title' => "Background color:",
            'name' => "whacw_option_bg_color",
            'value' => $whacw_color_background
        ),
        array(
            'title' => "Border color:",
            'name' => "whacw_option_border_color",
            'value' => $whacw_color_border
        ),
        array(
            'title' => "Text color:",
            'name' => "whacw_option_text_color",
            'value' => $whacw_color_text
        ),
        array(
            'title' => "Question block color:",
            'name' => "whacw_question_block_text_color",
            'value' => $whacw_color_question
        ),
        array(
            'title' => "Counter color:",
            'name' => "whacw_counter_color",
            'value' => $whacw_color_counter
        )
    );
    $radio_array = array(
        array(
            'title' => "Highlight the CORRECT answers?",
            'name' => "whacw_highlight_correct_ansver",
            'value' => $whacw_correct_ansver
        ),
        array(
            'title' => "Highlight the INCORRECT answers?",
            'name' => "whacw_highlight_incorrect_ansver",
            'value' => $whacw_incorrect_ansver
        )
    );
    $align_array = array(
        array(
            'title' => "Align Question block",
            'name' => "whacw_align_question",
            'value' => $whacw_align_question
        )
    );

    echo '<div class="wha-crossword-row-admin">';
    echo __('<h3>Use Global Options?</h3>', 'whacw_crossword');
    echo '<label class="radio_btn global-options-yes"><input type="radio" value="yes" name="whacw_use_global_options" '.($whacw_use_global == "yes" ? "checked" : "").'>'.__('Yes','whacw_crossword').'</label>';
    echo '<label class="radio_btn global-options-no"><input type="radio" value="no" name="whacw_use_global_options" '.(empty($whacw_use_global) || $whacw_use_global == "no" ? "checked" : "").'>'.__('No','whacw_crossword').'</label>';
    echo '<hr class="adm_divider">';

    echo '<div class="wha-crossword-row-admin_single_options">';

    if ($color_array) {

        foreach ($color_array as $item) {
            echo __('<h2>' . $item["title"].'</h2>','whacw_crossword');
            echo '<table>';
            echo '<tr valign="top">';
            if (empty($item["value"]) && $item["name"] != 'whacw_option_bg_color') {
                echo '<td><input class="jscolor" type="text" id="' . $item["name"] . '" name="' . $item["name"] . '" value="000000"/></td>';
            } elseif (!empty($item["value"]) || $item["name"] == 'whacw_option_bg_color') {
                echo '<td><input class="jscolor" type="text" id="' . $item["name"] . '" name="' . $item["name"] . '" value="' . $item["value"] . '"/></td>';
            }
            echo '</tr>';
            echo '</table>';
        }
    }

    /* Hightlight correct/incorect */
    foreach ($radio_array as $radio_arr) {
        echo __('<h2>' . $radio_arr["title"] . '</h2>', 'whacw_crossword');
        echo '<table>';
        echo '<tr valign="top">';
        echo '<label class="radio_btn"><input type="radio" id="' . $radio_arr["name"] . '" name="' . $radio_arr["name"] . '" value="yes" ' . (empty($radio_arr["value"]) || $radio_arr["value"] == "yes" ? "checked" : "") . ' />' . __('Yes','whacw_crossword') . '</label>';
        echo '<label class="radio_btn"><input type="radio" id="' . $radio_arr["name"] . '" name="' . $radio_arr["name"] . '" value="no" ' . ($radio_arr["value"] == "no" ? "checked" : "") . '/>' . __('No','whacw_crossword') . '</label>';
        echo '</tr>';
        echo '</table>';
    }

    /* Align question*/
    foreach ($align_array as $align_arr) {
        echo __('<h2>' . $align_arr["title"] . '</h2>', 'whacw_crossword');
        echo '<table>';
        echo '<tr valign="top">';
        echo '<label class="radio_btn"><input type="radio" id="' . $align_arr["name"] . '" name="' . $align_arr["name"] . '" value="left" ' . ($align_arr["value"] == "left" ? "checked" : "") . '/>' . __('Left','whacw_crossword') . '</label>';
        echo '<label class="radio_btn"><input type="radio" id="' . $align_arr["name"] . '" name="' . $align_arr["name"] . '" value="right" ' . ($align_arr["value"] == "right" ? "checked" : "") . '/>' . __('Right','whacw_crossword') . '</label>';
        echo '<label class="radio_btn"><input type="radio" id="' . $align_arr["name"] . '" name="' . $align_arr["name"] . '" value="bottom" ' . (empty($align_arr["value"]) || $align_arr["value"] == "bottom" ? "checked" : "") . '/>' . __('Bottom','whacw_crossword') . '</label>';
        echo '</tr>';
        echo '</table>';
    }
    echo '</div>';
    echo '</div>';

    echo '<div class="editor_individual_wrap"><h2>'.__('Congratulations text', 'whacw_crossword').'</h2>';
    $message = !empty(get_post_meta($post->ID, 'whacw_congratulations_individual', true))?get_post_meta($post->ID, 'whacw_congratulations_individual', true):'Congratulations individual!';
    /* Individual congratulations text */
    wp_editor($message, 'whacw_congratulations_individual', $settings = array(
        'wpautop' => true,
        'tinymce' => true,
        'textarea_rows' => 20,
        'textarea_name' => 'whacw_congratulations_individual',
    ));
    echo '</div>';
}


// Save data
add_action('save_post', 'whacw_save_postdata');
function whacw_save_postdata($post_id) {


    if (!wp_verify_nonce($_POST['myplugin_noncename'], plugin_basename(__FILE__)))
        return;

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;

    if (!current_user_can('edit_post', $post_id))
        return;

    $array = array();
    $questions = $_POST['wha-crossword-clue'];
    $words = $_POST['wha-crossword-word'];

    $whacw_color_background = htmlspecialchars($_POST['whacw_option_bg_color']);
    $whacw_color_border     = htmlspecialchars($_POST['whacw_option_border_color']);
    $whacw_color_text       = htmlspecialchars($_POST['whacw_option_text_color']);
    $whacw_color_question   = htmlspecialchars($_POST['whacw_question_block_text_color']);
    $whacw_color_counter    = htmlspecialchars($_POST['whacw_counter_color']);
    $whacw_correct_ansver   = htmlspecialchars($_POST['whacw_highlight_correct_ansver']);
    $whacw_incorrect_ansver = htmlspecialchars($_POST['whacw_highlight_incorrect_ansver']);
    $whacw_align_question   = htmlspecialchars($_POST['whacw_align_question']);
    $whacw_congratulations_individual = $_POST['whacw_congratulations_individual'];
    $whacw_congratulations  = $_POST['whacw_congratulations_message'];
    $whacw_use_global       = htmlspecialchars($_POST['whacw_use_global_options']);

    $symbol = array("\\\"","&","!","@","#","$","^","*","\\","(",")","-","+","%","_","|","/","(",")","=",":","[","]");

    for ($i = 0; $i < count($questions); $i++) {

        $clue = str_replace($symbol, "", strip_tags($questions[$i]));
        $word = str_replace($symbol, "", strip_tags($words[$i]));

        $arr['clue'] = htmlspecialchars(str_replace(array("\\'"), "'", $clue), ENT_QUOTES);
        $arr['word'] = htmlspecialchars(str_replace(array("\\'"), "'", $word), ENT_QUOTES);
        $array[] = $arr;
    }
    $json = json_encode($array, JSON_UNESCAPED_UNICODE);

    update_post_meta($post_id, 'wha_crossword', $json);
    update_post_meta($post_id, 'whacw_option_bg_color', $whacw_color_background);
    update_post_meta($post_id, 'whacw_option_border_color', $whacw_color_border);
    update_post_meta($post_id, 'whacw_option_text_color', $whacw_color_text);
    update_post_meta($post_id, 'whacw_question_block_text_color', $whacw_color_question);
    update_post_meta($post_id, 'whacw_counter_color', $whacw_color_counter);
    update_post_meta($post_id, 'whacw_highlight_correct_ansver', $whacw_correct_ansver);
    update_post_meta($post_id, 'whacw_highlight_incorrect_ansver', $whacw_incorrect_ansver);
    update_post_meta($post_id, 'whacw_align_question', $whacw_align_question);
    update_post_meta($post_id, 'whacw_use_global_options', $whacw_use_global);
    update_post_meta($post_id, 'whacw_congratulations_message', $whacw_congratulations);
    update_post_meta($post_id, 'whacw_congratulations_individual', $whacw_congratulations_individual);
}


// Settings page
function whacw_register_settings() {
    
    add_option('whacw_option_bg_color', 'crossword backgroundg color');
    add_option('whacw_option_border_color', 'crossword border color');
    add_option('whacw_option_text_color', 'crossword text color');
    add_option('whacw_highlight_correct_ansver', 'crossword_highlight');
    add_option('whacw_highlight_incorrect_ansver', 'crossword_highlight');
    add_option('whacw_align_question', 'crossword_highlight');
    add_option('whacw_question_block_text_color', 'crossword_highlight');
    add_option('whacw_counter_color', 'crossword_highlight');
    add_option('whacw_congratulations_message', 'Congratulations');


    register_setting('whacw_crossword_options_group', 'whacw_option_bg_color', 'crossword_callback');
    register_setting('whacw_crossword_options_group', 'whacw_option_border_color', 'crossword_callback');
    register_setting('whacw_crossword_options_group', 'whacw_option_text_color', 'crossword_callback');
    register_setting('whacw_crossword_options_group', 'whacw_highlight_correct_ansver', 'crossword_callback');
    register_setting('whacw_crossword_options_group', 'whacw_highlight_incorrect_ansver', 'crossword_callback');
    register_setting('whacw_crossword_options_group', 'whacw_align_question', 'crossword_callback');
    register_setting('whacw_crossword_options_group', 'whacw_question_block_text_color', 'crossword_callback');
    register_setting('whacw_crossword_options_group', 'whacw_counter_color', 'crossword_callback');
    register_setting('whacw_crossword_options_group', 'whacw_congratulations_message', 'crossword_callback');

}
add_action('admin_init', 'whacw_register_settings');


// Create submenu in admin panel
function whacw_register_options_page() {

    add_submenu_page('edit.php?post_type=wha_crossword',
        __('Crossword Settings', 'whacw_crossword'),
        __('Crossword Settings', 'whacw_crossword'),
        'manage_options',
        'settings_crossword',
        'whacw_options_page');

}
add_action('admin_menu', 'whacw_register_options_page');

// Global options page
function whacw_options_page() {

    /* Options array */
    $color_array = array(
        array(
            'title' => "Background color:",
            'name' => "whacw_option_bg_color",
            'value' => get_option('whacw_option_bg_color')
        ),
        array(
            'title' => "Border color:",
            'name' => "whacw_option_border_color",
            'value' => get_option('whacw_option_border_color')
        ),
        array(
            'title' => "Text color:",
            'name' => "whacw_option_text_color",
            'value' => get_option('whacw_option_text_color')
        ),
        array(
            'title' => "Question block color:",
            'name' => "whacw_question_block_text_color",
            'value' => get_option('whacw_question_block_text_color')
        ),
        array(
            'title' => "Counter color:",
            'name' => "whacw_counter_color",
            'value' => get_option('whacw_counter_color')
        )
    );
    $radio_array = array(
        array(
            'title' => "Highlight the CORRECT answers?",
            'name' => "whacw_highlight_correct_ansver",
            'value' => get_option('whacw_highlight_correct_ansver')
        ),
        array(
            'title' => "Highlight the INCORRECT answers?",
            'name' => "whacw_highlight_incorrect_ansver",
            'value' => get_option('whacw_highlight_incorrect_ansver')
        )

    );
    $align_array = array(
        array(
            'title' => "Align Question block",
            'name' => "whacw_align_question",
            'value' => get_option('whacw_align_question')
        )
    );

    ?>

    <div class="crossword_options_page">

        <?php if (isset($_GET['settings-updated']) == 'true') : ?>
            <br>
            <div class="notice notice-success is-dismissible">
                <p><?php _e('Settings saved!', 'whacw_crossword'); ?></p>
            </div>
        <?php elseif (isset($_GET['settings-updated']) == 'false'): ?>
            <br>
            <div class="notice notice-error is-dismissible">
                <p><?php _e('Sorry. Something happened.', 'whacw_crossword'); ?></p>
            </div>
        <?php endif; ?>

        <?php echo __('<h2>Global Crossword Settings</h2>', 'whacw_crossword'); ?>

        <form method="post" action="options.php">

            <?php settings_fields('whacw_crossword_options_group'); ?>

            <div class="setting_wrapper">

                <?php
                /* Color items*/
                foreach ($color_array as $col_arr) {
                    echo __('<h2>' . $col_arr["title"] . '</h2>', 'whacw_crossword');
                    echo '<table>';
                    echo '<tr valign="top">';

                    switch ($col_arr["value"]) {
                        case 'crossword border color':
                            $value = '000000';
                            break;
                        case 'crossword text color':
                            $value = '000000';
                            break;
                        case 'crossword_highlight':
                            $value = '000000';
                            break;
                        default:
                            $value = $col_arr["value"];
                    }

                    echo '<td><input class="jscolor" type="text" id="'.$col_arr["name"].'" name="'.$col_arr["name"].'" value="'.$value.'"/></td>';
                    echo '</tr>';
                    echo '</table>';
                }

                /* Hightlight correct/incorect */
                foreach ($radio_array as $radio_arr) {
                    echo __('<h2>'.$radio_arr["title"].'</h2>','whacw_crossword');
                    echo '<table>';
                    echo '<tr valign="top">';
                    echo '<label class="radio_btn"><input type="radio" id="'.$radio_arr["name"].'" name="'.$radio_arr["name"].'" value="yes" '.($radio_arr["value"] == "yes" || $radio_arr["value"] == 'crossword_highlight' ? "checked" : "").'/>'.__('Yes','whacw_crossword') . '</label>';
                    echo '<label class="radio_btn"><input type="radio" id="'.$radio_arr["name"].'" name="'.$radio_arr["name"].'" value="no" '.($radio_arr["value"] == "no" ? "checked" : "") . '/>' . __('No','whacw_crossword') . '</label>';
                    echo '</tr>';
                    echo '</table>';
                }

                /* Align question*/
                foreach ($align_array as $align_arr) {
                    echo __('<h2>' . $align_arr["title"] . '</h2>','whacw_crossword');
                    echo '<table>';
                    echo '<tr valign="top">';
                    echo '<label class="radio_btn"><input type="radio" id="' . $align_arr["name"].'" name="' . $align_arr["name"] . '" value="left" ' . ($align_arr["value"] == "left" ? "checked" : "") . '/>' . __('Left','whacw_crossword') . '</label>';
                    echo '<label class="radio_btn"><input type="radio" id="' . $align_arr["name"].'" name="' . $align_arr["name"] . '" value="right" ' . ($align_arr["value"] == "right" ? "checked" : "") . '/>' . __('Right','whacw_crossword') . '</label>';
                    echo '<label class="radio_btn"><input type="radio" id="' . $align_arr["name"].'" name="' . $align_arr["name"] . '" value="bottom" ' . ($align_arr["value"] == "bottom" || $align_arr["value"] == 'crossword_highlight' ? "checked" : "") . '/>' . __('Bottom','whacw_crossword') . '</label>';
                    echo '</tr>';
                    echo '</table>';
                }

                /* Global congratulations text */
                echo '<h2>'.__('Congratulations text','whacw_crossword').'</h2>';
                $whacw_congratulations = !empty(get_option('whacw_congratulations_message'))?get_option('whacw_congratulations_message'):__('Congratulations global!','whacw_crossword');
                wp_editor($whacw_congratulations, 'whacw_congratulations_message', $settings = array(
                    'wpautop' => true,
                    'tinymce' => true,
                    'textarea_rows' => 20,
                    'textarea_name' => 'whacw_congratulations_message',
                ));

                ?>
                <?php submit_button(); ?>
        </form>

    </div>

    <?php
}