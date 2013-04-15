<?php
/**
 * Looplet functions and definitions
 *
 * @package Looplet
 * @since Looplet 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Looplet 1.0
 */
if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */

/*
 * Load Jetpack compatibility file.
 */
require( get_template_directory() . '/inc/jetpack.php' );

if ( ! function_exists( 'looplet_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since Looplet 1.0
 */
function looplet_setup() {

	/**
	 * Custom template tags for this theme.
	 */
	require( get_template_directory() . '/inc/template-tags.php' );

	/**
	 * Custom functions that act independently of the theme templates
	 */
	require( get_template_directory() . '/inc/extras.php' );

	/**
	 * Customizer additions
	 */
	require( get_template_directory() . '/inc/customizer.php' );

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on Looplet, use a find and replace
	 * to change 'looplet' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'looplet', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'looplet' ),
	) );

	/**
	 * Enable support for Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );
}
endif; // looplet_setup
add_action( 'after_setup_theme', 'looplet_setup' );

/**
 * Setup the WordPress core custom background feature.
 *
 * Use add_theme_support to register support for WordPress 3.4+
 * as well as provide backward compatibility for WordPress 3.3
 * using feature detection of wp_get_theme() which was introduced
 * in WordPress 3.4.
 *
 * @todo Remove the 3.3 support when WordPress 3.6 is released.
 *
 * Hooks into the after_setup_theme action.
 */
function looplet_register_custom_background() {
	$args = array(
		'default-color' => 'ffffff',
		'default-image' => '',
	);

	$args = apply_filters( 'looplet_custom_background_args', $args );

	if ( function_exists( 'wp_get_theme' ) ) {
		add_theme_support( 'custom-background', $args );
	} else {
		define( 'BACKGROUND_COLOR', $args['default-color'] );
		if ( ! empty( $args['default-image'] ) )
			define( 'BACKGROUND_IMAGE', $args['default-image'] );
		add_custom_background();
	}
}
add_action( 'after_setup_theme', 'looplet_register_custom_background' );

/**
 * Register widgetized area and update sidebar with default widgets
 *
 * @since Looplet 1.0
 */
function looplet_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Sidebar', 'looplet' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );
}
add_action( 'widgets_init', 'looplet_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function looplet_scripts() {
	wp_enqueue_style( 'style', get_stylesheet_uri() );
	wp_enqueue_style('reset', get_template_directory_uri() . '/reset.css',false,'1.1','all');	

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
}
add_action( 'wp_enqueue_scripts', 'looplet_scripts' );

/**
 * And Just a Couple of Admin Styles to Add
 */
function load_custom_wp_admin_style() {
        wp_register_style( 'custom_wp_admin_css', get_bloginfo( 'stylesheet_directory' ) . '/admin-style.css', false, '1.0.0' );
        wp_enqueue_style( 'custom_wp_admin_css' );
}
add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style' );


/**
 * Bring in Custom Meta Box
 */
 /* We're going to use the Meta Boxes in the Post Editor */
 add_action( 'load-post.php', 'looplet_post_meta_boxes_setup' );
 add_action( 'load-post-new.php', 'looplet_post_meta_boxes_setup' );
 
/* Meta Box Function */
function looplet_post_meta_boxes_setup() {
 	
 	/* Meta Box Hook, where the magic happens */
 	add_action( 'add_meta_boxes', 'looplet_add_post_meta_boxes' );
 	
 	add_action( 'save_post', 'looplet_save_post_class_meta' );
 }
 
/* Add Our Meta Box */
function looplet_add_post_meta_boxes() {
 	
 	add_meta_box(
 		'looplet-class',
 		esc_html__( 'Post Class', 'example' ),
 		'looplet_post_class_meta_box',
 		'post',
 		'normal',
 		'high'
 	);
 }
 
 
