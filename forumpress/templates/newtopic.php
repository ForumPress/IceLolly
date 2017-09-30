<?php

if( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] )) {

	// Do some minor form validation to make sure there is content
	if (isset ($_POST['new_topic_title'])) {
		$title =  $_POST['new_topic_title'];
	} else {
		echo 'Please enter a title';
	}
	if (isset ($_POST['new_topic'])) {
		$message = $_POST['new_topic'];
	} else {
		echo 'Please enter a message';
	}
	$tags = $_POST['post_tags'];
	
	// Add the content of the form to $post as an array
	$post = array(
		'post_title'	=> $title,
		'post_content'	=> $message,
		'tags_input'	=> $tags,
		'post_status'	=> 'publish',			// Choose: publish, preview, future, etc.
		'post_type'	=> 'topics'  // Use a custom post type if you want to
	);
	$new_post = wp_insert_post($post);  // Pass  the value of $post to WordPress the insert function

	//SET OUR TAGS UP PROPERLY
    wp_set_post_tags($new_post, $_POST['post_tags']);

    if ( !add_post_meta( $new_post, 'forum_category', $_POST['new_topic_category'], true ) ) { 

   		update_post_meta( $new_post, 'forum_category', $_POST['new_topic_category'] );

	}

    $link = get_permalink( $new_post );

	// Add to post count
	fp_add_to_post_count($_POST['new_topic_category'], 'topic');
		
	// http://codex.wordpress.org/Function_Reference/wp_insert_post
	wp_redirect( $link );
} // end IF

// Do the wp_insert_post action to insert it
do_action('wp_insert_post', 'wp_insert_post'); 

$forum = (isset($_GET['forum']) ? $_GET['forum'] : null);

if (empty($forum)) {

	// No forum selected
	wp_redirect( get_post_type_archive_link( 'forums' ) );
	exit;

} else {

	$forum = get_page_by_path( $forum, '', 'forums' );

	// Forum selected
	if (empty($forum)) {

		// Selected Forum Doesn't Exists
		wp_redirect( get_post_type_archive_link( 'forums' ) );
		exit;

	} else {

		// Forum Found!
		?>
		<?php get_header(); ?>

			<div id="fpcontainer">

				<div class="fpcrumbs">

			<span class="fp_home_crumb"><a href="<?php echo get_post_type_archive_link( 'forums' ); ?>"><i class="fa fa-home" aria-hidden="true"></i></a></span>
			
			<?php fp_build_bread_crumbs($forum->ID); ?>

			<ul>
				<li>New Topic</li>
			</ul>
				
		</div> 

				<!-- New Post Form -->

				<div id="postbox">

				<form id="fp_new_topic" name="fp_new_topic" method="post" action="">

					<p>
						<label for="new_topic_title">Topic Title</label><br />

						<input type="text" name="new_topic_title" id="new_topic_title" value="" tabindex="1" size="20" />

					</p>

					<p>

						<?php 
							wp_editor( '', 'new_topic', $settings = array(
								'textarea_name' => 'new_topic'
							) ); 
							?>

					</p>

					<p>
						<label for="post_tags">Tags</label>

						<input type="text" value="" tabindex="5" size="16" name="post_tags" id="post_tags" />
					</p>

					<p align="right">
						<input type="submit" value="Create Topic" tabindex="6" id="new_topic_submit" name="new_topic_submit" />
					</p>

					<input type="hidden" name="new_topic_category" id="new_topic_category" value="<?php echo $forum->ID ?>" />

					<input type="hidden" name="post_type" id="post_type" value="topic" />

					<input type="hidden" name="action" value="post" />

					<?php wp_nonce_field( 'new-topic' ); ?>

				</form>

				</div>

				<!--// New Post Form -->

			</div>

		<?php get_footer(); ?>

		<?php
	}

}

?>