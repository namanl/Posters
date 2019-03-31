<?php 
$port_cat = get_theme_mod('eight_sec_homepage_setting_portfolio_section_select','');
$readmore = get_theme_mod('eight_sec_blog_archive_setting_readmore',__('Read More','eight-sec'));

$args= array(
	'cat'	=>	$port_cat,
	'post_per_page'	=>	-1,
	'post_status'	=>	'publish'
	);
$port_query = new WP_Query($args);
$all_cat = get_categories(array('type' => 'post', 'parent' => $port_cat));
if($port_query->have_posts()){
?>
	<div class="portfolio-wrap">
        <header class="sort-table"> 
            <ul class='button-group filters-button-group'>
                <li class="button is-checked" data-filter="*"> <?php esc_html_e('Show all', 'eight-sec');?> </li>
                <?php
                foreach ($all_cat as $category) :
                    $cat_detail = get_category($category);
                    echo '<li class="button" data-filter=.' . esc_attr($cat_detail->slug) . '>' . $cat_detail->name . '</li>';
                endforeach;
                ?>
                </ul>
                <?php
            wp_reset_postdata();
            ?>
        </header>

        <div class="ed-sortable-grid">
        <?php                            
            if ($port_query->have_posts()): 
                while ($port_query->have_posts()) : 
                    $port_query->the_post();
                    $term_lists = wp_get_post_terms($post->ID, 'category', array("fields" => "all"));
                    $term_slugs = array();
                    foreach ($term_lists as $term_list) {
                        $term_slugs[] = $term_list->slug;
                    }
                    $term_slugs = join(' ', $term_slugs);
        ?>              
                                
                    <div class="element-item <?php echo esc_attr($term_slugs);?>">
                    <?php
                    
                    $img_src = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'eight-sec-testimoial-image', true);
                    $img_link = esc_url($img_src[0]);
                    ?>
                        <div class="ed-grid-img">
                            <a href="<?php the_permalink(); ?>">
                                <img src="<?php echo $img_link; ?>" alt="<?php the_title_attribute(); ?>">
                            </a>
                        </div>

                        <div class="ed-grid-hover">
                            <h6><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
                            <p><?php the_excerpt();?></p>
                            <div class="ed-readmore">
                               <a href="<?php the_permalink(); ?>"><?php echo esc_html($readmore);?></a>
                            </div>                                         

                        </div>
                    </div>
            <?php
                endwhile;
                wp_reset_postdata();
            endif;

            ?>
        </div>
    </div>
        
<?php
}
?>