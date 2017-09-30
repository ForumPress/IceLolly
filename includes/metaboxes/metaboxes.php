<?php

function forum_attributes($post, $args){

    wp_nonce_field( plugin_basename( __FILE__ ), 'forum_attributes_nonce' );
    $forum_type = get_post_meta($post->ID, 'forum_type', true);
    $forum_category = get_post_meta($post->ID, 'forum_category', true);
    $forum_status = get_post_meta($post->ID, 'forum_status', true);
    $forum_order = get_post_meta($post->ID, 'forum_order', true);

    echo "<p>Select the forum type:</p>";
    echo "<select id='forum_type' name='forum_type'>";


        if($forum_type == "category"){
             echo '<option selected="selected" value= "category">Category</option>';
        }
        else {
        	echo '<option value= "category">Category</option>';
        }

        if($forum_type == "forum"){
            echo '<option selected="selected" value= "forum">Forum</option>';
        }
        else {
        	echo '<option value= "forum">Forum</option>';
        }


    echo "</select>";

    

    	echo "<p>Select the forum category:</p>";

    	echo "<select id='forum_category' name='forum_category'>";

    	$new_topic = get_page_by_path( 'new-topic', '', 'forums' );

	    // Query the authors here
	    $query = get_posts( array( 'post_type' => 'forums', 'post_status' => 'publish', 'post__not_in' => array($new_topic->ID, $post->ID) ) );

	    if( $query ) {
	        foreach( $query as $parent_forum_category ) {

	        	var_dump($id);

	            $id = $parent_forum_category->ID;
	            $selected = "";

	            if($id == $forum_category){
		            $selected = ' selected="selected"';
		        }
		        echo '<option' . $selected . ' value=' . $id . '>' . $parent_forum_category->post_title . '</option>';
		    }
	    }

	    if (empty($forum_category)) {

	    	echo '<option selected="selected" value=>-- No Category --</option>';

	    } else {

	    	echo '<option value=>-- No Category --</option>';

	    }

	    echo '</select>';
    

    echo '<hr>';

     echo '<p>Status:</p>';

     echo '<select id="forum_status" name="forum_status">';


        if($forum_status == "open"){
             echo '<option selected="selected" value= "open">Open</option>';
        }
        else {
        	echo '<option value= "open">Open</option>';
        }

        if($forum_status == "closed"){
            echo '<option selected="selected" value= "closed">Closed</option>';
        }
        else {
        	echo '<option value= "closed">Closed</option>';
        }


    echo '</select>';

    echo '<p>Order:</p>';

    if (empty($forum_order)) {

    	$forum_order = 0;
    }

    echo '<input type="number" id="forum_order" name="forum_order" value="'. $forum_order .'" /> ';
}

?>