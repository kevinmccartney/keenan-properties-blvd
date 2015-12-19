<header class="entry-title">
    <?php get_template_part( 'templates/entry-title' ); ?>
    <?php get_template_part( 'templates/entry-meta' ); ?>
</header>
<section class="entry-content">
    <?php
    // this hides the featured media image for the development posts
    if ( in_category( array( 24, 14 ) ) ) {
        // do nothing
    } else {
        if ( has_action( 'hji_theme_featured_media' )  ) {
            do_action( 'hji_theme_featured_media' );
        } else {
            hji_theme_featured_image();
        }
    }
    the_content();
    ?>
    <div class="entry-links">
        <?php wp_link_pages(); ?>
    </div>
</section>
<footer>
<?php wp_link_pages(array('before' => '<nav class="pagination">', 'after' => '</nav>')); ?>
<?php
// no comment section if the posts are in the developments category
if ( in_category( array( 24, 14 ) ) ) {
    // do nothing
} else {
    do_action( 'hji_theme_before_comments' );
    comments_template('/templates/comments.php');
    do_action( 'hji_theme_after_comments' );
}
?>
</footer>
