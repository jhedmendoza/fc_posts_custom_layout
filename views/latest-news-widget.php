<?php

	$args = array(
		'post_type' => 'post',
		'posts_per_page' => $per_page,
	);

$latest_news = new WP_Query( $args );
?>

<div class="latest-news">
  <?php if ( $latest_news->have_posts() ): ?>
    <?php while ( $latest_news->have_posts() ):  $latest_news->the_post(); ?>
      <?php
        $background_url = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ), 'thumbnail' );
        $excerpt = get_the_excerpt();
        $date_created = date_create(get_the_date());
        $categories = get_the_category(get_the_ID());
       ?>
      <div class="latest-news-item">
        <div class="featured-image" style="background: url(<?php echo !empty($background_url) ? $background_url : 'https://via.placeholder.com/754x350.png'; ?>) no-repeat center;height:200px">
          <p class="news-item-meta"><?php echo date_format($date_created, 'M d, Y'); ?></p>
          <p class="news-item-meta"><?php echo !empty($categories) ? esc_html( $categories[0]->name ) : ''; ?></p>
        </div>
        <h5 class="news-item-title"><?php the_title() ?></h5>
        <div class="news-item-excerpt"><?php echo string_limit_words($excerpt,15,"..."); ?></div>
        <p class="news-item-link">
          <a href="<?php echo get_permalink( get_the_ID() ) ?>">View More</a>
        </p>
      </div>
    <?php
    endwhile;
    wp_reset_postdata();
   ?>
  <?php endif; ?>
</div>