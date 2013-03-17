<?php
/**
 * The Sidebar contains a list of categories
 *
 * @package Looplet
 * @since Looplet 1.0
 */
?>

<nav id="nav">
		<?php
/*****************************************************************
*
* alchymyth 2011
* a hierarchical list of all categories, with linked post titles
*
******************************************************************/
// http://codex.wordpress.org/Function_Reference/get_categories
 
 foreach( get_categories('hide_empty=1','order_by=name') as $cat ) :
 if( !$cat->parent ) {
 echo '<h2 class="navtitle"><a href="#">' . $cat->name . '</a></h2><ul class="navitems">';
 process_cat_tree( $cat->term_id );
 }
 endforeach;
 
 wp_reset_query(); //to reset all trouble done to the original query
//
function process_cat_tree( $cat ) {
 
 $args = array('category__in' => array( $cat ), 'numberposts' => -1, 'orderby' => 'title', 'order' => 'ASC');
 $cat_posts = get_posts( $args );
 
 if( $cat_posts ) :
 foreach( $cat_posts as $post ) :
 echo '<li>';
 echo '<a href="' . get_permalink( $post->ID ) . '">' . $post->post_title . '</a>';
 echo '</li>';
 endforeach;
 endif;
 
 $next = get_categories('hide_empty=0&parent=' . $cat);
 
 if( $next ) :
 foreach( $next as $cat ) :
 echo '<ul><li><strong>' . $cat->name . '</strong></li>';
 process_cat_tree( $cat->term_id );
 endforeach;
 endif;
 
 echo '</ul>';
}
?>


</nav>
