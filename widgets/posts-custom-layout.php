<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Posts - Custom Layouts Widget.
 *
 * A custom elementor widget for different posts/blog layout.
 *
 * @since 1.0.0
 */
class Posts_Custom_Layout extends \Elementor\Widget_Base {


	public static $slug = 'fc-posts-custom-layout';

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
		return __('Posts - Custom Layout', self::$slug);
	}

	/**
	 * Get widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-posts-group';
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

		// Use the repeater to define one one set of the items we want to repeat look like
		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'included_post_id',
			[
				'label' => __('Post', self::$slug),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => false,
				'default' => '',
				'options' => $this->get_posts(),

			]
		);

		$repeater->add_control(
			'post_custom_title',
			[
				'label' => __( 'Custom Title/Headline', self::$slug ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => "",
				'placeholder' => __( 'Enter custom title/headline here.', self::$slug ),
			]
		);

		$repeater->add_control(
			'post_image_caption',
			[
				'label' => __( 'Image caption', self::$slug ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => "",
				'placeholder' => __( 'Enter image caption here.', self::$slug ),
			]
		);

		$repeater->add_control(
			'post_custom_text',
			[
				'label' => __( 'Custom Content', self::$slug ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => "",
				'placeholder' => __( 'Enter custom content here.', self::$slug ),
			]
		);


		// Add the
		$this->add_control(
			'include_posts',
			[
				'label' => __( 'Include posts', self::$slug ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [],
				'title_field' => 'Post #{{{ included_post_id }}}'
			]
		);

		$this->add_control(
			'layout',
			[
				'label' => __('Layout', self::$slug),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'solo',
				'multiple' => true,
				'options' => [
					'solo' =>  __('Solo', self::$slug),
					'img-left' =>  __('Two Column - Image / Content', self::$slug),
					'img-right' =>  __('Two Column - Content / Image', self::$slug),
					'grid' =>  __('Grid', self::$slug),
					'grid-small' =>  __('Grid - Small', self::$slug),

				],
			]
		);

		// title before image
		$this->add_control(
			'title_above',
			[
				'label' => __('Show title before image', self::$slug),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', self::$slug),
				'label_off' => __('No', self::$slug),
				'return_value' => true,
				'default' => false,
			]
		);
		// meta tags options
		$this->add_control(
			'show_author',
			[
				'label' => __('Show post author', self::$slug),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Show', self::$slug),
				'label_off' => __('Hide', self::$slug),
				'return_value' => true,
				'default' => true,
			]
		);
		$this->add_control(
			'show_date',
			[
				'label' => __('Show post date', self::$slug),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Show', self::$slug),
				'label_off' => __('Hide', self::$slug),
				'return_value' => true,
				'default' => true,
			]
		);

		// excerpt options
		$this->add_control(
			'show_excerpt',
			[
				'label' => __('Show post excerpt', self::$slug),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Show', self::$slug),
				'label_off' => __('Hide', self::$slug),
				'return_value' => true,
				'default' => true,
			]
		);
		$this->add_control(
			'limit_words',
			[
				'label' => __('Excerpt length (by words)', self::$slug),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 5,
				'max' => 99,
				'step' => 1,
				'default' => 15,
			]
		);

		$this->add_control(
			'after_excerpt',
			[
				'label' => __('Add after excerpt', self::$slug),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('...', self::$slug),

			]
		);

		// read more
		$this->add_control(
			'show_readmore',
			[
				'label' => __('Show read more', self::$slug),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Show', self::$slug),
				'label_off' => __('Hide', self::$slug),
				'return_value' => true,
				'default' => true,
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

		// widget included posts
		$include_posts = $settings['include_posts'] ? $settings['include_posts'] : [];

		// widget flags
		$title_above   = $settings['title_above']   ? $settings['title_above']   : false;
		$show_author   = $settings['show_author']   ? $settings['show_author']   : false;
		$show_date     = $settings['show_date']     ? $settings['show_date']     : false;
		$show_excerpt  = $settings['show_excerpt']  ? $settings['show_excerpt']  : false;
		$limit_words   = $settings['limit_words']   ? $settings['limit_words']   : 15;
		$after_excerpt = $settings['after_excerpt'] ? $settings['after_excerpt'] : "...";
		$show_readmore = $settings['show_readmore'] ? $settings['show_readmore'] : false;

		// widget view
		require( __DIR__.'/../views/posts-widget.php' );

		wp_reset_postdata();

	}

	/**
	 * Get posts
	 *
	 * Return posts to be used as option
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function get_posts() {
		$posts = get_posts(array('numberposts' => 99,));

		$options = ['' => ''];

		if (!empty($posts)) :
			foreach ($posts as $post) {
				$options[$post->ID] = get_the_title($post->ID);
			}
		endif;

		return $options;
	}

}