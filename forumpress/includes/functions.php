<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

function activate_forumpress() {


    flush_rewrite_rules();
    
}



function deactivate_forumpress() {


        flush_rewrite_rules();

    }
/** CUSTOM URLS ********************************************************/



/** CUSTOM POST TYPES ********************************************************/

// register custom post type forums
function fp_forum_post_type() {
	// set up labels
	$labels = array(
 		'name' => 'Forums',
    	'singular_name' => 'Forum',
    	'add_new' => 'Add New Forum',
    	'add_new_item' => 'Add New Forum',
    	'edit_item' => 'Edit Forum',
    	'new_item' => 'New Forum',
    	'all_items' => 'All Forums',
    	'view_item' => 'View Forum',
    	'search_items' => 'Search Forums',
    	'not_found' =>  'No Forums Found',
    	'not_found_in_trash' => 'No Forums found in Trash', 
    	'parent_item_colon' => 'Category:',
    	'menu_name' => 'Forums',
    );
    //register post type
	register_post_type( 'forums', array(
		'labels' => $labels,
		'has_archive' => true,
 		'public' => true,
		'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail','page-attributes' ),
		'exclude_from_search' => false,
		'capability_type' => 'post',
		'query_var' => true,
		'rewrite' => array( 'slug' => 'forums' ),
		)
	);

}

// register custom post type topics
function fp_topics_post_type() {
	// set up labels
	$labels = array(
 		'name' => 'Topics',
    	'singular_name' => 'Topic',
    	'add_new' => 'Add New Topic',
    	'add_new_item' => 'Add New Topic',
    	'edit_item' => 'Edit Topic',
    	'new_item' => 'New Topic',
    	'all_items' => 'All Topics',
    	'view_item' => 'View Topic',
    	'search_items' => 'Search Topics',
    	'not_found' =>  'No Topics Found',
    	'not_found_in_trash' => 'No Topics found in Trash', 
    	'parent_item_colon' => 'Forum:',
    	'menu_name' => 'Topics',
    );
    //register post type
	register_post_type( 'topics', array(
		'labels' => $labels,
		'has_archive' => true,
 		'public' => true,
		'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail','page-attributes' ),
		'taxonomies' => array( 'post_tag'),	
		'exclude_from_search' => false,
		'capability_type' => 'post',
		'publicly_queryable' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'topic' ),
		)
	);

}

// register custom post type replies
function fp_replies_post_type() {
	// set up labels
	$labels = array(
 		'name' => 'Replies',
    	'singular_name' => 'Reply',
    	'add_new' => 'Add New Reply',
    	'add_new_item' => 'Add New Reply',
    	'edit_item' => 'Edit Reply',
    	'new_item' => 'New Reply',
    	'all_items' => 'All Replies',
    	'view_item' => 'View Reply',
    	'search_items' => 'Search Replies',
    	'not_found' =>  'No replies Found',
    	'not_found_in_trash' => 'No Replies found in Trash', 
    	'parent_item_colon' => 'Topic:',
    	'menu_name' => 'Replies',
    );
    //register post type
	register_post_type( 'replies', array(
		'labels' => $labels,
		'has_archive' => true,
 		'public' => true,
		'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail','page-attributes' ),
		'taxonomies' => array(),	
		'exclude_from_search' => false,
		'capability_type' => 'post',
		'rewrite' => array( 'slug' => 'reply' ),
		)
	);


}

/** CUSTOM TAXONOMIES ********************************************************/

