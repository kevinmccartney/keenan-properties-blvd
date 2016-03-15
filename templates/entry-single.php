<header class="entry-title">
    
    <?php get_template_part( 'templates/entry-title' ); ?>
    
    <?php get_template_part( 'templates/entry-meta' ); ?>

</header>

<section class="entry-content">
    
    <?php // this hides the featured media image for posts in the 'available-properties' or 'past projects' post categories
    
    if( !in_category( array( 'available-properties', 'past projects' ) ) ) :
        
        if ( has_action( 'hji_theme_featured_media' ) ) :
            
            do_action( 'hji_theme_featured_media' );
        
        else :
            
            hji_theme_featured_image();
        
        endif;
    
    endif;
    
    the_content(); ?>
    
    <div class="entry-links">
        
        <?php wp_link_pages(); ?>
    
    </div>

</section>

<footer>

<?php wp_link_pages( array('before' => '<nav class="pagination">', 'after' => '</nav>') ); ?>

<?php // no comment section if the posts are in the developments category

if ( !in_category( array( 'available-properties', 'past projects' ) ) ) :
    
    do_action( 'hji_theme_before_comments' );
    
    comments_template( '/templates/comments.php' );
    
    do_action( 'hji_theme_after_comments' );

endif; ?>

</footer>
