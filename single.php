<?php while (have_posts()) : the_post(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <?php get_template_part( 'templates/entry-single', get_post_type() ); ?>
</article>
<?php endwhile; ?>
<?php
/**
 * grabs the buttons & development navbar if the post belongs to
 * the available or past properties post-type
 */
if(in_category(array(24, 14))) {
  get_template_part('templates/partials/custom-buttons');
  get_template_part('templates/partials/development-navbar');
}
