<?php one_page_express_get_header();?>

<div class="page-content">
  <div class="gridContainer">
   <?php 
      while ( have_posts() ) : the_post();
        get_template_part( 'template-parts/content', 'page' );
      endwhile;
     ?>
  </div>
</div>

<?php one_page_express_get_footer(); ?>