// register forum type (category or forum)
function fp_register_taxonomies() {
	

	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'Topics', 'taxonomy general name', 'forumpress' ),
		'singular_name'     => _x( 'Topic', 'taxonomy singular name', 'forumpress' ),
		'search_items'      => __( 'Search Topics', 'forumpress' ),
		'all_items'         => __( 'All Topics', 'forumpress' ),
		'parent_item'       => __( 'Parent Forum', 'forumpress' ),
		'parent_item_colon' => __( 'Parent Forum:', 'forumpress' ),
		'edit_item'         => __( 'Edit Topic', 'forumpress' ),
		'update_item'       => __( 'Update Topic', 'forumpress' ),
		'add_new_item'      => __( 'Add New Topic', 'forumpress' ),
		'new_item_name'     => __( 'New Topic Name', 'forumpress' ),
		'menu_name'         => __( 'Topics', 'forumpress' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'topics' ),
	);

	register_taxonomy( 'topics', array( 'forums' ), $args );

	// Add new taxonomy, NOT hierarchical (like tags)
	$labels = array(
		'name'                       => _x( 'Replies', 'taxonomy general name', 'forumpress' ),
		'singular_name'              => _x( 'Reply', 'taxonomy singular name', 'forumpress' ),
		'search_items'               => __( 'Search Replies', 'forumpress' ),
		'popular_items'              => __( 'Popular Replies', 'forumpress' ),
		'all_items'                  => __( 'All Replies', 'forumpress' ),
		'parent_item'                => __( 'Parent Topic', 'forumpress' ),
		'parent_item_colon'          => __( 'Parent Topic:', 'forumpress' ),
		'edit_item'                  => __( 'Edit Reply', 'forumpress' ),
		'update_item'                => __( 'Update Reply', 'forumpress' ),
		'add_new_item'               => __( 'Add New Reply', 'forumpress' ),
		'new_item_name'              => __( 'New Reply Name', 'forumpress' ),
		'separate_items_with_commas' => __( 'Separate replies with commas', 'forumpress' ),
		'add_or_remove_items'        => __( 'Add or remove replies', 'forumpress' ),
		'choose_from_most_used'      => __( 'Choose from the most used replies', 'forumpress' ),
		'not_found'                  => __( 'No replies found.', 'forumpress' ),
		'menu_name'                  => __( 'Replies', 'forumpress' ),
	);

	$args = array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'replies' ),
	);

	register_taxonomy( 'replies', 'forums', $args );

}

/** CUSTOM METABOXES ********************************************************/

function add_forum_attributes_metabox(){
    add_meta_box( 
        'forum_attributes', 
        __('Forum Attributes', 'forumpress'), 
        'forum_attributes', 
        'forums', 
        'side', 
        'high', 
        array( 'id' => 'forum_attributes') 
    );
}

function save_forum_attributes_metabox($post_id, $post){

    // Don't wanna save this now, right?

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return;
    if ( !isset( $_POST['forum_attributes_nonce'] ) )
        return;
    if ( !wp_verify_nonce( $_POST['forum_attributes_nonce'], 'forumpress/includes/metaboxes/metaboxes.php' ) )
        return;

    // We do want to save? Ok!
    $key = 'forum_type';
    $value = $_POST["forum_type"];
    if ( get_post_meta( $post->ID, $key, FALSE ) ) { // If the custom field already has a value
        update_post_meta( $post->ID, $key, $value );
    } else { // If the custom field doesn't have a value
        add_post_meta( $post->ID, $key, $value );
    }
    if ( !$value ) delete_post_meta( $post->ID, $key ); // Delete if blank

    $key = 'forum_category';
    $value = $_POST["forum_category"];
    if ( get_post_meta( $post->ID, $key, FALSE ) ) { // If the custom field already has a value
        update_post_meta( $post->ID, $key, $value );
    } else { // If the custom field doesn't have a value
        add_post_meta( $post->ID, $key, $value );
    }
    if ( !$value ) delete_post_meta( $post->ID, $key ); // Delete if blank

    $key = 'forum_status';
    $value = $_POST["forum_status"];
    if ( get_post_meta( $post->ID, $key, FALSE ) ) { // If the custom field already has a value
        update_post_meta( $post->ID, $key, $value );
    } else { // If the custom field doesn't have a value
        add_post_meta( $post->ID, $key, $value );
    }
    if ( !$value ) delete_post_meta( $post->ID, $key ); // Delete if blank

    $key = 'forum_order';
    $value = $_POST["forum_order"];
    if ( get_post_meta( $post->ID, $key, FALSE ) ) { // If the custom field already has a value
        update_post_meta( $post->ID, $key, $value );
    } else { // If the custom field doesn't have a value
        add_post_meta( $post->ID, $key, $value );
    }
    if ( !$value ) add_post_meta( $post->ID, $key, '0' ); // add 0 if blank

}

/** CUSTOM COLUMNS ********************************************************/

// ADD TOPIC COUNT TO FORUMS ADMIN
function fp_forum_type($columns) {

	$columns['forum_type'] = __( 'Type', 'forumpress' );

	return $columns;

}

// Show forum type
function fp_show_forum_type($column_name, $post_ID) {
    if ($column_name == 'forum_type') {
        $forumtype = fp_show_type($post_ID);
        if ($forumtype) {
            echo $forumtype;
        }
    }
}

