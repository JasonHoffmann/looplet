<?php
/*
Plugin Name: Looplet Companion
Plugin URI: 
Description: Adds the Looplet custom post type and dummy content.
Version: 1.0
Author: Jason Hoffmann
Author URI: https://twitter.com/jaydhoffmann
Author Email: jhoffm34@gmail.com
License:

  Copyright 2013 Jason Hoffmann

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as 
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
  
*/

class Looplet {
	 
	/*--------------------------------------------*
	 * Constructor
	 *--------------------------------------------*/
	
	/**
	 * Initializes the plugin by setting localization, filters, and administration functions.
	 */
	function __construct() {
		
	/**
	 * First Thing to do is install the Looplet custom post type
	 */
		function looplet_custom_type () {
		$labels = array(
		'name'               => __( 'Looplet' ),
		'singular_name'      => __( 'Looplet' ),
		'add_new'            => __( 'Add New Dummy Post', 'book' ),
		'not_found'          => __( 'No dummy posts found' ),
		'not_found_in_trash' => __( 'No dummy posts found in the Trash' ), 
		'parent_item_colon'  => '',
		'menu_name'          => 'Looplet'
		);
		$args = array(
		'labels'        => $labels,
		'description'   => 'Contains dummy posts for use in your Looplets',
		'public'        => true,
		'menu_position' => 5,
		'supports'      => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'custom-fields', 'revisions', 'page-attributes', 'post-formats', 'cats' ),
		'has_archive'   => false,
		'taxonomies' => array('category', 'post_tag'),
		);
		register_post_type( 'looplet', $args );	
		}
		
		add_action( 'init', 'looplet_custom_type' );

		// Register admin styles and scripts
		add_action( 'admin_print_styles', array( $this, 'register_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts' ) );
	
		// Register site styles and scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'register_plugin_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_plugin_scripts' ) );
	
