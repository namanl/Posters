<?php

//adding custom scripts and styles in header for favicon and other
function eight_sec_header_scripts(){
    $header_bg_v = get_header_image();
    echo "<style type='text/css' media='all'>";
    if(($header_bg_v)){
        $header_bg_v =   '.site-header.fixed { background: url("'.esc_url($header_bg_v).'") no-repeat scroll left top; background-size: cover; }';
        echo $header_bg_v;
        echo "\n";
        echo '.site-header.fixed .header-sticky-overlay:before {
            content: "";
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0,0,0,0.4);
            z-index: -1;
        }';
    }
    echo "</style>\n";
}
add_action('wp_head','eight_sec_header_scripts');

function eight_sec_web_layout($classes){
    if(get_theme_mod('eight_sec_default_setting_weblayout_layout','fullwidth') == 'boxed'){
        $classes[]= 'boxed-layout';
    }
    else{
        $classes[]='fullwidth-layout';
    }
    return $classes;
}   
add_filter( 'body_class', 'eight_sec_web_layout' );

function eight_sec_no_slider($classes){
    $slider_opt = get_theme_mod('eight_sec_homepage_setting_slider_section_option','no');
    $slider_cat = get_theme_mod('eight_sec_homepage_setting_slider_section_category','');
    if(is_page_template('tpl-home.php')):
        if( ($slider_opt == 'no') || ( $slider_cat == 0) ):
            $classes[]= 'no-slider';
        endif;
        else:
            $classes[] = 'no-slider';
        endif;    
        return $classes;
    }   
    add_filter( 'body_class', 'eight_sec_no_slider' );

    function eight_sec_page_lists(){
      $pages = get_pages();
      $page_list = array();
      $page_list[0] = esc_html__('Select page','eight-sec');
      foreach ($pages as $page) :
         $page_list[$page->ID]	=	$page->post_title;
     endforeach;
     return $page_list;
 }

 function eight_sec_category_lists(){
  $category 	=	get_categories();
  $cat_list 	=	array();
  $cat_list[0]=	esc_html__('Select category','eight-sec');
  foreach ($category as $cat) {
     $cat_list[$cat->term_id]	=	$cat->name;
 }
 return $cat_list;
}

function eight_sec_menu(){
  $sections = array('about','portfolio','team','cta','blog','testimonial','contact');
  $sections = array(0=>array('about',esc_html__('ABOUT US','eight-sec')),1=>array('portfolio',esc_html__('PORTFOLIO','eight-sec')),2=>array('team',esc_html__('TEAM','eight-sec')),3=>array('cta',esc_html__('CTA','eight-sec')),4=>array('blog',esc_html__('BLOG','eight-sec')),5=>array('testimonial',esc_html__('TESTIMONIAL','eight-sec')),6=>array('contact',esc_html__('CONTACT US','eight-sec')));
  
  foreach ($sections as $section) {
     if(esc_attr(get_theme_mod('eight_sec_homepage_setting_'.$section[0].'_section_option','no'))=='yes'){
        $enabled_section[] = array(
            'id' => 'menu_' . esc_attr($section[0]) . '_section',
            'menu_text' => esc_attr(get_theme_mod('eight_sec_homepage_setting_'.$section[0] . '_section_menu_title_text',$section[1])),
            'section' => $section[0],
            );
    }            			
}
if(empty($enabled_section)){
 $enabled_section='';
}
return $enabled_section;
}

