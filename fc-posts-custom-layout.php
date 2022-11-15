<?php
/**
 * Plugin Name: Posts - Custom Layouts
 * Description: A custom elementor widget for different posts/blog layout
 * Version:     1.0.0
 * Author:      Vincent Jareño
 * Text Domain: elementor-posts
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Limit word function
 *
 */
function string_limit_words($string, $word_limit, $after_string) {
    $words = explode(' ', $string, ($word_limit + 1));
    if (count($words) > $word_limit) {
        array_pop($words);
        //add a ... at last article when more than limit word count
        return implode(' ', $words) . $after_string ;
    } else {
        //otherwise
        return implode(' ', $words);
    }
}

/**
 * Register Posts - Custom Layouts Widget.
 *
 * Include widget file and register widget class.
 *
 * @since 1.0.0
 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
 * @return void
 */
function register_posts_widget( $widgets_manager ) {

	require_once( __DIR__ . '/widgets/posts-custom-layout.php' );

	$widgets_manager->register( new \Posts_Custom_Layout() );

}
add_action( 'elementor/widgets/register', 'register_posts_widget' );

/**
 * Register Posts - Latest News Widget.
 *
 * Include widget file and register widget class.
 *
 * @since 1.0.0
 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
 * @return void
 */
function register_latests_news_widget( $widgets_manager ) {

    require_once( __DIR__ . '/widgets/latests-news-layout.php' );

    $widgets_manager->register( new \Latest_News_Layout() );

}
add_action( 'elementor/widgets/register', 'register_latests_news_widget' );