/* Set Up Security for the Meta Box input */
function looplet_post_class_meta_box( $post ){  
wp_nonce_field( basename( __FILE__ ), 'looplet_post_class_nonce' ); ?>

<!-- First HTML Meta Box for before the Loop -->
<p>

<label for="html" class="lightertext">
<?php _e( "Add Your HTML Before The Loop Here", 'example' ); ?>
</label>
	
	<br />
	
<textarea id="html-before" name="html-before" rows="5" cols="90" /><?php echo esc_attr( get_post_meta($post->ID, 'html-before', true) ); ?></textarea>

</p>

<p>
<pre>
<?php echo htmlspecialchars('<?php $args = array('); ?>
</pre>

<?php 
/* Need to make sure that posts_per_page is set to 1 by default */
$posts_page_value = get_post_meta($post->ID, 'post-page', true);
	if ( $posts_page_value == null ) {
			$posts_page_value = '1';
		} ?>

<!-- Admin Menu for Custom Fields -->
	<label for="post-page" class="mono"><?php _e( "'posts_per_page' =>", 'example' ); ?></label>
	<input type="text" name="post-page" id="post-page" value="<?php echo esc_attr( $posts_page_value ); ?>" size="3" />
	<p class="lightertext"><em>(int)</em> Number of posts to display. Use "-1" to display all posts within query</p><br />

	<label for="author" class="mono"><?php _e( "'author' =>", 'example' ); ?></label>
	<input type="text" name="author" id="author" value="<?php echo esc_attr( get_post_meta($post->ID, 'author', true) ); ?>" size="3" /> 
	<p class="lightertext"><em>(int)</em> Author ID should be used. You can specify multiple authors ('author' => 2,7,8)</p><br />

	<label for="categoryname" class="mono"><?php _e( "'category_name' =>", 'example' ); ?></label>
	<input type="text" name="categoryname" id="categoryname" value="<?php echo esc_attr( get_post_meta($post->ID, 'categoryname', true) ); ?>" size="3" />
	<p class="lightertext"><em>(slug)</em> Category slug (not name) should be used.<br />
	Imported slugs include "category-1", "category-2" and "category-3"</p>
	
	<label for="category" class="mono"><?php _e( "'cat' =>", 'example' ); ?></label>
	<input type="text" name="category" id="category" value="<?php echo esc_attr( get_post_meta($post->ID, 'category', true) ); ?>" size="3" />
	<p class="lightertext"><em>(int)</em> Category ID should be used. Negative value will exclude a category ('cat' => -12). You can specify multiple categories (e.g. 'cat' => 2,7,8)</p><br />
	
	<label for="tag" class="mono"><?php _e( "'tag' =>", 'example' ); ?></label>
	<input type="text" name="tag" id="tag" value="<?php echo esc_attr( get_post_meta($post->ID, 'tag', true) ); ?>" size="3" />
	<p class="lightertext"><em>(string)</em> Tag Name should be used. You can specify multiple tags (e.g. 'tag' => 'food, movies'). + sign displays post in <em>all</em> (e.g. 'tag' => 'food+movies')<br />
	Imported tags include "tag1", "tag2", "tag3", "tag4", "tag5", "tag6", "tag7"</p>

	<label for="search" class="mono"><?php _e( "'s' =>", 'example' ); ?></label>
	<input type="text" name="search" id="search" value="<?php echo esc_attr( get_post_meta($post->ID, 'search', true) ); ?>" size="3" />
	<p class="lightertext"><em>(string)</em> Keyword search. Retrieves posts that match the search term.</p><br />

	<label for="postid" class="mono"><?php _e( "'p' =>", 'example' ); ?></label>
	<input type="text" name="postid" id="postid" value="<?php echo esc_attr( get_post_meta($post->ID, 'postid', true) ); ?>" size="3" />
	<p class="lightertext"><em>(int)</em> Match Post ID. Multiple Post IDs can be used (e.g. 'p' => 2,5,6).</p><br />

	<label for="pageid" class="mono"><?php _e( "'page_id' =>", 'example' ); ?></label>
	<input type="text" name="pageid" id="pageid" value="<?php echo esc_attr( get_post_meta($post->ID, 'pageid', true) ); ?>" size="3" />
	<p class="lightertext"><em>(int)</em> Match Page ID. Multiple Page IDs can be used (e.g. 'page_id' => 2,5,6).</p><br />

	<label for="poststatus" class="mono"><?php _e( "'post_status' =>", 'example' ); ?></label>
	<input type="text" name="poststatus" id="poststatus" value="<?php echo esc_attr( get_post_meta($post->ID, 'poststatus', true) ); ?>" size="3" />
	<p class="lightertext"><em>(string | array)</em> Post Status (e.g. 'post_status' => 'draft'). Can use array with multiple values (e.g. 'post_status' => array( 'draft', 'pending') )/</p>

	<label for="orderby" class="mono"><?php _e( "'orderby' =>", 'example' ); ?></label>
	<input type="text" name="orderby" id="orderby" value="<?php echo esc_attr( get_post_meta($post->ID, 'orderby', true) ); ?>" size="3" />
	<p class="lightertext"><em>(string)</em> Order by id, title, author, etc. (e.g. 'orderby' => 'date')</p><br />

	<label for="order" class="mono"><?php _e( "'order' =>", 'example' ); ?></label>
	<input type="text" name="order" id="order" value="<?php echo esc_attr( get_post_meta($post->ID, 'order', true) ); ?>" size="3" />
	<p class="lightertext"><em>(string)</em> ASC (ascending) or DESC (descending). (e.g. 'order' => 'ASC')</p><br />
	
	<label for="meta-key" class="mono"><?php _e( "'meta_key' =>", 'example' ); ?></label>
	<input type="text" name="meta-key" id="meta-key" value="<?php echo esc_attr( get_post_meta($post->ID, 'meta-key', true) ); ?>" size="3" />
	<p class="lightertext"><em>(string)</em> Retrieve posts from a specific custom field key. (e.g. 'meta-key' => 'color')</p><br />
	
	<label for="meta-value" class="mono"><?php _e( "'meta_value' =>", 'example' ); ?></label>
	<input type="text" name="meta-value" id="meta-value" value="<?php echo esc_attr( get_post_meta($post->ID, 'meta-value', true) ); ?>" size="3" />
	<p class="lightertext"><em>(string)</em> References meta-key. Retrieve posts from a specific value within specific key. (e.g. 'meta-value' => 'blue')</p><br />
	
	<pre>'post_type' => 'looplet',</pre>

<!-- Print the Loop in the Admin Menu -->
<pre>);
$the_loop_query = new WP_Query( $args );
while ( $the_loop_query->have_posts() ) :
		$the_loop_query->the_post();</pre>