function eight_sec_breadcrumb_cb() {
    global $post;
    $showOnHome = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
    $portfolio_section_category = get_theme_mod('portfolio_section_category', 0);

    $delimiter = '&#124;'; // delimiter between crumbs

    $home = esc_html__('Home', 'eight-sec'); // text for the 'Home' link

    $showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
    $before = '<span class="current">'; // tag before the current crumb
    $after = '</span>'; // tag after the current crumb

    $homeLink = esc_url(home_url());

    if (is_home() || is_front_page()) {
        if ($showOnHome == 1)
            echo '<div id="eight-sec-breadcrumbs"><div class="ed-container"><a href="' . $homeLink . '">' . $home . '</a></div></div>';
    } else {
        echo '<div id="eight-sec-breadcrumbs"><div class="ed-container"><a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';

        if (is_category()) {
            $thisCat = get_category(get_query_var('cat'), false);
            if ($thisCat->parent != 0)
                echo get_category_parents($thisCat->parent, TRUE, ' ' . $delimiter . ' ');
            if ($portfolio_section_category != 0 && $thisCat->term_id == $portfolio_section_category){
                echo $before . single_cat_title('', false) . $after;
            } else {
                echo $before . single_cat_title('', false) . $after;
            }
        } elseif (is_search()) {
            echo $before . esc_html('Search results for','eight-sec') .' "'. get_search_query() . '"' ; 
            if (!get_query_var('paged')) {
                $after;
            }
        } elseif (is_day()) {
            echo '<a href="' . esc_url(get_year_link(get_the_time('Y'))) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
            echo '<a href="' . esc_url(get_month_link(get_the_time('Y'), get_the_time('m'))) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
            echo $before . get_the_time('d') . $after;
        } elseif (is_month()) {
            echo '<a href="' . esc_url(get_year_link(get_the_time('Y'))) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
            echo $before . get_the_time('F') . $after;
        } elseif (is_year()) {
            echo $before . get_the_time('Y') . $after;
        } elseif (is_single() && !is_attachment()) {
            if (get_post_type() != 'post') {
                $post_type = get_post_type_object(get_post_type());
                $slug = $post_type->rewrite;
                echo '<a href="' . esc_url($homeLink) . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a>';
                if ($showCurrent == 1)
                    echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
            } else {
                $cat = get_the_category();
                $cat = $cat[0];
                $cats = get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
                $proj_cat = esc_attr(get_theme_mod('portfolio_section_category',''));
                if ($showCurrent == 0)
                    $cats = preg_replace("#^(.+)\s$delimiter\s$#", "$1", $cats);
                echo $cats;
                if ($showCurrent == 1)
                    echo $before . get_the_title() . $after;
            }
        } elseif (!is_single() && !is_page() && get_post_type() != 'post' && !is_404()) {
            $post_type = get_post_type_object(get_post_type());
            echo $before . $post_type->labels->singular_name . $after;
        } elseif (is_attachment()) {
            $parent = get_post($post->post_parent);
            $cat = get_the_category($parent->ID);
            $cat = $cat[0];
            echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
            echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a>';
            if ($showCurrent == 1)
                echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
        } elseif (is_page() && !$post->post_parent) {
            if ($showCurrent == 1)
                echo $before . get_the_title() . $after;
        } elseif (is_page() && $post->post_parent) {
            $parent_id = $post->post_parent;
            $breadcrumbs = array();
            while ($parent_id) {
                $page = get_page($parent_id);
                $breadcrumbs[] = '<a href="' . esc_url(get_permalink($page->ID)) . '">' . get_the_title($page->ID) . '</a>';
                $parent_id = $page->post_parent;
            }
            $breadcrumbs = array_reverse($breadcrumbs);
            for ($i = 0; $i < count($breadcrumbs); $i++) {
                echo $breadcrumbs[$i];
                if ($i != count($breadcrumbs) - 1)
                    echo ' ' . $delimiter . ' ';
            }
            if ($showCurrent == 1)
                echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
            
        } elseif (is_tag()) {
            echo $before . esc_html__('Posts tagged','eight-sec' ).' "' . single_tag_title('', false) . '"' . $after;
        } elseif (is_author()) {
            global $author;
            $userdata = get_userdata($author);
            echo $before . esc_html__('Articles posted by','eight-sec' ) . ' "' . $userdata->display_name .'"'. $after;
        } elseif (is_404()) {
            echo $before . esc_html__('Error 404','eight-sec') . $after;
        }

        if (get_query_var('paged')) {
            if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author())
                echo ' (';
            echo esc_html__(' Page', 'eight-sec') . ' ' . get_query_var('paged');
            if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author())
                echo ' )' .$after;
        }

        echo '</div></div>';
    }
}

