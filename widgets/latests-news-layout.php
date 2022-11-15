<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Posts - Latest News Widget.
 *
 * A custom elementor widget for different posts/blog layout.
 *
 * @since 1.0.0
 */
class Latest_News_Layout extends \Elementor\Widget_Base {


	public static $slug = 'fc-latest-news-layout';

	/**
	 * Get widget name.
	 *
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return self::$slug;
	}

	/**
	 * Get widget title.
	 *
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget title.
	 */
	public function get_title() {
		return __('Latest Posts/News', self::$slug);
	}

	/**
	 * Get widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-post-list';
	}

	/**
	 * Get widget categories.
	 *
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'general' ];
	}

	/**
	 * Get style dependencies
	 *
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget style dependencies.
	 */
	public function get_style_depends() {

		wp_register_style( 'fc-posts-custom-layout', plugins_url( self::$slug .'/assets/css/fc-posts-custom.css' ) );

		return [
			'fc-posts-custom-layout',
		];

	}

	/**
	 * Register widget controls.
	 *
	 * Add input fields to allow the user to customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Query', self::$slug ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);


		$this->add_control(
			'per_page',
			[
				'label' => __('Posts to display', self::$slug),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 21,
				'step' => 1,
				'default' => 3,
			]
		);


		$this->end_controls_section();

	}

	/**
	 * Render widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		// widget settings
		$settings = $this->get_settings_for_display();

		// per_page
		$per_page = $settings['per_page'] ? $settings['per_page'] : 2;

		// widget view
		require( __DIR__.'/../views/latest-news-widget.php' );

		wp_reset_postdata();

	}

}