</p>

<!-- Now the HTML Meta Box -->
<p>

	<label for="html" class="lightertext">
		<?php _e( "Add Your PHP/HTML In the Loop Here", 'example' ); ?>
	</label>
	
	<br />
	
<textarea id="html" name="html" rows="10" cols="90" /><?php echo esc_attr( get_post_meta($post->ID, 'html', true) ); ?></textarea>

</p>

<!-- First HTML Meta Box for after the Loop is closed -->
<p>

<label for="html-after" class="lightertext">
<?php _e( "Add Your HTML After The Loop Here", 'example' ); ?>
</label>
	
	<br />
	
<textarea id="html-after" name="html-after" rows="5" cols="90" /><?php echo esc_attr( get_post_meta($post->ID, 'html-after', true) ); ?></textarea>

</p>

<!-- And the CSS Meta Box -->
<p>

	<label for="css" class="lightertext">
		<?php _e( "Add Custom CSS Here", 'example' ); ?>
	</label>
	
	<br />
	
<textarea id="css" name="css" rows="20" cols="90" /><?php echo get_post_meta($post->ID, 'css', true); ?></textarea>
	
</p>
	
	
<?php }

/* Save Function for all of the Custom Fields */

function looplet_save_post_class_meta( $post_id ) {
    global $post;
    // Skip auto save
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return $post_id;
    }

   	    if( isset($_POST['html-before']) ) { update_post_meta( $post->ID, 'html-before', $_POST['html-before'] ); }
        if( isset($_POST['post-page']) ) { update_post_meta( $post->ID, 'post-page', $_POST['post-page'] ); }
        if( isset($_POST['author']) ) { update_post_meta( $post->ID, 'author', $_POST['author'] ); }
        if( isset($_POST['category']) ) { update_post_meta( $post->ID, 'category', $_POST['category'] ); }
        if( isset($_POST['categoryname']) ) { update_post_meta( $post->ID, 'categoryname', $_POST['categoryname'] ); }
        if( isset($_POST['tag']) ) { update_post_meta( $post->ID, 'tag', $_POST['tag'] ); }
        if( isset($_POST['search']) ) { update_post_meta( $post->ID, 'search', $_POST['search'] ); }
        if( isset($_POST['postid']) ) { update_post_meta( $post->ID, 'postid', $_POST['postid'] ); }
        if( isset($_POST['pageid']) ) { update_post_meta( $post->ID, 'pageid', $_POST['pageid'] ); }
        if( isset($_POST['poststatus']) ) { update_post_meta( $post->ID, 'poststatus', $_POST['poststatus'] ); }
        if( isset($_POST['orderby']) ) { update_post_meta( $post->ID, 'orderby', $_POST['orderby'] ); }
        if( isset($_POST['order']) ) { update_post_meta( $post->ID, 'order', $_POST['order'] ); }
        if( isset($_POST['meta-key']) ) { update_post_meta( $post->ID, 'meta-key', $_POST['meta-key'] ); }
        if( isset($_POST['meta-value']) ) { update_post_meta( $post->ID, 'meta-value', $_POST['meta-value'] ); }
        if( isset($_POST['html']) ) { update_post_meta( $post->ID, 'html', $_POST['html'] ); }
        if( isset($_POST['html-after']) ) { update_post_meta( $post->ID, 'html-after', $_POST['html-after'] ); }
        if( isset($_POST['css']) ) { update_post_meta( $post->ID, 'css', $_POST['css'] ); }
}