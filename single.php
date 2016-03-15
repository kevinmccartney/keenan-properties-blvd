<?php 
/**
 * grabs the buttons & development navbar if the post belongs to
 * the 'available-properties' or 'past projects' post categories
 */

while ( have_posts() ) : the_post();
	
	echo '<article id="post-' . the_ID(); . post_class(); . '">';
  		
  		get_template_part( 'templates/entry-single', get_post_type() );
	
	echo '</article>' 

endwhile;

if( in_category( array( 'available-properties', 'past projects' ) ) ) :
	
	get_template_part( 'templates/partials/custom-buttons' );
	
	get_template_part( 'templates/partials/development-navbar' );

endif;
