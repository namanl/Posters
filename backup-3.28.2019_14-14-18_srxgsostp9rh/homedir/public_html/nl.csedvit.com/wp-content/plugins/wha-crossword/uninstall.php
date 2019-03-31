<?php
/**
 * Uninstall plugin WHA crossword
 * Trigger Uninstall process only if WP_UNINSTALL_PLUGIN is defined
 */

if(!defined('WP_UNINSTALL_PLUGIN')) exit;

    global $wpdb;

    // Delete data from table wp_postmeta
    $wpdb->get_results('DELETE FROM wp_postmeta WHERE meta_key IN (
                                  "wha_crossword", 
                                  "whacw_option_bg_color", 
                                  "whacw_option_border_color",
                                  "whacw_option_text_color",
                                  "whacw_question_block_text_color",
                                  "whacw_counter_color",
                                  "whacw_highlight_correct_ansver",
                                  "whacw_highlight_incorrect_ansver",
                                  "whacw_align_question",
                                  "whacw_use_global_options",
                                  "whacw_congratulations_message",
                                  "whacw_congratulations_individual")');

    // Delete data from table wp_options
    delete_option('whacw_option_bg_color');
    delete_option('whacw_option_border_color');
    delete_option('whacw_option_text_color');
    delete_option('whacw_highlight_correct_ansver');
    delete_option('whacw_highlight_incorrect_ansver');
    delete_option('whacw_align_question');
    delete_option('whacw_question_block_text_color');
    delete_option('whacw_counter_color');
    delete_option('whacw_congratulations_message');

    // Delete data from table wp_posts
    $wpdb->get_results('DELETE FROM wp_posts WHERE post_type IN ("wha_crossword")');









