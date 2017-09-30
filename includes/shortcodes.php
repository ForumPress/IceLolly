<?php

function buildforums() {

	$forum_category_query = new WP_Query( array( 'post_type' => 'forums', 'meta_query'  => array( array( 'key' => 'forum_type', 'value' => 'category') ) ) );

	while ( $forum_category_query->have_posts() ) : $forum_category_query->the_post();
	    
	    echo '<b>'. get_the_title() . '</b><br/>';

	    $forum_query = new WP_Query( array( 'post_type' => 'forums', 'meta_query'  => array( array( 'key' => 'forum_category', 'value' => get_the_ID() ) ) ) );

	    // Second Loop
	    while ( $forum_query->have_posts() ) : $forum_query->the_post();

	    	?>

	    	<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>

	    	<?php

		endwhile;

		// Reset Second Loop Post Data
      	wp_reset_postdata();

    endwhile;

    // Reset first Loop Post Data
    wp_reset_postdata();

}

function renderforums() {

    return buildforums();
}

add_shortcode('forumpress', 'renderforums');
?>