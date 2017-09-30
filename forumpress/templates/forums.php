<?php get_header(); ?>

<div id="fp_background">

	<div id="fpcontainer">

		<div class="fp_user_info">
			
			<?php echo fp_user_info(); ?>

		</div>

		<div class="fpcrumbs">

			<span class="fp_home_crumb"><a href="<?php echo get_post_type_archive_link( 'forums' ); ?>"><i class="fa fa-home" aria-hidden="true"></i></a></span>
			
			<ul><li><a href="<?php get_post_type_archive_link( 'forums' ) ?>">Board Index</a></li></ul>
				
		</div>

	<?php

	// Load Forum Categories 
	$forum_category_query = new WP_Query( 
		array( 
			'post_type' => 'forums', 
			'orderby' => 'meta_value_num title', 
			'meta_key'  => 'forum_order',
			'meta_type' => 'NUMERIC',
			'order' => 'ASC', 
			'meta_query' => array( 
				array(
					'relation' => 'AND',
					'forum_type_clause' => array ( 
						'key' => 'forum_type', 
						'value' => 'category'
					),
					'forum_category_clause' => array (
						'key' => 'forum_category',
						'compare' => 'NOT EXISTS',
					)
				) 
			) 
		) 
	);

		while ( $forum_category_query->have_posts() ) : $forum_category_query->the_post();

	?>
		   <div class="fpforumcontainer"> 
		   
		   <div class="fpcategory"><b><a href="<?php the_permalink() ?>"><?php the_title()?></a></b></div>

		   <div class="fpheaders">
		    	<div class="fptitle">Title</div>
		    	<div class="fpstats">Statistics</div>
		    	<div class="fplastposter">Last Post</div>
		    </div>

		   <?php

		    // Load Forums
		    $forum_query = new WP_Query( 
		    	array( 
		    		'post_type' => 'forums', 
		    		'orderby' => 'meta_value_num', 
		    		'meta_key'  => 'forum_order', 
		    		'order' => 'ASC', 
		    		'meta_query'  => array( 
		    			array( 
		    				'key' => 'forum_category', 
		    				'value' => get_the_ID() 
		    			) 
		    		) 
		    	) 
		    );

		    // Second Loop
		    while ( $forum_query->have_posts() ) : $forum_query->the_post();

		    	?>

		    	<div class="fpforum">
			    	<div class="fpforumtitle">
			    		<?php echo get_the_post_thumbnail( get_the_ID(), 'thumbnail', array( 'class' => 'fpicon' ) ); ?>
			    		<a href="<?php the_permalink() ?>" class="forumtitle" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
			    		<span class="fpdescription"><?php the_content() ?></span>
			    	</div>
			    	<div class="fpforumstats">
			    		<?php echo fp_count_topics(get_the_ID()) ?> Topics<br>
			    		<?php echo fp_count_posts(get_the_ID()) ?> Posts
			    	</div>
			    	<div class="fplastpost">
			    		<?php 

			    			if (fp_count_topics(get_the_ID()) > 0) {

			    				echo fp_last_post(get_the_ID());
			    			} else {

			    				echo '-- No Posts --';

			    			}

			    		?>
			    		
			    	</div>
			    </div>

		    	<?php

			endwhile;

			// Reset Second Loop Post Data
	      	wp_reset_postdata();

	      	?>

	      	</div>

	      	<?php

	    endwhile;



	    ?>

	</div>

<div id="fp_background">
 
<?php get_footer(); ?>