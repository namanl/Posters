<?php
/**
 * The template for displaying the Search Form
 *
 * The area of the page that contains comments and the comment form.
 *
 * @package wlow
 */
 ?>
 <form class="search-light" role="search" method="get" action="<?php echo esc_url_raw(home_url()); ?>">

    <input type="text" placeholder="<?php esc_html_e('Search', 'wlow'); ?>" name="s">

    <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>

</form>