		// Register hooks that are fired when the plugin is activated, deactivated, and uninstalled, respectively.
		register_activation_hook( __FILE__, array( $this, 'activate' ) );
		register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );
		register_uninstall_hook( __FILE__, 'uninstall');

	} // end constructor
	
	/**
	 * Fired when the plugin is activated.
	 *
	 * Insert Dummy Content when the plugin is activated
	 */
	public function activate( $network_wide ) {
			include 'dummycontent.php';

				$siteaddress = get_site_url();
				/* Images From http://lorempixel.com/ */
				$image1 = $siteaddress . '/wp-content/plugins/looplet-plugin/images/abstract.jpg';
				$image2 = $siteaddress . '/wp-content/plugins/looplet-plugin/images/arch.jpg';
				$image3 = $siteaddress . '/wp-content/plugins/looplet-plugin/images/cat.jpg';
				$image4 = $siteaddress . '/wp-content/plugins/looplet-plugin/images/dog.jpg';
				$image5 = $siteaddress . '/wp-content/plugins/looplet-plugin/images/hair.jpg';
				$image6 = $siteaddress . '/wp-content/plugins/looplet-plugin/images/hardatwork.jpg';
				$image7 = $siteaddress . '/wp-content/plugins/looplet-plugin/images/person.jpg';
				$image8 = $siteaddress . '/wp-content/plugins/looplet-plugin/images/phone.jpg';
				$image9 = $siteaddress . '/wp-content/plugins/looplet-plugin/images/river.jpg';
				$image10 = $siteaddress . '/wp-content/plugins/looplet-plugin/images/taxi.jpg';
				$image_url = array ( 
					'a' => $image1, 
					'b' => $image2, 
					'c' => $image3, 
					'd' => $image4, 
					'e' => $image5, 
					'f' => $image6, 
					'g' => $image7,
					'h' => $image8,
					'i' => $image9,
					'j' => $image10
				);

				$mytags = array ( 'a' => 'tag1', 'b' => 'tag2', 'c' => 'tag3', 'd' => 'tag4', 'e' => 'tag5', 'f' => 'tag6', 'g' => 'tag7', 'h' => 'tag8', 'i' => 'tag9', 'j' => 'tag10' );
				$mycats = array ( 'a' => 'category-1', 'b' => 'category-2', 'c' => 'category-3' );

			foreach ($add_posts_array as $post){
				$post_id = wp_insert_post( $post );
	        	
	        	$key_tag = array_rand($mytags, 2);
	        	$value_tag_1 = $mytags[$key_tag[0]];
	        	$value_tag_2 = $mytags[$key_tag[1]];

	        	$key_cat = array_rand($mycats);
	        	$value_cat = $mycats[$key_cat];
	        	$taxonomy = 'category';

	        	$key = array_rand($image_url);
				$value = $image_url[$key];

				$upload_dir = wp_upload_dir();
				$image_data = file_get_contents($value);
				$filename = basename($value);
				if(wp_mkdir_p($upload_dir['path'])) {
    				$file = $upload_dir['path'] . '/' . $filename;
				} else {
    				$file = $upload_dir['basedir'] . '/' . $filename;
    			}
				file_put_contents($file, $image_data);

				$wp_filetype = wp_check_filetype($filename, null );
				$attachment = array(
    				'post_mime_type' => $wp_filetype['type'],
   					'post_title' => sanitize_file_name($filename),
    				'post_content' => '',
    				'post_status' => 'inherit'
					);
				$attach_id = wp_insert_attachment( $attachment, $file, $post_id );
				require_once(ABSPATH . 'wp-admin/includes/image.php');
				$attach_data = wp_generate_attachment_metadata( $attach_id, $file );
				wp_update_attachment_metadata( $attach_id, $attach_data );
				set_post_thumbnail( $post_id, $attach_id );
				wp_set_post_terms ( $post_id, array( $value_tag_1, $value_tag_2 ), 'post_tag');
				wp_set_object_terms( $post_id, array( $value_cat ), 'category' );
	       	    };
	        


	} // end activate
	
	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @param	boolean	$network_wide	True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog 
	 */
	public function deactivate( $network_wide ) {
 				
 				$args = array (
    				'post_type' => 'Looplet',
    				'nopaging' => true
  				);
  				
  				/* Find all the Posts in the Looplet Post type and delete them */
  				$query = new WP_Query ($args);
  				while ($query->have_posts ()) {
    				$query->the_post ();
   					$id = get_the_ID ();
   					$thumbid = get_post_thumbnail_id();
   					/* Delete all Post Thumbnails from the media library first */
   					wp_delete_attachment ( $id, true);
    				wp_delete_post ($thumbid, true);
    				/* Now delte all posts from Looplet */
    				wp_delete_post ($id, true);
  				}
  				
  				wp_reset_postdata ();	
  				
	} // end deactivate
	
	/**
	 * Fired when the plugin is uninstalled.
	 *
	 * @param	boolean	$network_wide	True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog 
	 */
	public function uninstall( $network_wide ) {
		
	} // end uninstall

	/**
	 * Registers and enqueues admin-specific styles.
	 */
	public function register_admin_styles() {
	
		wp_enqueue_style( 'looplet-admin-styles', plugins_url( 'plugin-name/css/admin.css' ) );
	
	} // end register_admin_styles

	/**
	 * Registers and enqueues admin-specific JavaScript.
	 */	
	public function register_admin_scripts() {
	
		wp_enqueue_script( 'looplet-admin-script', plugins_url( 'plugin-name/js/admin.js' ) );
	
	} // end register_admin_scripts
	
	/**
	 * Registers and enqueues plugin-specific styles.
	 */
	public function register_plugin_styles() {
	
		wp_enqueue_style( 'looplet-plugin-styles', plugins_url( 'plugin-name/css/display.css' ) );
	
	} // end register_plugin_styles
	
	/**
	 * Registers and enqueues plugin-specific scripts.
	 */
	public function register_plugin_scripts() {
	
		wp_enqueue_script( 'looplet-plugin-script', plugins_url( 'plugin-name/js/display.js' ) );
	
	} // end register_plugin_scripts
	
} // end class

$plugin_name = new Looplet();
