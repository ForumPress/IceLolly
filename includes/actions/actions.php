<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/** CUSTOM POST TYPES ********************************************************/

// ADD CUSTOM POST TYPE 'FORUMS'
add_action( 'init', 'fp_forum_post_type' );

// ADD CUSTOM POST TYPE 'TOPICS'
add_action( 'init', 'fp_topics_post_type' );

// ADD CUSTOM POST TYPE 'REPLIES'
add_action( 'init', 'fp_replies_post_type' );

/** CUSTOM URLS ********************************************************/


/** CUSTOM TAXONOMIES ********************************************************/

// REGISTER CUSTOM TAONOMIES
add_action( 'init', 'fp_register_taxonomies' );

/** CUSTOM METABOXES ********************************************************/

// REGISTER FORUM ATTRIBUTES METABOX
add_action('admin_init', 'add_forum_attributes_metabox');

// SAVE FORUM ATTRIBUTES METABOX
add_action('save_post', 'save_forum_attributes_metabox', 1, 2);

/** CUSTOM COLUMNS ********************************************************/

// DISPLAY FORUM TYPE IN FORUM ADMIN
add_filter('manage_posts_columns', 'fp_forum_type');
add_action('manage_posts_custom_column', 'fp_show_forum_type', 1, 2);

// DISPLAY TOPIC COUNT IN FORUM ADMIN
add_filter('manage_posts_columns', 'fp_topics_column');
add_action('manage_posts_custom_column', 'fp_topics_count', 1, 2);

// DISPLAY POST COUNT IN FORUM ADMIN
add_filter('manage_posts_columns', 'fp_posts_column');
add_action('manage_posts_custom_column', 'fp_post_count', 1, 2);

/** CUSTOM TEMPLATES ********************************************************/
add_filter( 'template_include', 'fp_template');

/** Style  ******************************************************************/
add_action( 'wp_enqueue_scripts', 'fp_styles' );

?>