// ADD TOPIC COUNT TO FORUMS ADMIN
function fp_topics_column($columns) {

	$columns['topics_count'] = __( 'Topics', 'forumpress' );

	return $columns;

}

// ADD POST COUNT TO FORUMS ADMIN
function fp_posts_column($columns) {

	$columns['posts_count'] = __( 'Posts', 'forumpress' );

	return $columns;

}

// Show topic count
function fp_topics_count($column_name, $post_ID) {

    if ($column_name == 'topics_count') {

        $topic_count = fp_count_topics($post_ID);

        echo $topic_count;

    }
}

// Show post count
function fp_post_count($column_name, $post_ID) {
	
    if ($column_name == 'posts_count') {

        $post_count = fp_count_posts($post_ID);

        echo $post_count;

    }
}

/** CUSTOM TEMPLATES ********************************************************/

function fp_template( $template ) {
 
    // Post ID
    $post_id = get_the_ID();

    $is_category = get_post_meta($post_id, 'forum_type', true);

    if ( get_post_type( $post_id ) == 'topics' ) {
        return forumpress_get_template_hierarchy( 'topic' );
    }

    if ( is_single() and $is_category == 'category' and !is_single('new-topic') ) {
        return forumpress_get_template_hierarchy( 'category' );
    }

    // For all other CPT
    if ( get_post_type( $post_id ) != 'forums' ) {
        return $template;
    }
 
    // Else use custom template
    if ( is_single('new-topic') ) {
        return forumpress_get_template_hierarchy( 'newtopic' );
    } else if ( is_single() ) {
        return forumpress_get_template_hierarchy( 'forum' );
    } else {
    	return forumpress_get_template_hierarchy( 'forums' );
    }
 
}

function forumpress_get_template_hierarchy( $template ) {
 
    // Get the template slug
    $template_slug = rtrim( $template, '.php' );
    $template = $template_slug . '.php';
 
    // Check if a custom template exists in the theme folder, if not, load the plugin template file
    if ( $theme_file = locate_template( array( 'plugin_template/' . $template ) ) ) {
        $file = $theme_file;
    }
    else {
        $file = FORUMPRESS_BASE_DIR . '/templates/' . $template;
    }
 
    return apply_filters( 'rc_repl_template_' . $template, $file );
}

/** CUSTOM STYLES ********************************************************/

function fp_styles() {

wp_enqueue_style('styles', plugin_dir_url( __DIR__ ) . '/css/forumpress.css' );

wp_enqueue_style( 'load-fa', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );

wp_enqueue_style( 'wpb-google-fonts', 'https://fonts.googleapis.com/css?family=Asap', false ); 
 
}
add_action( 'wp_enqueue_scripts', 'fp_styles' );

/** CUSTOM FUNCTIONS ********************************************************/

function fp_build_bread_crumbs($post_id) {

	$breadcrumb = array();

	$forums_link = get_post_type_archive_link( 'forums' );

	$breadcrumbs = '';

	$breadcrumbs .= '<ul><li><a href="'. $forums_link .'">Board Index</a></li>';

	$link_parent = get_post_meta($post_id, 'forum_category', true);

	if (!empty($link_parent)) {

		do {

		    if ($link_parent !== $post_id) {

		    	array_unshift($breadcrumb,$link_parent);

		    }

		    $link_parent = get_post_meta($link_parent, 'forum_category', true);

		} while (!empty($link_parent));

	}

	foreach ($breadcrumb as $links => $link) {

		$add_link = get_permalink( $link );
		$add_title = get_the_title( $link );

		$breadcrumbs .= '<li><a href="'. $add_link .'">'. $add_title .'</a></li>';

	}

	if (!is_post_type_archive( 'forums' )) {

		$current_link = get_permalink( $post_id );
		$current_title = get_the_title( $post_id );

		$breadcrumbs .= '<li><a href="'. $current_link .'">'. $current_title .'</a></li></ul>';

	} else {

		$breadcrumbs .= '</ul>';

	}

	echo $breadcrumbs;
}

function fp_show_type($post_ID) {

	$forum_type = get_post_meta($post_ID, 'forum_type', true);

	return $forum_type;
}

