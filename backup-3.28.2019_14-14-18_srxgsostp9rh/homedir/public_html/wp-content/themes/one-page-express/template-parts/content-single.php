<div id="post-<?php the_ID();?>"<?php post_class();?>>
  <div class="post-content-single">
    <h2 class="heading109"> <?php the_title(); ?></h2>
    <?php get_template_part('template-parts/content-post-single-header') ?>
    <div class="post-content-inner">
      <?php
          if (has_post_thumbnail()) {
              the_post_thumbnail();
          }

          the_content();
          
          wp_link_pages(array(
              'before'      => '<div class="page-links"><span class="page-links-title">' . __('Pages:', 'one-page-express') . '</span>',
              'after'       => '</div>',
              'link_before' => '<span>',
              'link_after'  => '</span>',
              'pagelink'    => '<span class="screen-reader-text">' . __('Page', 'one-page-express') . ' </span>%',
              'separator'   => '<span class="screen-reader-text">, </span>',
          ));
      ?>
    </div>
    
    <?php echo get_the_tag_list('<p><i data-cp-fa="true" class="font-icon-25 fa fa-tags"></i>&nbsp;', ' ', '</p>'); ?>
  </div>


  <?php
      the_post_navigation(array(
          'next_text' => '<span class="meta-nav" aria-hidden="true">' . __('Next:', 'one-page-express') . '</span> ' .
          '<span class="screen-reader-text">' . __('Next post:', 'one-page-express') . '</span> ' .
          '<span class="post-title">%title</span>',
          'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __('Previous:', 'one-page-express') . '</span> ' .
          '<span class="screen-reader-text">' . __('Previous post:', 'one-page-express') . '</span> ' .
          '<span class="post-title">%title</span>',
      ));
  ?>

 
    <?php 
      if (comments_open() || get_comments_number()):
        comments_template();
      endif;
    ?>
</div>