add_action('eight_sec_breadcrumb', 'eight_sec_breadcrumb_cb');

function eight_sec_social_setting_cb(){
    $facebooklink = get_theme_mod('eight_sec_social_setting_facebook','#');
    $twitterlink = get_theme_mod('eight_sec_social_setting_twitter','#');
    $google_pluslink = get_theme_mod('eight_sec_social_setting_googleplus','#');
    $youtubelink = get_theme_mod('eight_sec_social_setting_youtube','#');
    $pinterestlink = get_theme_mod('eight_sec_social_setting_pinterest','');
    $linkedinlink = get_theme_mod('eight_sec_social_setting_linkedin','');
    $flickrlink = get_theme_mod('eight_sec_social_setting_flicker','');
    $vimeolink = get_theme_mod('eight_sec_social_setting_vimeo','');
    $stumbleuponlink = get_theme_mod('eight_sec_social_setting_stumbleupon','');
    $instagramlink = get_theme_mod('eight_sec_social_setting_instagram','');
    $soundcloudlink = get_theme_mod('eight_sec_social_setting_soundcloud','');
    $githublink = get_theme_mod('eight_sec_social_setting_github','');
    $tumblrlink = get_theme_mod('eight_sec_social_setting_tumbler','');
    $skypelink = get_theme_mod('eight_sec_social_setting_skype','');
    $rsslink = get_theme_mod('eight_sec_social_setting_rss',''); 
    ?>
    <div class="social-icons ">
        <?php if(!empty($facebooklink)){ ?>
        <a href="<?php echo esc_url($facebooklink); ?>" class="facebook" data-title="<?php esc_attr_e('Facebook','eight-sec')?>" target="_blank"><i class="fa fa-facebook"></i><span></span></a>
        <?php } ?>

        <?php if(!empty($twitterlink)){ ?>
        <a href="<?php echo esc_url($twitterlink); ?>" class="twitter" data-title="<?php esc_attr_e('Twitter','eight-sec')?>" target="_blank"><i class="fa fa-twitter"></i><span></span></a>
        <?php } ?>

        <?php if(!empty($google_pluslink)){ ?>
        <a href="<?php echo esc_url($google_pluslink); ?>" class="gplus" data-title="<?php esc_attr_e('Google Plus','eight-sec')?>" target="_blank"><i class="fa fa-google-plus"></i><span></span></a>
        <?php } ?>

        <?php if(!empty($youtubelink)){ ?>
        <a href="<?php echo esc_url($youtubelink); ?>" class="youtube" data-title="<?php esc_attr_e('Youtube','eight-sec')?>" target="_blank"><i class="fa fa-youtube"></i><span></span></a>
        <?php } ?>

        <?php if(!empty($pinterestlink)){ ?>
        <a href="<?php echo esc_url($pinterestlink); ?>" class="pinterest" data-title="<?php esc_attr_e('Facebook','eight-sec')?>Pinterest" target="_blank"><i class="fa fa-pinterest"></i><span></span></a>
        <?php } ?>

        <?php if(!empty($linkedinlink)){ ?>
        <a href="<?php echo esc_url($linkedinlink); ?>" class="linkedin" data-title="<?php esc_attr_e('Linkedin','eight-sec')?>" target="_blank"><i class="fa fa-linkedin"></i><span></span></a>
        <?php } ?>

        <?php if(!empty($flickrlink)){ ?>
        <a href="<?php echo esc_url($flickrlink); ?>" class="flickr" data-title="<?php esc_attr_e('Flickr','eight-sec')?>" target="_blank"><i class="fa fa-flickr"></i><span></span></a>
        <?php } ?>

        <?php if(!empty($vimeolink)){ ?>
        <a href="<?php echo esc_url($vimeolink); ?>" class="vimeo" data-title="<?php esc_attr_e('Vimeo','eight-sec')?>" target="_blank"><i class="fa fa-vimeo-square"></i><span></span></a>
        <?php } ?>

        <?php if(!empty($instagramlink)){ ?>
        <a href="<?php echo esc_url($instagramlink); ?>" class="instagram" data-title="<?php esc_attr_e('Instagram','eight-sec')?>" target="_blank"><i class="fa fa-instagram"></i><span></span></a>
        <?php } ?>

        <?php if(!empty($tumblrlink)){ ?>
        <a href="<?php echo esc_url($tumblrlink); ?>" class="tumblr" data-title="<?php esc_attr_e('Tumblr','eight-sec')?>" target="_blank"><i class="fa fa-tumblr"></i><span></span></a>
        <?php } ?>
        
        <?php if(!empty($soundcloudlink)){ ?>
        <a href="<?php echo esc_url($soundcloudlink); ?>" class="delicious" data-title="<?php esc_attr_e('Delicious','eight-sec')?>" target="_blank"><i class="fa fa-delicious"></i><span></span></a>
        <?php } ?>

        <?php if(!empty($rsslink)){ ?>
        <a href="<?php echo esc_url($rsslink); ?>" class="rss" data-title="<?php esc_attr_e('Rss','eight-sec')?>" target="_blank"><i class="fa fa-rss"></i><span></span></a>
        <?php } ?>

        <?php if(!empty($githublink)){ ?>
        <a href="<?php echo esc_url($githublink); ?>" class="github" data-title="<?php esc_attr_e('Github','eight-sec')?>" target="_blank"><i class="fa fa-github"></i><span></span></a>
        <?php } ?>

        <?php if(!empty($stumbleuponlink)){ ?>
        <a href="<?php echo esc_url($stumbleuponlink); ?>" class="stumbleupon" data-title="<?php esc_attr_e('Stumbleupon','eight-sec')?>" target="_blank"><i class="fa fa-stumbleupon"></i><span></span></a>
        <?php } ?>
        
        <?php if(!empty($skypelink)){?>
        <a href="<?php echo esc_attr__('Skype:', 'eight-sec') . esc_attr($skypelink); ?>" class="skype" data-title="<?php esc_attr_e('Skype','eight-sec')?>"><i class="fa fa-skype"></i><span></span></a>
        <?php } ?>
    </div>
    <?php
}
add_action('eight_sec_social','eight_sec_social_setting_cb', 10);