function fp_recount_topics($post_ID) {

		$old_count = get_post_meta( $post_ID, 'topic_count', true );

		$topic_count = 0;

		$child_categories = query_posts( 
			    	array( 
			    		'post_type' => 'forums',
			    		'posts_per_page' => -1,
			    		'meta_query'  => array( 
			    			array(
						'relation' => 'AND',
						'forum_type_clause' => array ( 
							'key' => 'forum_type', 
							'value' => 'category'
						),
						'forum_category_clause' => array (
							'key' => 'forum_category',
							'value' => $post_ID,
						)
					) 
		    	) 
		    ) 
		);

		foreach ($child_categories as $children => $child) {

		    $child_forums = query_posts( 
			    	array( 
			    		'post_type' => 'forums',
			    		'posts_per_page' => -1,
			    		'meta_query'  => array( 
			    			array(
						'relation' => 'AND',
						'forum_type_clause' => array ( 
							'key' => 'forum_type', 
							'value' => 'forum'
						),
						'forum_category_clause' => array (
							'key' => 'forum_category',
							'value' => $child->ID,
						)
					)
		    		) 
		    	) 
		    );

		    foreach ($child_forums as $childrenforums => $forum) {

		    	$add_count = get_post_meta( $forum->ID, 'topic_count', true );

		    	if (empty($add_count)) {

					$add_count = 0;

				}

				$topic_count = ($add_count + $topic_count);

		    }

		}

		$topics = query_posts( 
			    	array( 
			    		'post_type' => 'topics',
			    		'posts_per_page' => -1,
			    		'meta_query'  => array( 
			    			array(
							'key' => 'forum_category',
							'value' => $post_ID,
						)
		    	) 
		    ) 
		);

		foreach ($topics as $alltopics => $topic) {

			$topic_count = ($topic_count + 1);
		}

	update_post_meta( $post_ID, 'topic_count', $topic_count );

}

function fp_count_topics($post_ID) {

	fp_recount_topics($post_ID);

	$topic_count = get_post_meta( $post_ID, 'topic_count', true );

	if (empty($topic_count)) {

		$topic_count = 0;

	}

	return $topic_count;

}

function fp_count_posts($post_ID) {

	$post_count = get_post_meta( $post_ID, 'post_count', true );

	if (empty($post_count)) {

		$post_count = 0;

	}

	return $post_count;

}

function fp_add_views($post_ID) {

	//Set the name of the Posts Custom Field.
    $count_key = 'post_views_count'; 
     
    //Returns values of the custom field with the specified key from the specified post.
    $count = get_post_meta($post_ID, $count_key, true);
     
    //If the the Post Custom Field value is empty. 
    if($count == ''){
        $count = 0; // set the counter to zero.
         
        //Delete all custom fields with the specified key from the specified post. 
        delete_post_meta($post_ID, $count_key);
         
        //Add a custom (meta) field (Name/value)to the specified post.
        add_post_meta($post_ID, $count_key, '0');
     
    //If the the Post Custom Field value is NOT empty.
    }else{
        $count++; //increment the counter by 1.
        //Update the value of an existing meta key (custom field) for the specified post.
        update_post_meta($post_ID, $count_key, $count);
         
    }

}

function fp_count_views($post_ID) {

	//Set the name of the Posts Custom Field.
    $count_key = 'post_views_count'; 
     
    //Returns values of the custom field with the specified key from the specified post.
    $count = get_post_meta($post_ID, $count_key, true);
     
    //If the the Post Custom Field value is empty. 
    if($count == ''){
        $count = 0; // set the counter to zero.
         
        //Delete all custom fields with the specified key from the specified post. 
        delete_post_meta($post_ID, $count_key);
         
        //Add a custom (meta) field (Name/value)to the specified post.
        add_post_meta($post_ID, $count_key, '0');
        return $count . ' View';
     
    //If the the Post Custom Field value is NOT empty.
    }else{
         
        //If statement, is just to have the singular form 'View' for the value '1'
        if($count == '1'){
        return $count . ' View';
        }
        //In all other cases return (count) Views
        else {
        return $count . ' Views';
        }
    }

}

// Add 1 to post/topic count to post/category
function fp_add_to_post_count($id, $post_type) {

	$topic_count = get_post_meta( $id, 'topic_count', true );

	if (empty($topic_count)) {

		$topic_count = 0;

	}

	$post_count = get_post_meta( $id, 'post_count', true );

	if (empty($post_count)) {

		$post_count = 0;
		
	}

	if ($post_type == 'topic') {

		$topic_count = $topic_count + 1;

		$post_count = $post_count + 1;

	} else {

		$post_count = $post_count +1;

	}

	if ( ! add_post_meta( $id, 'topic_count', $topic_count, true ) ) { 

   		update_post_meta( $id, 'topic_count', $topic_count );

   	}

   	if ( ! add_post_meta( $id, 'post_count', $post_count, true ) ) { 

   		update_post_meta( $id, 'post_count', $post_count );

   	}

   	$parent_forum = get_post_meta( $id, 'forum_category', true );

	if (!empty($parent_forum)) {

		fp_add_to_post_count($parent_forum, $post_type);
		
	}

}

