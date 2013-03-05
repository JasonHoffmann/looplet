<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Looplet
 * @since Looplet 1.0
 */

get_header(); ?>
<?php 
/* Your Basic Loop */
while ( have_posts() ) : the_post(); 
?>

<!-- CSS Styles imported from Custom Field -->
<style id="s" type="text/css">
	<?php 
		$key="css"; 
		echo get_post_meta($post->ID, $key, true); 
	?>
</style>

	<div class="cf row">
	
		<div class="grid-5 flow-opposite">
			<?php get_template_part( 'content', 'single' ); ?>
			<?php endwhile; // end of the loop. ?>			
		</div>
				
		<div class="grid-1">
			<?php get_sidebar(); ?>
		</div>
				
	</div>


<?php get_footer(); ?>