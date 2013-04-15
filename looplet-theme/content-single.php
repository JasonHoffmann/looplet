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
	
<?php 
$debugOutputhtml = '';
$code_html = get_post_meta($post->ID, 'html-before', true);

/* Eval and Echo the code from the HTML/PHP before the loop Field */
if ($code_html) {
    ob_start();
    eval('?>' . $code_html);
    $debugOutputhtml = ob_get_clean();
}

echo $debugOutputhtml;

?>
<?php 
/* First we need to set the HTML/PHP Variable */
$debugOutput = '';
/* Bring in the data from our Custom Fields */
$code = get_post_meta($post->ID, 'html', true);
$post_page_meta_value = get_post_meta($post->ID, 'post-page', true);
$author_value = get_post_meta($post->ID, 'author', true);
$category_value = get_post_meta($post->ID, 'category', true);
$categoryname_value = get_post_meta($post->ID, 'categoryname', true);
$tag_value = get_post_meta($post->ID, 'tag', true);
$search_value = get_post_meta($post->ID, 'search', true);
$postid_value = get_post_meta($post->ID, 'postid', true);
$pageid_value = get_post_meta($post->ID, 'pageid', true);
$post_status_value = get_post_meta($post->ID, 'poststatus', true);
$orderby_value = get_post_meta($post->ID, 'orderby', true);
$order_value = get_post_meta($post->ID, 'order', true);
$metakey_value = get_post_meta($post->ID, 'meta-key', true);
$metavalue_value = get_post_meta($post->ID, 'meta-value', true);

?>

<?php
/* The Loop parameters are set by the user in Custom Fields */
$args = array( 
'posts_per_page' => $post_page_meta_value,
'author' => $author_value,
'cat' => $category_value,
'category_name' => $categoryname_value,
'tag' => $tag_value,
's' => $search_value,
'p' => $postid_value,
'page_id' => $pageid_value,
'post_status' => array( $post_status_value ),
'orderby' => ($orderby_value ? $orderby_value : null),
'order' => $order_value,
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
		echo '<div class="codeblock">';

		// Determine if there is any HTML/PHP Before the Loop to display
		if (get_post_meta($post->ID, 'html-before', true) != null) {
			echo '<pre><code class="language-markup">' . htmlspecialchars(get_post_meta($post->ID, 'html-before', true)) . '</code></pre>';
			echo '<hr>';
		} else { }

		echo '<pre><code class="language-markup">' . htmlspecialchars(get_post_meta($post->ID, 'html', true)) . '</code></pre>'; 

				// Determine if there is any HTML/PHP After the Loop to display
		if (get_post_meta($post->ID, 'html-after', true) != null) {
			echo '<hr>';
			echo '<pre><code class="language-markup">' . htmlspecialchars(get_post_meta($post->ID, 'html-after', true)) . '</code></pre>';
		} else { }

		echo '</div>'
		?>	
	</div>
			
	<!-- Show the CSS using Prism.js -->
	<div id="style" class="mod dark grid-3 flow-opposite">
		<h3 class="label">CSS</h3> 
		<?php  
		echo '<div class="codeblock">';
		echo '<code class="language-css">' . htmlspecialchars(get_post_meta($post->ID, 'css', true)) . '</code></pre>'; 
		echo '</div>';
		?>
	</div>
	
</div>


<div class="cf row">
		
<?php 
/* Need to Set up All the Variables Again and Reset the Loop */
$debugOutput = '';
/* Bring in the data from our Custom Fields */
$code = get_post_meta($post->ID, 'html', true);
$post_page_meta_value = get_post_meta($post->ID, 'post-page', true);
$author_value = get_post_meta($post->ID, 'author', true);
$category_value = get_post_meta($post->ID, 'category', true);
$categoryname_value = get_post_meta($post->ID, 'categoryname', true);
$tag_value = get_post_meta($post->ID, 'tag', true);
$search_value = get_post_meta($post->ID, 'search', true);
$postid_value = get_post_meta($post->ID, 'postid', true);
$pageid_value = get_post_meta($post->ID, 'pageid', true);
$post_status_value = get_post_meta($post->ID, 'poststatus', true);
$orderby_value = get_post_meta($post->ID, 'orderby', true);
$order_value = get_post_meta($post->ID, 'order', true);
$metakey_value = get_post_meta($post->ID, 'meta-key', true);
$metavalue_value = get_post_meta($post->ID, 'meta-value', true);

/* The Loop parameters are set by the user in Custom Fields */
$args = array( 
'posts_per_page' => $post_page_meta_value,
'author' => $author_value,
'cat' => $category_value,
'category_name' => $categoryname_value,
'tag' => $tag_value,
's' => $search_value,
'p' => $postid_value,
'page_id' => $pageid_value,
'post_status' => array( $post_status_value ),
'orderby' => ($orderby_value ? $orderby_value : null),
'order' => $order_value,
'meta_key' => $metakey_value,
'meta_value' => $metavalue_value,
'post_type' => 'looplet',
	); ?>

<!--Show the Loop for reference -->
<div class="mod dark grid-2">
<h3 class="label">Your Loop</h3>
<pre class="codeblocksmall"><code class="language-markup">
<?php 
	echo "\$args = array(\n"; 
	echo "'posts_per_page' => $post_page_meta_value,\n";
	echo "'author' => $author_value,\n";
	echo "'cat' => $category_value,\n";
	echo "'category_name' => $categoryname_value,\n";
	echo "'tag' => $tag_value,\n";
	echo "'s' => $search_value,\n";
	echo "'p' => $postid_value,\n";
	echo "'page_id' => $pageid_value,\n";
	echo "'post_status' => array( $post_status_value ),\n";
	echo "'orderby' => $orderby_value,\n";
	echo "'order' => $order_value,\n";
	echo "'meta_key' => $metakey_value,\n";
	echo "'meta_value' => $metavalue_value,\n";
	echo "'post_type' => 'looplet',\n";
	echo "\$the_loop_query = new WP_Query( \$args );\n";
	echo "while ( \$the_loop_query->have_posts() ) :\n";
	echo "\$the_loop_query->the_post();\n"


?>
</pre></code>
</div>

<!--Show the Outputed HTML for reference -->
<div class="mod dark grid-4 flow-opposite">
<h3 class="label">Output HTML</h3>

<!-- This time we use Prism.js to show the outputted HTML -->
<pre class="codeblocksmall"><code class="language-markup">
<?php
/* Start the Loop */
$the_loop_query = new WP_Query( $args );
while ( $the_loop_query->have_posts() ) :
		$the_loop_query->the_post(); ?>

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