function fp_user_info() {

	$output = '';

	if (is_user_logged_in()) {

		$user = wp_get_current_user();

		$avatar = get_avatar( $user, '', '', '', array( 'class' => 'fp_user_info_avatar') );

		$output .= '<ul>';
		$output .= '<li>'. $avatar .'</li>';
		$output .= '<li><a href="'. get_author_posts_url( ( 'ID' ), $user->user_nicename) .'" title="profile">'. $user->display_name .'</a></li>';
		$output .= '<li><a href="#" title="messages"><i class="fa fa-envelope" aria-hidden="true"></i></a></li>';
		$output .= '<li><a href="#" title="notifications"><i class="fa fa-bell" aria-hidden="true"></i></a></li>';
		$output .= '<li><a href="'. wp_logout_url( home_url() ) .'" title="logout"><i class="fa fa-sign-out" aria-hidden="true"></i></a></li>';
		$output .= '</ul>';
		

	} else {

		// User not logged in
		$output .= '<ul><li><a href="'. wp_login_url( get_permalink()) .'" title="Login" class="fp_user_info_login">Login</a></li><li><a href="'. wp_registration_url() .'" class="fp_user_info_register">Register</a></li></ul>';

	}

	return $output;

}

function fp_last_post($forum_id) {

	// Set Out
	$output = '';

	// Get Post type
	$post_type = get_post_type( $forum_id );

	// Get forum Type
	$forum_type = get_post_meta( $forum_id, 'forum_type', true );

	if ($post_type == 'forums' and $forum_type == 'forum') {

		$all_forum_topics = array();

		$topics = query_posts( 
		    	array( 
		    		'post_type' => 'topics',
		    		'posts_per_page' => -1,
		    		'meta_query'  => array( 
		    			array( 
		    				'key' => 'forum_category', 
		    				'value' => $forum_id 
		    			) 
		    		) 
		    	) 
		    );

		foreach ($topics as $topicnow => $topic) {

			array_push($all_forum_topics, $topic->ID);

		}

		$child_categories = query_posts( 
			    	array( 
			    		'post_type' => 'forums',
			    		'posts_per_page' => -1,
			    		'meta_query'  => array( 
			    			array(
						'relation' => 'AND',
						'forum_type_clause' => array ( 
							'key' => 'forum_type', 
							'value' => 'category'
						),
						'forum_category_clause' => array (
							'key' => 'forum_category',
							'value' => $forum_id,
						)
					) 
		    	) 
		    ) 
		);

		foreach ($child_categories as $children => $child) {

		    $child_forums = query_posts( 
			    	array( 
			    		'post_type' => 'forums',
			    		'posts_per_page' => -1,
			    		'meta_query'  => array( 
			    			array( 
			    				'key' => 'forum_category', 
			    				'value' => $child->ID 
		    			), 
		    		) 
		    	) 
		    );

		    	foreach ($child_forums as $children_forums => $childforum) {

			    		$child_topics = query_posts( 
				    	array( 
				    		'post_type' => 'topics',
				    		'posts_per_page' => -1,
				    		'meta_query'  => array( 
				    			array( 
				    				'key' => 'forum_category', 
				    				'value' => $childforum->ID 
			    			), 
			    		) 
			    	) 
			    );

			    	foreach ($child_topics as $children_topics => $childs) {

			    		array_push($all_forum_topics, $childs->ID);
			    		
			    	}
		    		
		    	}

		    }

		$last_reply = get_posts(  
			    	array( 
			    		'post_type' => 'replies', 
			    		'orderby' => 'date',
			    		'order' => 'DESC', 
			    		'posts_per_page' => 1,
			    		'meta_query'  => array( 
			    			array( 
			    				'key' => 'forum_category', 
			    				'value' => $all_forum_topics,
            					'compare' => 'IN' 
			    			) 
			    		) 
			    	) 
			    );

		$last_topic = get_posts( 
		    	array( 
		    		'post_type' => 'topics',
		    		'post__in' => $all_forum_topics,
		    		'orderby' => 'date',
		    		'order' => 'DESC',
		    		'posts_per_page' => 1,
		    		
		    	) 
		    );

		if (!empty($last_reply)) {

			if ($last_reply[0]->post_date > $last_topic[0]->post_date) {

				// Reply newer than topic
				$last_poster = get_the_author_meta( 'user_nicename', $last_reply[0]->author_id );
				$last_poster_url = get_author_posts_url( $last_reply[0]->author_id, $last_poster );
				$last_poster_avatar = get_avatar( get_the_author_meta('user_email', $last_reply[0]->author_id), '', '', '', array( 'class' => 'fp_last_poster_avatar') );
				$last_post_date = $last_reply[0]->post_date;
				$last_post_title = $last_reply[0]->post_title;
				$last_post_url = get_permalink(get_post_meta( $last_reply[0]->ID, 'forum_category', true) );

			} else {

				// topic newer than replies
				$last_poster = the_author_meta( 'user_nicename', $last_topic[0]->author_id );
				$last_poster_url = get_author_posts_url( $last_topic[0]->author_id, $last_poster );
				$last_poster_avatar = get_avatar( get_the_author_meta('user_email', $last_topic[0]->author_id), '', '', '', array( 'class' => 'fp_last_poster_avatar') );
				$last_post_date = $last_topic[0]->post_date;
				$last_post_title = $last_topic[0]->post_title;
				$last_post_url = get_permalink($last_topic[0]->ID);

			}

		} else {

			// topic newer than replies
				$last_poster = get_the_author_meta( 'user_nicename', $last_topic[0]->author_id );
				$last_poster_url = get_author_posts_url( $last_topic[0]->author_id, $last_poster );
				$last_poster_avatar = get_avatar( get_the_author_meta('user_email', $last_topic[0]->author_id), '', '', '', array( 'class' => 'fp_last_poster_avatar') );
				$last_post_date = $last_topic[0]->post_date;
				$last_post_title = $last_topic[0]->post_title;
				$last_post_url = get_permalink($last_topic[0]->ID);

		}
	
	}

	if ($post_type == 'topics') {

		$last_reply = get_posts(  
			    	array( 
			    	'post_type' => 'replies', 
			    	'orderby' => 'date',
			    	'order' => 'DESC', 
			    	'posts_per_page' => 1,
			    	'meta_query'  => array( 
			    	array( 
			    		'key' => 'forum_category', 
			    		'value' => $forum_id,
            			'compare' => 'IN' 
			    	) 
			    ) 
			) 
		);

		$last_poster = get_the_author_meta( 'user_nicename', $last_reply[0]->author_id );
		$last_poster_url = get_author_posts_url( $last_reply[0]->author_id, $last_poster );
		$last_poster_avatar = get_avatar( get_the_author_meta('user_email', $last_reply[0]->author_id), '', '', '', array( 'class' => 'fp_last_poster_avatar') );
		$last_post_date = $last_reply[0]->post_date;
		$last_post_title = $last_reply[0]->post_title;
		$last_post_url = get_permalink(get_post_meta( $last_reply[0]->ID, 'forum_category', true) );

	}

	$output .= '<ul>';
	$output .= '<li><a href="'. $last_post_url .'">'. $last_post_title .'</a></li>';
	$output .= '<li>'. $last_poster_avatar .'<a href="'. $last_poster_url .'">'. $last_poster .'</a></li>';
	$output .= '<li>'. $last_post_date .'</li>';
	$output .= '</ul>';

	return $output;

}

function fp_reply($topic_id, $forum_category, $poster_id, $post_title, $message) {

	// Gather post data.
	$new_reply = array(
	    'post_title'    => 'RE: '. $post_title,
	    'post_content'  => $message,
	    'post_status'   => 'publish',
	    'post_author'   => $poster_id,
	    'post_type' => 'replies'
	);
	 
	// Insert the post into the database.
	$new_post = wp_insert_post( $new_reply );

	if ( !add_post_meta( $new_post, 'forum_category', $forum_category, true ) ) { 

   	update_post_meta( $new_post, 'forum_category', $forum_category );

	}

	// Add to post count
	fp_add_to_post_count($forum_category, 'reply');

	return $new_post;

}

function fp_anti_hammer() {

}

function fp_new_post_link($forum_id) {

$page = get_page_by_path( 'new-topic', '', 'forums' );

$link = get_post_permalink($page->ID);

$forum = get_post($forum_id);

echo $link .'?forum='. $forum->post_name;

}

?>