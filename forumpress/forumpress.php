<?php
   /*
   Plugin Name: ForumPress
   Plugin URI: https://forumpress.co.uk
   Description: The ultimate forum software for WordPress - Create powerful forums easily with ForumPress!
   Version: 0.1
   Author: ForumPress
   Author URI: https://forumpress.co.uk
   License: GPL2
   */


// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// Core Includes
include plugin_dir_path( __FILE__ ) . 'includes/functions.php';
include plugin_dir_path( __FILE__ ) . 'includes/admin/admin.php';
include plugin_dir_path( __FILE__ ) . 'includes/actions/actions.php';
include plugin_dir_path( __FILE__ ) . 'includes/metaboxes/metaboxes.php';

// Common Includes
include plugin_dir_path( __FILE__ ) . 'includes/shortcodes.php';

// FORUMPRESS VERSION CHECK
function forumpress_current_version(){
    $version = get_option( 'FORUMPRESS_VERSION' );
    return version_compare($version, FORUMPRESS_VERSION, '=') ? true : false;
}

register_activation_hook( __FILE__, 'AddThisPage' );

function AddThisPage() {
    global $wpdb; // Not sure if you need this, maybe

    $page = array(
        'post_title' => 'New Topic',
        'post_name' => 'new-topic',
        'post_content' => 'This is my post.',
        'post_status' => 'publish',
        'post_author' => 1,
        'post_type' => 'forums'
    );


        $insert = wp_insert_post( $page );
   

}

register_activation_hook( __FILE__, 'activate_forumpress' );
// END INSTALL FORUMPRESS

register_deactivation_hook( __FILE__, 'deactivate_forumpress' );
// END DEACTIVATE FORUMPRESS

if ( ! defined( 'FORUMPRESS_BASE_FILE' ) )
    define( 'FORUMPRESS_BASE_FILE', __FILE__ );
if ( ! defined( 'FORUMPRESS_BASE_DIR' ) )
    define( 'FORUMPRESS_BASE_DIR', dirname( FORUMPRESS_BASE_FILE ) );
if ( ! defined( 'FORUMPRESS_PLUGIN_URL' ) )
    define( 'FORUMPRESS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Add reply count to forums
add_action( 'manage_book_posts_custom_column' , 'custom_book_column', 10, 2 );

?>