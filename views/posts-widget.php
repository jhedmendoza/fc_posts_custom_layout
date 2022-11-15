<?php
	/*
	 **
	 ** This is the solo  layout view
	 **
	*/

	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	$layout_class = $settings['layout'] ?: 'solo';
	$widget_class = "";

	if ( ( $layout_class === "img-left" ) || ( $layout_class === "img-right" ) ) {
		$layout_class .= " two-column";
	}
	elseif ( $layout_class === "grid" ) {
		$widget_class = "grid";
		$layout_class .= "-item"; // make layout class to grid item
	}
?>

<div class="fc-posts-widget <?php echo $widget_class; ?>">
<?php 
	foreach( $include_posts as $posts ) { // start loop - posts 

		// get included post
		$post   = get_post( $posts['included_post_id'] );

		// custom content
		$custom_title   = $posts['post_custom_title'];
		$custom_content = $posts['post_custom_text'];
		
		// post meta
		$user_id   		   = get_userdata($post->post_author)->data->ID;
		$post_url          = get_permalink($post);
		$post_title        = $custom_title ?: $post->post_title;
		$post_excerpt      = get_the_excerpt($post);
		$post_author       = get_userdata($post->post_author)->display_name;
		$post_author_title = isset(get_user_meta($user_id)['agent_title'][0]) ? get_user_meta($user_id)['agent_title'][0] : '';
		$post_date         = human_time_diff( get_post_timestamp($post), current_time('timestamp') ) ." ago";
?>
		<div class="fc-post <?php echo $layout_class; ?>">

			
			<?php if( $title_above ) { ?>
				<h3 class="fc-post-title">
					<a href="<?php echo esc_url($post_url); ?>" class="fc-post-title-link"><?php echo $post_title; ?></a>
				</h3>
			<?php } ?>
			<div class="fc-post-image">
				<a href="<?php echo esc_url($post_url); ?>" class="fc-post-image-link">
					<?php 
						// has featured image
						if( has_post_thumbnail($post) ) { ?>
						<img src="<?php echo esc_url( get_the_post_thumbnail_url( $post->ID, 'post-thumbnail') ); ?>" alt="">
					<?php } 
						// no featured image, show placeholder
						else { ?>
						<img src="<?php echo esc_url( plugins_url( self::$slug . '/assets/img/placeholder.jpg') ); ?>" alt="">
					<?php } ?>

					<?php
						// show custom image caption
						if (isset($posts['post_image_caption']) && $posts['post_image_caption'] !== '') {
							echo '<span class="fc-post-image-caption">'.esc_html($posts['post_image_caption']).'</span>';
						}
					?>
				</a>
			</div>

			<div class="fc-post-content">
				<?php if( $show_author || $show_date ) { ?>
					<div class="fc-post-meta">
						<?php if( $show_author ) { ?>
							<div class="fc-post-meta-item author">
								<span class="author-name">By <?php echo $post_author; ?></span>
								<span class="author-title"><?php echo $post_author_title; ?></span>
							</div>
						<?php } ?>
						<?php if( $show_date ) { ?>
							<div class="fc-post-meta-item date">
								<i class="fa fa-clock"></i> <?php echo $post_date; ?>
							</div>
						<?php } ?>
					</div>
				<?php } ?>

				<?php if( !$title_above ) { ?>
					<h3 class="fc-post-title">
						<a href="<?php echo esc_url($post_url); ?>" class="fc-post-title-link"><?php echo $post_title; ?></a>
					</h3>
				<?php } ?>
				<?php if( $show_excerpt ) { ?>
					<div class="fc-post-excerpt">
						<?php
						// show custom content if available
						if (isset($custom_content) && $custom_content !== '') {
							echo $custom_content;
						}
						// else show post excerpt
						else {
							echo "<p>".string_limit_words($post_excerpt,$limit_words,$after_excerpt)."</p>";
						}
					?>
					</div>
				<?php } ?>

				<?php if( $show_readmore ) { ?>
					<a href="<?php echo esc_url($post_url); ?>" class="fc-post-link">Read more</a>
				<?php } ?>
			</div>

		</div>
<?php } // end loop - posts 
?>
</div>
<?php