// function to active smooth scroll on homepage

function eight_sec_smooth_scroll( ){ 

    if(is_page_template('tpl-home.php')):
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function($){ 
                smoothScroll.init();
            });
        </script>
    <?php 
    endif;
}
add_action('wp_head','eight_sec_smooth_scroll'); 


    // homepage scrolling section configuration
    function eight_sec_scrolling_config(){
        $ed_menu = get_theme_mod( 'eight_sec_header_setting_menu_section_option', 0 );
        if( $ed_menu == 0 ):
                ?>
                <script> 

                    jQuery(document).ready(function($){ 
                        $('.home #content section:not(:first)').removeClass('section');
                        $( '#primary-menu > .menu-item' ).each(function(){
                            var c = $(this).children('a').attr('href');
                            if(c!='#'){
                                var arr = c.split('#');
                                var section = arr[1];
                                $(this).addClass(section);
                                $('.home #content #'+section).addClass("section");
                            }
                        });

                        //menu active
                        $('.menu .menu-item').each(function(){
                            $(this).find('li:first').addClass('active');
                        });
                        // smooth scroll with active menu class in header
                        $(window).scroll(function() {
                            var windscroll = $(window).scrollTop();
                            if (windscroll >= 100) {
                                //$('nav').addClass('fixed');
                                $('#content .section').each(function(i) {
                                    if ($(this).position().top <= windscroll + 50 ) {
                                        $('.menu > li.menu-item').removeClass('active');
                                        var ids = $(this).attr('id');
                                        $('.menu > li.' + ids).addClass('active');
                                    }
                                });

                            } 
                            else {
                                $('.home .menu > li.menu-item').removeClass('active');
                                $('.home .menu > li.menu-item:first').addClass('active');
                            }
                        }).scroll();
                        
                    });
                </script>

                <?php
            else:
                ?>
                <script> 

                    jQuery(document).ready(function($){ 
                        
                        //menu active
                        $('.menu .menu-item').each(function(){
                            $(this).find('li:first').addClass('active');
                        });
                        // smooth scroll with active menu class in header
                        $(window).scroll(function() {
                            var windscroll = $(window).scrollTop();
                            if (windscroll >= 100) {
                                //$('nav').addClass('fixed');
                                $('#content .section').each(function(i) {
                                    if ($(this).position().top <= windscroll + 50 ) {
                                        $('.menu > li.menu-item').removeClass('active');
                                        $('.menu > li.menu-item').eq(i).addClass('active');
                                    }
                                });

                            } 
                            else {
                                $('.menu > li.menu-item').removeClass('active');
                                $('.menu > li.menu-item:first').addClass('active');
                            }
                        }).scroll();
                        
                    });
                </script>

                <?php

        endif;

    }
    add_action('wp_head','eight_sec_scrolling_config');

