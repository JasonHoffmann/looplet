<?php
/**
 * @package Looplet
 * @since Looplet 1.0
 */
?>
<div class="mod group">
	
	<header class="looplethead">
		<h3 class="label">Looplet</h3>
		<h4 class="loopletlabel">
			<?php the_category(' '); ?> 
			<span class="sep">&rarr;</span> 
			<?php the_title(); ?>
		</h4>
	</header>
	
<?php $key="html-before"; echo get_post_meta($post->ID, $key, true); ?>
<?php 
/* First we need to set the HTML/PHP Variable */
$debugOutput = '';
/* Bring in the data from our Custom Fields */
$code = get_post_meta($post->ID, 'html', true);
$post_page_meta_value = get_post_meta($post->ID, 'post-page', true);
$category_value = get_post_meta($post->ID, 'category', true);
$orderby_value = get_post_meta($post->ID, 'orderby', true);
$order_value = get_post_meta($post->ID, 'order', true);
$include_value = get_post_meta($post->ID, 'include', true);
$exclude_value = get_post_meta($post->ID, 'exclude', true);
$metakey_value = get_post_meta($post->ID, 'meta-key', true);
$metavalue_value = get_post_meta($post->ID, 'meta-value', true);
$customphp_value = get_post_meta($post->ID, 'customphp', true);

?>

<?php
/* The Loop parameters are set by the user in Custom Fields */
$args = array( 
'posts_per_page' => $post_page_meta_value,
'category' => $category_value,
'orderby' => $orderby_value,
'order' => $order_value,
'include' => $include_value,
'exclude' => $exclude_value,
'meta_key' => $metakey_value,
'meta_value' => $metavalue_value,
'post_type' => 'looplet',
	);

/* Start the Loop */
$the_loop_query = new WP_Query( $args );

while ( $the_loop_query->have_posts() ) :
		$the_loop_query->the_post();
		
/* Eval and Echo the code from the HTML/PHP Field */
if ($code) {
    ob_start();
    eval('?>' . $code);
    $debugOutput = ob_get_clean();
}

echo $debugOutput;

/* Reset The Loop */
endwhile; 

wp_reset_postdata();
 ?>
 
<?php $key="html-after"; echo get_post_meta($post->ID, $key, true); ?>

</div>

<div class="cf row">

	<!-- Show the HTML and PHP using Prism.js -->
	<div class="mod dark grid-3">
		<h3 class="label">HTML/PHP</h3>
		<?php 
		$key="html"; 
		echo '<pre class="codeblock"><code class="language-markup">' . htmlspecialchars(get_post_meta($post->ID, $key, true)) . '</code></pre>'; ?>	
	</div>
			
	<!-- Show the CSS using Prism.js -->
	<div id="style" class="mod dark grid-3 flow-opposite">
		<h3 class="label">CSS</h3> 
		<?php 
		$key="css"; 
		echo '<pre class="codeblock"><code class="language-css">' . htmlspecialchars(get_post_meta($post->ID, $key, true)) . '</code></pre>'; ?>
	</div>
	
</div>


<div class="cf row">
	
	<!--Show the Outputed HTML for reference -->
	<div class="mod dark grid-full">
		<h3 class="label">Output HTML</h3>
		
<?php 
/* Need to Set up All the Variables Again and Reset the Loop */
$debugOutput = '';
/* Bring in the data from our Custom Fields */
$code = get_post_meta($post->ID, 'html', true);
$post_page_meta_value = get_post_meta($post->ID, 'post-page', true);
$category_value = get_post_meta($post->ID, 'category', true);
$orderby_value = get_post_meta($post->ID, 'orderby', true);
$order_value = get_post_meta($post->ID, 'order', true);
$include_value = get_post_meta($post->ID, 'include', true);
$exclude_value = get_post_meta($post->ID, 'exclude', true);
$metakey_value = get_post_meta($post->ID, 'meta-key', true);
$metavalue_value = get_post_meta($post->ID, 'meta-value', true);

/* The Loop parameters are set by the user in Custom Fields */
$args = array( 
'posts_per_page' => $post_page_meta_value,
'category' => $category_value,
'orderby' => $orderby_value,
'order' => $order_value,
'include' => $include_value,
'exclude' => $exclude_value,
'meta_key' => $metakey_value,
'meta_value' => $metavalue_value,
'post_type' => 'looplet',
	); ?>
	
<pre class="codeblocksmall"><code class="language-markup">
<?php
/* Start the Loop */
$the_loop_query = new WP_Query( $args );
while ( $the_loop_query->have_posts() ) :
		$the_loop_query->the_post(); ?>
<!-- This time we use Prism.js to show the outputted HTML -->
<?php
/* Eval and Echo the code from the HTML/PHP Field */
if ($code) {
    ob_start();
    eval('?>' . $code);
    $debugOutput = ob_get_clean();
}

 echo htmlspecialchars($debugOutput); 
?>	
<?php 
/* Reset the Loop Again */
endwhile; wp_reset_postdata(); ?>
</code></pre>
	
	</div>

</div>

<div>

	<!-- Main Content is shown as Notes -->
	<div id="pattern-notes" class="mod">
		<h3 class="label">Notes</h3>
			<?php the_content(); ?>
	</div>

</div>
