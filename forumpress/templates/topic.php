<?php

if( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] )) {

	// Do some minor form validation to make sure there is content

	$title =  $_POST['topic_name'];

	$topic =  $_POST['topic_id'];

	if (isset ($_POST['new_reply'])) {
		$message = $_POST['new_reply'];
	} else {
		echo 'Please enter a message';
	}
	
	$new_reply = fp_reply($topic, $topic, get_current_user_id(), $title, $message);

} // end IF

// Do the wp_insert_post action to insert it
do_action('wp_insert_post', 'wp_insert_post'); 

?>

<?php fp_add_views(get_the_ID()); ?>

<?php get_header(); ?>

<div id="fp_background">

	<div id="fpcontainer">

		<div class="fp_user_info">
			
			<?php echo fp_user_info(); ?>

		</div>

		<div class="fpcrumbs">

			<span class="fp_home_crumb"><a href="<?php echo get_post_type_archive_link( 'forums' ); ?>"><i class="fa fa-home" aria-hidden="true"></i></a></span>
			
			<?php fp_build_bread_crumbs(get_the_ID()); ?>
				
		</div>

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<h3 class="fppagetitle"><?php the_title()?></h3>

			<div class="fp_post">

				<div class="fp_post_header">

					<?php echo get_avatar( get_the_author_meta( 'ID' ), '', '', '', array ('class' => 'fp_poster_avatar') ); ?> 

					<h3 class="fp_post_title"><?php the_title() ?></h3> <a href="<?php the_permalink() ?>"><h3 class="fp_page_id">#1</h3></a>

					<div class="fp_poster_details">By <?php the_author() ?> - <?php the_time('m/j/y g:i A') ?></div>

				</div>

				<div class="fp_post_body">

					<?php the_content(); ?>
						
				</div>

			</div>

			<?php

				// Load Forum Categories 
				$topic_reply_query = new WP_Query( 
					array( 
						'post_type' => 'replies', 
						'orderby' => 'post_date', 
						'order' => 'ASC', 
						'meta_query' => array ( 
									'relation' => 'AND',
									'forum_type_clause' => array ( 
										'key' => 'forum_category', 
										'value' => get_the_ID()
									),
									'forum_category_clause' => array (
										'key' => 'forum_category',
										'compare' => 'EXISTS',
									)
				)  ) );

				$i = 1;

				while ( $topic_reply_query->have_posts() ) : $topic_reply_query->the_post();

					$i++;

					?>

					<div class="fp_post">

						<div class="fp_post_header">

							<?php echo get_avatar( get_the_author_meta( 'ID' ), '', '', '', array ('class' => 'fp_poster_avatar') ); ?> 

							<h3 class="fp_post_title"><?php the_title() ?></h3> <a href="<?php the_permalink() ?>"><h3 class="fp_page_id">#<?php echo $i ?></h3></a>

							<div class="fp_poster_details">By <?php the_author() ?> - <?php the_time('m/j/y g:i A') ?></div>

						</div>

						<div class="fp_post_body">

							<?php the_content(); ?>
								
						</div>

					</div>

					<?php

				endwhile;

			    // Reset first Loop Post Data
			    wp_reset_postdata();

			?>

		<?php 

			endwhile; 

			endif; 

			// Reset first Loop Post Data
	    	wp_reset_postdata();

	    ?>

	    <!-- New Reply Form -->

		<div id="postbox">

			<form id="fp_new_topic" name="fp_new_reply" method="post" action="">

				<p>

				<?php 
					wp_editor( '', 'new_reply', $settings = array(
						'textarea_name' => 'new_reply'
					) ); 
				?>

				</p>

				<p align="right">
					<input type="submit" value="Reply" tabindex="6" id="new_topic_submit" name="new_topic_submit" />
				</p>

				<input type="hidden" name="topic_name" id="topic_name" value="<?php echo the_title() ?>" />

				<input type="hidden" name="topic_id" id="topic_id" value="<?php the_id() ?>" />

				<input type="hidden" name="action" value="post" />

				<?php wp_nonce_field( 'new-topic' ); ?>

			</form>

		</div>

		<!--// New Reply Form -->

	</div>

</div>
 
<?php get_footer(); ?>