function eight_sec_hyphenize($string) {
    return strtolower(
        preg_replace(
          array( '#[\\s-]+#', '#[^A-Za-z0-9\. -]+#' ),
          array( '-', '' ),
          // the full cleanString() can be download from http://www.unexpectedit.com/php/php-clean-string-of-utf8-chars-convert-to-similar-ascii-char
          eight_sec_cleanString($string)
          )
        );
}

function eight_sec_cleanString($text) {
    $utf8 = array(
        '/[áàâãªä]/u'   =>   'a',
        '/[ÁÀÂÃÄ]/u'    =>   'A',
        '/[ÍÌÎÏ]/u'     =>   'I',
        '/[íìîï]/u'     =>   'i',
        '/[éèêë]/u'     =>   'e',
        '/[ÉÈÊË]/u'     =>   'E',
        '/[óòôõºö]/u'   =>   'o',
        '/[ÓÒÔÕÖ]/u'    =>   'O',
        '/[úùûü]/u'     =>   'u',
        '/[ÚÙÛÜ]/u'     =>   'U',
        '/ç/'           =>   'c',
        '/Ç/'           =>   'C',
        '/ñ/'           =>   'n',
        '/Ñ/'           =>   'N',
        '/–/'           =>   '-', // UTF-8 hyphen to "normal" hyphen
        '/[’‘‹›‚]/u'    =>   ' ', // Literally a single quote
        '/[“”«»„]/u'    =>   ' ', // Double quote
        '/ /'           =>   ' ', // nonbreaking space (equiv. to 0x160)
        );
    return preg_replace(array_keys($utf8), array_values($utf8), $text);
}
add_action( 'admin_enqueue_scripts', 'eight_sec_media_uploader' );
function eight_sec_media_uploader( $hook )
{
    wp_enqueue_style( 'admin-style', get_template_directory_uri().'/inc/admin-panel/css/admin.css' );
    wp_enqueue_script('eightsec-admin-welcome', get_template_directory_uri().'/inc/admin-panel/js/admin.js', array('jquery'),'1.0',true);
    wp_localize_script( 'eightsec-admin-welcome', 'eightsecWelcomeObject', array(
        'admin_nonce'   => wp_create_nonce('eight_sec_plugin_installer_nonce'),
        'activate_nonce'    => wp_create_nonce('eight_sec_plugin_activate_nonce'),
        'ajaxurl'       => esc_url( admin_url( 'admin-ajax.php' ) ),
        'activate_btn' => esc_html__('Activate', 'eight-sec'),
        'installed_btn' => esc_html__('Activated', 'eight-sec'),
        'demo_installing' => esc_html__('Installing Demo', 'eight-sec'),
        'demo_installed' => esc_html__('Demo Installed', 'eight-sec'),
        'demo_confirm' => esc_html__('Are you sure to import demo content ?', 'eight-sec'),
        ) );
}
?>