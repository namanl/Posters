<?php
/**
  *
 * @package Eight_sec
 */
$ed_search_placeholder  = get_theme_mod('eight_sec_header_setting_search_placeholder',esc_html__('Search...','eight-sec'));
$ed_search_button_text  = get_theme_mod('eight_sec_header_setting_search_button_text',esc_html__('Search','eight-sec'));
 ?>
<div class="search-icon">
    <i class="fa fa-search"></i>
    <div class="ed-search">
    <div class="search-close"><i class="fa fa-close"></i></div>
     <form action="<?php echo esc_url( home_url( '/' ) ); ?>" class="search-form" method="get" role="search">
        <label>
            <span class="screen-reader-text"><?php esc_html_e('Search for:','eight-sec')?></span>
            <input type="search" title="<?php esc_attr_e('Search for:','eight-sec')?>" name="s" value="" placeholder="<?php echo esc_attr($ed_search_placeholder); ?>" class="search-field" />
        </label>
        <input type="submit" value="<?php echo esc_attr($ed_search_button_text); ?>" class="search-submit" />
     </form> 
    </div>
</div>