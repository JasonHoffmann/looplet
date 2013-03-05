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
		register_uninstall_hook( __FILE__, array( $this, 'uninstall' ) );

	} // end constructor
	
	/**
	 * Fired when the plugin is activated.
	 *
	 * Insert Dummy Content when the plugin is activated
	 */
	public function activate( $network_wide ) {
	
			include 'dummycontent.php';
			foreach ($add_posts_array as $post){
	        wp_insert_post( $post );
	        

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