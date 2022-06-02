<?php
namespace WTS_EAE\Modules\Posts\Widgets;

use WTS_EAE\Base\EAE_Widget_Base;
use Elementor\Controls_Manager;
use WP_Query;
use WTS_EAE\Modules\Posts\Classes\PostBase;
use WTS_EAE\Modules\Posts\Classes\Query;
use Elementor\Plugin;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Utils;
class Posts extends EAE_Widget_Base {

	public function get_name() {
		return 'eae-posts';
	}

	public function get_title() {
		return __( 'EAE - Posts', 'wts-eae' );
	}

    public function get_icon() {
		return 'eicon-post-list';
	}

    public function get_keywords() {
		return [ 'posts', 'cpt', 'item', 'loop', 'query', 'cards', 'custom post type' ];
	}

    protected function register_controls() {
		$this->register_layout_controls();
		$this->register_grid_controls();
        $this->get_query_section();
		$this->get_title_section();
		$this->register_thumbnail_content_controls();
		$this->register_excerpt_controls();
		$this->register_title_style_controls();
		$this->register_media_style_controls();
		$this->register_excerpt_style_controls();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
		//$query = new Query( $settings );
		//$posts = $query->get_posts();
		$query_args = [
			'post_type'  => $settings['source'],
			'posts_per_page' => $settings['posts_per_page'],
		];
		$wp_query  = new WP_Query($query_args);
		$posts = $wp_query->posts;
		global $post;
		

		// foreach($posts as $current_post){
		// 	$post = $current_post;
		// 	setup_postdata($post);
		// 	echo $post->post_title;
		// 	echo "<br/>";
		// }
		// wp_reset_postdata();
		if ( ! in_array( $settings[ 'post_media_position' ], array( 'left', 'right' ) ) ) {
			$layout = 'vertical';		
		} else if ( 'yes' === $settings['post_media'] ) {
			$layout = 'horizontal';
		} else {
			$layout = 'vertical';
		}
		$this->before_loop();
		$this->render_loop_start();

		while ( $wp_query->have_posts() ) {

			$wp_query->the_post();
			global $post;	
			
			$this->set_render_attribute('eae-post','class', ['eae-post-item', 'eae-post-'.$post->ID]);
			?>
			<article <?php echo $this->get_render_attribute_string('eae-post');?>>
				<?php if($layout == 'vertical'){
					$this->render_vertical_layout();
				}else{
					$this->render_horizontal_layout();
				}?>
			</article>
			<?php	
		}

		wp_reset_postdata();
		wp_reset_query();	

		$this->render_loop_end();
		$this->after_loop();
    }

	public function render_horizontal_layout(){
		global $post;
		?>
			<div class="eae-post-item-inner ">
				<!-- Media Start -->
					<?php 
						$this->eae_render_post_thumbnail();
					?>
				<!-- Media End -->
				<div class="eae-post-cont-wrap">
						<!-- Title Start -->
					<?php 
						$this->eae_render_post_title();
					?>	
					<!-- Title End -->
					
					<!-- COntent Start-->
					<?php 
						$this->eae_render_post_content();
					?>	
					<!-- Content End -->
				</div>	
			</div>
		<?php
	}

	public function render_vertical_layout(){
		global $post;
		?>
			<div class="eae-post-item-inner ">
					<!-- Title Start -->
					<?php 
						$this->eae_render_post_title();
					?>	
					<!-- Title End -->
					<!-- Media Start -->
					<?php 
						$this->eae_render_post_thumbnail();
					?>
					<!-- Media End -->
					<!-- COntent Start-->
					<?php 
						$this->eae_render_post_content();
					?>	
					<!-- Content End -->
			</div>
		<?php
	}

	public function get_title_section(){
		$this->start_controls_section(
			'section_title',
			[
				'label' => __( 'Title', 'eae-wts' ),
			]
		);

		$this->add_control(
			'use_link',
			[
				'label'     => __( 'Post Link', 'wts-eae' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'yes' => [
						'title' => __( 'Yes', 'wts-eae' ),
						'icon'  => 'eicon-check',
					],
					'no' => [
						'title' => __( 'No', 'wts-eae' ),
						'icon'  => 'eicon-ban',
					],
				],
				'default'   => 'yes',
				
			]
		);

		$this->add_control(
			'title_open_in_new_tab',
			[
				'label' 		=> __( 'Open in New Tab', 'wts-eae' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'default'		=> '',
				'return_value' 	=> 'yes',
				// 'condition'		=> [
				// 	'post_title_position!' => '',
				// 	'post_title_link!' => '',
				// ],
			]
		);

		$this->add_control(
			'post_title_tag',
			[
				'label' 	=> __( 'Title Tag', 'wts-eae' ),
				'type' 		=> Controls_Manager::SELECT,
				'options' 	=> [
					'h1' 	=> __( 'H1', 'wts-eae' ),
					'h2' 	=> __( 'H2', 'wts-eae' ),
					'h3' 	=> __( 'H3', 'wts-eae' ),
					'h4' 	=> __( 'H4', 'wts-eae' ),
					'h5' 	=> __( 'H5', 'wts-eae' ),
					'h6' 	=> __( 'H6', 'wts-eae' ),
					'div'	=> __( 'div', 'wts-eae' ),
					'span' 	=> __( 'span', 'wts-eae' ),
				],
				'default' => 'h2',
			]
		);

		$this->add_control(
			'strip_title',
			[
				'label'        => __( 'Strip Title', 'wts-eae' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '',
				'strip_yes'    => __( 'Yes', 'wts-eae' ),
				'strip_no'     => __( 'No', 'wts-eae' ),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'strip_mode',
			[
				'label'     => __( 'Strip Mode', 'wts-eae' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'word'   => __( 'Word', 'wts-eae' ),
					'letter' => __( 'Letter', 'wts-eae' ),
				],
				'default'   => 'word',
				'condition' => [
					'strip_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'strip_size',
			[
				'label'       => __( 'Strip Size', 'wts-eae' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Strip Size', 'wts-eae' ),
				'default'     => __( '5', 'wts-eae' ),
				'condition'   => [
					'strip_title' => 'yes',
				],
				'description' => __( 'Number of words to show.', 'wts-eae' ),
			]
		);

		$this->add_control(
			'strip_append',
			[
				'label'       => __( 'Append Title', 'wts-eae' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Append Text', 'wts-eae' ),
				'default'     => __( '...', 'wts-eae' ),
				'condition'   => [
					'strip_title' => 'yes',
				],
				'description' => __( 'What to append if Title needs to be trimmed.', 'wts-eae' ),
			]
		);

		$this->end_controls_section();
	}

	public function register_layout_controls(){
		$this->start_controls_section(
			'section_layout',
			[
				'label' => __( 'Layout', 'wts-eae' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'skin',
			[
				'label'	=>	__('Skin', 'wts-eae'),
				'type'	=> Controls_Manager::SELECT,
				'options'	=>	[
					'grid'	=>	__('Grid', 'wts-eae'),
					'carousel'	=>	__('Carousel', 'wts-eae'),
				],
				'default'	=>	__('Grid', 'wts-eae')
			]
		);
		$this->end_controls_section();
	}

	
	public function register_grid_controls(){
		$this->start_controls_section(
			'section_grid',
			[
				'label' => __( 'Grid', 'wts-eae' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
				'condition'	=>	[
					'skin'	=> 'grid'
				],
			]
		);

		$this->add_control(
			'masonry',
			[
				'label'        => __( 'Masonry', 'ae-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '',
				'masonry_on'   => __( 'On', 'ae-pro' ),
				'masonry_off'  => __( 'Off', 'ae-pro' ),
				'return_value' => 'yes',
				'condition'    => [
					 'skin' => [ 'grid' ],
				],
			]
		);

		$this->add_control(
			'show_infinite_scroll',
			[
				'label'        => __( 'Infinite Scroll', 'ae-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '',
				'label_on'     => __( 'Yes', 'ae-pro' ),
				'label_off'    => __( 'No', 'ae-pro' ),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'show_pagination',
			[
				'label'        => __( 'Pagination', 'ae-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'label_on'     => __( 'Yes', 'ae-pro' ),
				'label_off'    => __( 'No', 'ae-pro' ),
				'return_value' => 'yes',
				'condition'    => [
					 'show_infinite_scroll'  => '',
				],
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label'           => __( 'Columns', 'wts-eae' ),
				'type'            => Controls_Manager::NUMBER,
				'desktop_default' => '3',
				'tablet_default'  => '2',
				'mobile_default'  => '1',
				'min'             => 1,
				'max'             => 12,
				'selectors'       => [
					'{{WRAPPER}} .eae-layout-grid' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr)); display:grid',
					// '{{WRAPPER}} .ae-masonry-yes .ae-post-collection' => 'display: block;',
					// '{{WRAPPER}} .ae-masonry-yes .ae-post-collection .ae-post-item' => 'width: calc(100% / {{VALUE}});',
				],
			]
		);

		$this->add_responsive_control(
			'item_col_gap',
			[
				'label'     => __( 'Column Gap', 'ae-pro' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'default'   => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .eae-layout-grid' => 'column-gap: {{SIZE}}{{UNIT}}; grid-column-gap: {{SIZE}}{{UNIT}}',
					// '{{WRAPPER}} .ae-masonry-yes .ae-post-collection .ae-post-item' => 'padding-right: calc({{SIZE}}{{UNIT}}/2); padding-left: calc({{SIZE}}{{UNIT}}/2)',
					// '{{WRAPPER}} .ae-masonry-yes .ae-post-collection' => 'margin-left: calc(-{{SIZE}}{{UNIT}}/2); margin-right: calc(-{{SIZE}}{{UNIT}}/2)',
				],
			]
		);

		$this->add_responsive_control(
			'item_row_gap',
			[
				'label'     => __( 'Row Gap', 'ae-pro' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'default'   => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .eae-layout-grid' => 'row-gap: {{SIZE}}{{UNIT}}; grid-row-gap: {{SIZE}}{{UNIT}}',
					//'{{WRAPPER}} .ae-masonry-yes .ae-post-collection .ae-post-item' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function register_thumbnail_content_controls() {

		$this->start_controls_section(
			'section_media',
			[
				'label' => __( 'Media', 'wts-eae' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

			$this->add_control(
				'post_media',
				[
					'label' 		=> __( 'Show', 'wts-eae' ),
					'type' 			=> Controls_Manager::SWITCHER,
					'default'		=> 'yes',
					'return_value' 	=> 'yes',
				]
			);

			$this->add_control(
				'fallback_image',
				[
					'label' => __( 'Fallback Image', 'wts-eae' ),
					'description' => __( 'An image to be used for all posts that DO NOT have a featured image set.', 'wts-eae' ),
					'type' => Controls_Manager::MEDIA,
					'dynamic' => [
						'active' => true,
					],
					'default' => [
						'id'  => 0,	
						'url' => Utils::get_placeholder_image_src(),
					],
					'condition'	=>	[
						'post_media'	=>	'yes'
					]
				]
			);

			$this->add_control(
				'post_media_link',
				[
					'label' 		=> __( 'Enable Link', 'wts-eae' ),
					'type' 			=> Controls_Manager::SWITCHER,
					'default'		=> 'yes',
					'return_value' 	=> 'yes',
					'condition'	=>	[
						'post_media'	=>	'yes'
					]
				]

			);

			$this->add_control(
				'post_media_blank',
				[
					'label' 		=> __( 'Open in New Tab', 'wts-eae' ),
					'type' 			=> Controls_Manager::SWITCHER,
					'default'		=> '',
					'return_value' 	=> 'yes',
					'condition'	=>	[
						'post_media'	=>	'yes',
						'post_media_link'	=> 'yes'
					]
				]
			);

			$this->add_control(
				'enable_image_ratio',
				[
					'label'        => __( 'Enable Image Ratio', 'ae-pro' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => '',
					'label_on'     => __( 'Yes', 'ae-pro' ),
					'label_off'    => __( 'No', 'ae-pro' ),
					'return_value' => 'yes',
					'condition'	=>	[
						'post_media'	=>	'yes',
					]
				]
			);
	
			$this->add_responsive_control(
				'image_ratio',
				[
					'label'          => __( 'Image Ratio', 'ae-pro' ),
					'type'           => Controls_Manager::SLIDER,
					'default'        => [
						'size' => 0.66,
					],
					'tablet_default' => [
						'size' => '',
					],
					'mobile_default' => [
						'size' => 0.5,
					],
					'range'          => [
						'px' => [
							'min'  => 0.1,
							'max'  => 2,
							'step' => 0.01,
						],
					],
					'selectors'      => [
						'{{WRAPPER}} .eae-post-media-wrapper.eae_image_ratio_yes' => 'padding-bottom: calc( {{SIZE}} * 100% );',
					],
					'condition'      => [
						'post_media'	=>	'yes',
						'enable_image_ratio' => 'yes',
					],
				]
			);

			

			$this->add_control(
				'post_media_position',
				[
					'label' 		=> __( 'Position', 'wts-eae' ),
					'type' 			=> Controls_Manager::CHOOSE,
					'default' 		=> '',
					'options' 		=> [
						'left' 		=> [
							'title' => __( 'Left', 'wts-eae' ),
							'icon' 	=> 'eicon-h-align-left',
						],
						'up' 			=> [
							'title' => __( 'Block', 'wts-eae' ),
							'icon' 	=> 'eicon-v-align-top',
						],
						'right' 	=> [
							'title' => __( 'Right', 'wts-eae' ),
							'icon' 	=> 'eicon-h-align-right',
						],
					],
					'label_block'	=> false,
					'condition'		=> [
						'post_media!' 	=> '',
					],
				]
			);

			$this->add_control(
				'post_media_collapse',
				[
					'label' 		=> __( 'Collapse on', 'wts-eae' ),
					'type' 			=> Controls_Manager::SELECT,
					'default' 		=> 'mobile',
					'options' 		=> [
						'none'		=> __( 'None', 'wts-eae' ),
						'tablet'	=> __( 'Tablet', 'wts-eae' ),
						'mobile'	=> __( 'Mobile', 'wts-eae' ),
					],
					'prefix_class'	=> 'eae-posts-layout-collapse-',
					'condition'		=> [
						'post_media!' 	=> '',
						'post_media_position!' => '',
					],
				]
			);

			$this->add_responsive_control(
				'post_media_align',
				[
					'label' 		=> __( 'Vertical Align', 'wts-eae' ),
					'type' 			=> Controls_Manager::CHOOSE,
					'default' 		=> 'stretch',
					'options' 		=> [
						'flex-start' => [
							'title' 	=> __( 'Top', 'wts-eae' ),
							'icon' 		=> 'eicon-v-align-top',
						],
						'center' => [
							'title' 	=> __( 'Middle', 'wts-eae' ),
							'icon' 		=> 'eicon-v-align-middle',
						],
						'flex-end' => [
							'title' 	=> __( 'Bottom', 'wts-eae' ),
							'icon' 		=> 'eicon-v-align-bottom',
						],
					],
					'label_block'	=> false,
					'condition'		=> [
						'post_media!' 	=> '',
						'post_media_position' => [ 'left', 'right' ],
						'post_media_custom_height' => '',
					],
					'selectors' 	=> [
						'{{WRAPPER}} .ee-post--horizontal' => 'align-items: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'post_media_align_flex',
				[
					'label' 		=> __( 'Vertical Align', 'wts-eae' ),
					'type' 			=> Controls_Manager::CHOOSE,
					'default' 		=> 'stretch',
					'options' 		=> [
						'flex-start' => [
							'title' 	=> __( 'Top', 'wts-eae' ),
							'icon' 		=> 'eicon-v-align-top',
						],
						'center' => [
							'title' 	=> __( 'Middle', 'wts-eae' ),
							'icon' 		=> 'eicon-v-align-middle',
						],
						'flex-end' => [
							'title' 	=> __( 'Bottom', 'wts-eae' ),
							'icon' 		=> 'eicon-v-align-bottom',
						],
						'stretch' => [
							'title' 	=> __( 'Stretch', 'wts-eae' ),
							'icon' 		=> 'eicon-v-align-stretch',
						],
					],
					'label_block'	=> false,
					'condition'		=> [
						'post_media!' 	=> '',
						'post_media_position' => [ 'left', 'right' ],
						'post_media_custom_height!' => '',
					],
					'selectors' 	=> [
						'{{WRAPPER}} .ee-post--horizontal' => 'align-items: {{VALUE}};',
					],
				]
			);

			$this->add_responsive_control(
				'post_media_width',
				[
					'label' 		=> __( 'Width (%)', 'wts-eae' ),
					'type' 			=> Controls_Manager::SLIDER,
					'range' 		=> [
						'px' 		=> [
							'min' => 20,
							'max' => 80,
						],
					],
					'default' => [
						'size' => 30,
						'unit' => 'px',
					],
					'selectors' 	=> [
						'{{WRAPPER}} .eae-post-layout-horizontal .eae-post-media-wrapper' => 'flex-basis: {{SIZE}}%; -ms-flex-preferred-size: {{SIZE}}%;',
						'{{WRAPPER}} .eae-post-layout-horizontal .eae-post-cont-wrap' => 'flex-basis: calc( 100% - {{SIZE}}% );',
					],
					'condition'		=> [
						'post_media!' 	=> '',
						'post_media_position!' => '',
					],
				]
			);

			$this->add_responsive_control(
				'post_media_height',
				[
					'label' 		=> __( 'Height', 'wts-eae' ),
					'type' 			=> Controls_Manager::SLIDER,
					'range' 		=> [
						'px' 		=> [
							'min' => 1,
							'max' => 200,
						],
					],
					'selectors' 	=> [
						'{{WRAPPER}} .ee-post__media:before' => 'padding-bottom: {{SIZE}}%',
					],
					'condition'		=> [
						'post_media!' => '',
						'post_media_custom_height!' => '',
					],
				]
			);

			$this->add_control(
				'post_media_thumbnail_heading',
				[
					'label' 	=> __( 'Thumbnail', 'wts-eae' ),
					'type' 		=> Controls_Manager::HEADING,
					'separator' => 'before',
					'condition'		=> [
						'post_media!' => '',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Image_Size::get_type(),
				[
					'name' 			=> 'post_thumbnail_size',
					'label' 		=> __( 'Thumbnail Size', 'wts-eae' ),
					'default' 		=> 'large',
					'exclude' 		=> [ 'custom' ],
					'condition'		=> [
						'post_media!' => '',
					],
				]
			);

		$this->end_controls_section();

	}

	protected function register_excerpt_controls(){
		$this->start_controls_section(
			'post_content_title',
			[
				'label' => __( 'Excerpt', 'eae-wts' ),
			]
		);

		$this->add_control(
			'show_excerpt',
			[
				'label' 		=> __( 'Show Excerpt', 'wts-eae' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'default'		=> 'yes',
				'return_value' 	=> 'yes',
			]
		);

		$this->add_control(
			'excerpt_size',
			[
				'label'     => __( 'Excerpt Size', 'ae-pro' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => '30',
				'condition' => [
					'show_excerpt' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

    public function get_query_section() {

        
		$this->start_controls_section(
			'section_query',
			[
				'label' => __( 'Query', 'eae-wts' ),
			]
		);

        $source                          = PostBase::instance()->get_post_types();
		
		$source['current_loop']          = __( 'Current Archive', 'eae-wts' );
        $source['manual_selection'] = __( 'Manual Selection', 'eae-wts' );
        $source['related']          = __( 'Related Posts', 'eae-wts' );
        $this->add_control(
			'source',
			[
				'label'   => __( 'Source', 'eae-wts' ),
				'type'    => Controls_Manager::SELECT,
				'options' => $source,
                'default' => key( $source )  
			]
		);
        //TODO : Change Manual Selection SElECT2 to Query Control
        $this->add_control(
			'select_post_ids',
			[
				'label'       => __( 'Posts', 'eae-wts' ),
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'label_block' => true,
				'placeholder' => __( 'Selects Posts', 'eae-wts' ),
				'default'     => __( '', 'eae-wts' ),
				'condition'   => [
					'source' => 'manual_selection',
				],
			]
		);
        $this->add_control(
			'related_by',
			[
				'label'       => __( 'Related By', 'eae-wts' ),
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'label_block' => true,
				'placeholder' => __( 'Select Taxonomies', 'eae-wts' ),
				'default'     => '',
				'options'     => PostBase::instance()->get_rules_taxonomies(),
				'condition'   => [
					'source' => 'related',
				],
			]
		);
		$this->add_control(
			'related_match_with',
			[
				'label'     => __( 'Match With', 'eae-wts' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'OR',
				'options'   => [
					'OR'  => __( 'Anyone Term', 'eae-wts' ),
					'AND' => __( 'All Terms', 'eae-wts' ),
				],
				'condition' => [
					'source' => 'related',
				],
			]
		);
        
		$this->add_control(
			'taxonomy_divider',
			[
				'type'      => Controls_Manager::DIVIDER,
				'style'     => 'thick',
				'condition' => [
					'source!' => [ 'manual_selection', 'current_loop', 'related', ],
				],
			]
		);

		$this->add_control(
			'taxonomy_heading',
			[
				'label'     => __( 'Taxonomy Query', 'eae-wts' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'source!' => [ 'current_loop', 'related', 'manual_selection' ],
				],
			]
		);

		$eae_taxonomies = PostBase::instance()->get_all_taxonomies();
		
		$post_types = PostBase::instance()->get_rule_post_types();
		
		foreach ( $post_types as $key => $post_type ) {
			$this->add_control(
				$key . '_tax_ids',
				[
					'label'       => 'Taxonomies',
					'type'        => Controls_Manager::SELECT2,
					'multiple'    => true,
					'label_block' => true,
					'placeholder' => __( 'Enter Taxnomies ID Separated by Comma', 'eae-wts' ),
					'options'     => PostBase::instance()->get_taxonomies_by_post_type( $key ),
					'condition'   => [
						'source' => $key,
					],
				]
			);

			$this->add_control(
				$key . '_tax_relation',
				[
					'label'     => __( 'Relation', 'eae-wts' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'OR',
					'options'   => [
						'OR'  => __( 'Anyone Term', 'eae-wts' ),
						'AND' => __( 'All Terms', 'eae-wts' ),
					],
					'condition' => [
						'source' => $key,
					],
				]
			);
		}


		$this->start_controls_tabs( 'tabs_include_exclude' );

		$this->start_controls_tab(
			'tab_query_include',
			[
				'label'     => __( 'Include', 'wts-eae' ),
				'condition' => [
					'source!' => [ 'manual_selection', 'current_loop', 'related', 'relation', 'post_object' ],
				],
			]
		);

		foreach ( $eae_taxonomies as $eae_taxonomy => $object ) {
			foreach ( $object->object_type as $object_type ) {
				$this->add_control(
					$eae_taxonomy . '_' . $object_type . '_include_term_ids',
					[
						'label'       => $object->label,
						'type'        => Controls_Manager::SELECT2,
						'multiple'    => true,
						'label_block' => true,
						'placeholder' => __( 'Enter ' . $object->label . ' ID Separated by Comma', 'wts-eae' ),
						'object_type' => $eae_taxonomy,
						'options'     => PostBase::instance()->get_taxonomy_terms( $eae_taxonomy ),
						'condition'   => [
							'source'                  => $object_type,
							$object_type . '_tax_ids' => $eae_taxonomy,
						],
					]
				);

				$this->add_control(
					$eae_taxonomy . '_' . $object_type . '_term_operator',
					[
						'label'     => __( 'Operator', 'wts-eae' ),
						'type'      => Controls_Manager::SELECT,
						'default'   => 'IN',
						'options'   => [
							'IN'         => __( 'IN', 'wts-eae' ),
							'NOT IN'     => __( 'NOT IN', 'wts-eae' ),
							'AND'        => __( 'AND', 'wts-eae' ),
							'EXISTS'     => __( 'EXISTS', 'wts-eae' ),
							'NOT EXISTS' => __( 'NOT EXISTS', 'wts-eae' ),
						],
						'condition' => [
							'source'                  => $object_type,
							$object_type . '_tax_ids' => $eae_taxonomy,
						],
					]
				);
			}
		}

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_query_exclude',
			[
				'label'     => __( 'Exclude', 'wts-eae' ),
				'condition' => [
					'source!' => [ 'manual_selection', 'current_loop', 'related', 'relation', 'post_object' ],
				],
			]
		);

		foreach ( $eae_taxonomies as $eae_taxonomy => $object ) {
			foreach ( $object->object_type as $object_type ) {
				$this->add_control(
					$eae_taxonomy . '_' . $object_type . '_exclude_term_ids',
					[
						'label'       => $object->label,
						'type'        => Controls_Manager::SELECT2,
						'multiple'    => true,
						'label_block' => true,
						'placeholder' => __( 'Enter ' . $object->label . ' ID Separated by Comma', 'wts-eae' ),
						'object_type' => $eae_taxonomy,
						'options'     => PostBase::instance()->get_taxonomy_terms( $eae_taxonomy ),
						'condition'   => [
							'source'                  => $object_type,
							$object_type . '_tax_ids' => $eae_taxonomy,
						],
					]
				);
			}
		}

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'author_divider',
			[
				'type'      => Controls_Manager::DIVIDER,
				'style'     => 'thick',
				'condition' => [
					'source!' => [ 'current_loop', 'manual_selection' ],
				],
			]
		);

		$this->add_control(
			'author_query_heading',
			[
				'label'     => __( 'Author', 'wts-eae' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'source!' => [ 'current_loop', 'manual_selection' ],
				],
			]
		);

		$this->start_controls_tabs( 'author_query_tabs' );

		$this->start_controls_tab(
			'tab_author_include',
			[
				'label'     => __( 'Include', 'wts-eae' ),
				'condition' => [
					'source!' => [ 'manual_selection', 'current_loop' ],
				],
			]
		);

		$this->add_control(
			'include_author_ids',
			[
				'label'       => 'Authors',
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'label_block' => true,
				'show_label'  => false,
				'placeholder' => __( 'Enter Author ID Separated by Comma', 'wts-eae' ),
				'options'     => PostBase::instance()->get_authors(),
				'condition'   => [
					'source!' => [ 'manual_selection', 'current_loop' ],
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_author_exclude',
			[
				'label'     => __( 'Exclude', 'wts-eae' ),
				'condition' => [
					'source!' => [ 'manual_selection', 'current_loop' ],
				],
			]
		);

		$this->add_control(
			'exclude_author_ids',
			[
				'label'       => 'Authors',
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'label_block' => true,
				'show_label'  => false,
				'placeholder' => __( 'Enter Author ID Separated by Comma', 'wts-eae' ),
				'options'     => PostBase::instance()->get_authors(),
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'date_divider',
			[
				'type'      => Controls_Manager::DIVIDER,
				'style'     => 'thick',
				'condition' => [
					'source!' => 'current_loop',
				],
			]
		);

		$this->add_control(
			'date_query_heading',
			[
				'label'     => __( 'Date Query', 'wts-eae' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'source!' => 'current_loop',
				],
			]
		);

		$this->add_control(
			'select_date',
			[
				'label'     => __( 'Date', 'wts-eae' ),
				'type'      => Controls_Manager::SELECT,
				'post_type' => '',
				'options'   => [
					'anytime' => __( 'All', 'wts-eae' ),
					'today'   => __( 'Past Day', 'wts-eae' ),
					'week'    => __( 'Past Week', 'wts-eae' ),
					'month'   => __( 'Past Month', 'wts-eae' ),
					'quarter' => __( 'Past Quarter', 'wts-eae' ),
					'year'    => __( 'Past Year', 'wts-eae' ),
					'exact'   => __( 'Custom', 'wts-eae' ),
				],
				'default'   => 'anytime',
				'multiple'  => false,
				'condition' => [
					'source!' => [
						'manual_selection',
						'current_loop',
					],
				],
			]
		);

		$this->add_control(
			'post_status',
			[
				'label'       => 'Post Status',
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'label_block' => true,
				'options'     => [
					'publish' => __( 'Publish', 'wts-eae' ),
					'future'  => __( 'Schedule', 'wts-eae' ),
				],
				'condition'   => [
					'select_date' => 'exact',
					'source!'     => [
						'manual_selection',
						'current_loop',
					],
				],
			]
		);

		$this->add_control(
			'date_before',
			[
				'label'       => __( 'Before', 'wts-eae' ),
				'type'        => Controls_Manager::DATE_TIME,
				'post_type'   => '',
				'label_block' => false,
				'multiple'    => false,
				'placeholder' => __( 'Choose', 'wts-eae' ),
				'condition'   => [
					'select_date' => 'exact',
					'source!'     => [
						'manual_selection',
						'current_loop',
					],
				],
				'description' => __( 'Setting a ‘Before’ date will show all the posts published until the chosen date (inclusive).', 'wts-eae' ),
			]
		);

		$this->add_control(
			'date_after',
			[
				'label'       => __( 'After', 'wts-eae' ),
				'type'        => Controls_Manager::DATE_TIME,
				'post_type'   => '',
				'label_block' => false,
				'multiple'    => false,
				'placeholder' => __( 'Choose', 'wts-eae' ),
				'condition'   => [
					'select_date' => 'exact',
					'source!'     => [
						'manual_selection',
						'current_loop',
					],
				],
				'description' => __( 'Setting an ‘After’ date will show all the posts published since the chosen date (inclusive).', 'wts-eae' ),
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'           => __( 'Order By', 'wts-eae' ),
				'type'            => Controls_Manager::SELECT,
				'content_classes' => 'ae_conditional_fields',
				'default'         => 'post_date',
				'options'         => [
					'post_date'      => __( 'Date', 'wts-eae' ),
					'post_title'     => __( 'Title', 'wts-eae' ),
					'menu_order'     => __( 'Menu Order', 'wts-eae' ),
					'rand'           => __( 'Random', 'wts-eae' ),
					'post__in'       => __( 'Manual', 'wts-eae' ),
					'meta_value'     => __( 'Custom Field', 'wts-eae' ),
					'meta_value_num' => __( 'Custom Field (Numeric)', 'wts-eae' ),
				],
				'condition'       => [
					'source!' => 'current_loop',
				],
			]
		);

		$this->add_control(
			'orderby_alert',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'content_classes' => 'ae_order_by_alert',
				'raw'             => __( "<div class='elementor-control-field-description'>Note: Order By 'Manual' is only applicable when Source is 'Manual Selection' and 'Relationship' </div>", 'wts-eae' ),
				'separator'       => 'none',
				'condition'       => [
					'orderby' => 'post__in',
				],
			]
		);

		$this->add_control(
			'orderby_metakey',
			[
				'label'       => __( 'Meta Key Name', 'wts-eae' ),
				'tyoe'        => Controls_Manager::TEXT,
				'description' => __( 'Custom Field Key', 'wts-eae' ),
				'condition'   => [
					'source!' => 'current_loop',
					'orderby' => [ 'meta_value', 'meta_value_num' ],
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label'     => __( 'Order', 'wts-eae' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'desc',
				'options'   => [
					'asc'  => __( 'ASC', 'wts-eae' ),
					'desc' => __( 'DESC', 'wts-eae' ),
				],
				'condition' => [
					'source!'  => 'current_loop',
					'orderby!' => 'post__in',
				],
			]
		);

		$this->add_control(
			'current_post',
			[
				'label'        => __( 'Exclude Current Post', 'wts-eae' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'label_on'     => __( 'Show', 'wts-eae' ),
				'label_off'    => __( 'Hide', 'wts-eae' ),
				'return_value' => 'yes',
				'condition'    => [
					'source!' => 'current_loop',
				],
			]
		);

		$this->add_control(
			'offset',
			[
				'label'       => __( 'Offset', 'wts-eae' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 0,
				'condition'   => [
					'source!' => [ 'current_loop', 'manual_selection' ],
				],
				'description' => __( 'Use this setting to skip over posts (e.g. \'2\' to skip over 2 posts).', 'wts-eae' ),
			]
		);

		$this->add_control(
			'posts_per_page',
			[
				'label'     => __( 'Posts Count', 'wts-eae' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 6,
				'condition' => [
					'source!' => 'current_loop',
				],
			]
		);

		$this->add_control(
			'query_filter',
			[
				'label'       => __( 'Query Filter', 'wts-eae' ),
				'type'        => Controls_Manager::TEXT,
				'description' => __( PostBase::instance()->get_widget_admin_note_html( '<span style="color:red">Danger Ahead!!</span> It is a developer oriented feature. Only use if you know how exaclty WordPress queries and filters works.', 'https://wpvibes.link/go/feature-post-blocks-query-filter', 'Read Instructions' ), 'wts-eae' ),
			]
		);

		

		$this->add_control(
			'no_posts_message',
			[
				'label'     => __( 'No Posts Message', 'wts-eae' ),
				'type'      => Controls_Manager::TEXTAREA,
				'separator' => 'before',
			]
		);


        $this->end_controls_section();
    }

	public function register_title_style_controls() {

		$this->start_controls_section(
			'section_style_title',
			[
				'label' 	=> __( 'Title', 'wts-eae' ),
				'tab'   	=> Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'title_typography',
				'label' 	=> __( 'Typography', 'wts-eae' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
				'selector' 	=> '{{WRAPPER}} .eae-post-title',
			]
		);

		


		$this->add_responsive_control(
			'title_align',
			[
				'label' 		=> __( 'Align Text', 'wts-eae' ),
				'type' 			=> Controls_Manager::CHOOSE,
				'default' 		=> '',
				'options' 		=> [
					'left'    		=> [
						'title' 	=> __( 'Left', 'wts-eae' ),
						'icon' 		=> 'eicon-text-align-left',
					],
					'center' 		=> [
						'title' 	=> __( 'Center', 'wts-eae' ),
						'icon' 		=> 'eicon-text-align-center',
					],
					'right' 		=> [
						'title' 	=> __( 'Right', 'wts-eae' ),
						'icon' 		=> 'eicon-text-align-right',
					],
				],
				'selectors'		=> [
					'{{WRAPPER}} .eae-post-title' 	=> 'text-align: {{VALUE}};',
				],
			]
		);

		$this->start_controls_tabs(
			'title_style_tabs'
		);

		$this->start_controls_tab(
			'title_style_tab',
			[
				'label' => __( 'Normal', 'wts-eae' ),
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' 	=> __( 'Color', 'wts-eae' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-post-title' => 'color: {{VALUE}};',
					'{{WRAPPER}} .eae-post-title .eae-post-title-link' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_background_color',
			[
				'label' 	=> __( 'Background Color', 'wts-eae' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-post-title' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'label' => __( 'Border', 'wts' ),
				'selector' => '{{WRAPPER}} .eae-post-title',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'title_style_tab_hover',
			[
				'label' => __( 'Hover', 'wts-eae' ),
			]
		);

		$this->add_control(
			'title_color_hover',
			[
				'label' 	=> __( 'Color', 'wts-eae' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-post-title:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .eae-post-title:hover .eae-post-title-link' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_background_color_hover',
			[
				'label' 	=> __( 'Background Color', 'wts-eae' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-post-title:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'border_color_hover',
			[
				'label' 	=> __( 'Border Color', 'wts-eae' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-post-title:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'title_padding',
			[
				'label' 		=> __( 'Padding', 'wts-eae' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', 'em', '%' ],
				'separator'		=>	'before',
				'selectors' 	=> [
					'{{WRAPPER}} .eae-post-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_margin',
			[
				'label' 		=> __( 'Margin', 'wts-eae' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', 'em', '%' ],
				
				'selectors' 	=> [
					'{{WRAPPER}} .eae-post-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' 		=> 'title_shadow',
				'selector' 	=> '{{WRAPPER}} .eae-post-title',
			]
		);

		$this->end_controls_section();

	}
	
	public function register_media_style_controls(){

		$this->start_controls_section(
			'section_style_media',
			[
				'label' 	=> __( 'Media', 'wts-eae' ),
				'tab'   	=> Controls_Manager::TAB_STYLE,
				'condition'	=>	[
					'post_media'	=>	'yes'
				]
			]
		);
		$this->start_controls_tabs(
			'media_style_tabs'
		);

		$this->start_controls_tab(
			'media_style_tab',
			[
				'label' => __( 'Normal', 'wts-eae' ),
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'image_border',
				'label'    => __( 'Image Border', 'ae-pro' ),
				'selector' => '{{WRAPPER}} .eae-post-media-wrapper img',
			]
		);

		$this->add_control(
			'media_border_radius',
			[
				'label'      => __( 'Border Radius', 'ae-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .eae-post-media-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .eae-post-media-wrapper img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'media_box_shadow',
				'label'    => __( 'Box Shadow', 'ae-pro' ),
				'selector' => '{{WRAPPER}} .eae-post-media-wrapper img',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'media_style_tab_hover',
			[
				'label' => __( 'Hover', 'wts-eae' ),
			]
		);

		$this->add_control(
			'media_border_color_hover',
			[
				'label' 	=> __( 'Border Color', 'wts-eae' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-post-media-wrapper img:hover' => 'border-color: {{VALUE}};',
				],
			]
		);
		

		$this->add_control(
			'media_border_radius_hover',
			[
				'label'      => __( 'Border Radius', 'ae-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .eae-post-media-wrapper:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .eae-post-media-wrapper:hover img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'media_box_shadow_hover',
				'label'    => __( 'Box Shadow', 'ae-pro' ),
				'selector' => '{{WRAPPER}} .eae-post-media-wrapper:hover img',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		

		$this->add_responsive_control(
			'media_margin',
			[
				'label' 		=> __( 'Margin', 'wts-eae' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', 'em', '%' ],
				'separator'		=>	'before',
				'selectors' 	=> [
					'{{WRAPPER}} .eae-post-media-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);		

		$this->end_controls_section();
	}

	public function register_excerpt_style_controls() {

		$this->start_controls_section(
			'section_style_excerpt',
			[
				'label' => __( 'Excerpt', 'wts-eae' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_excerpt!' => '',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'excerpt_typography',
				'label' 	=> __( 'Typography', 'wts-eae' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' 	=> '{{WRAPPER}} .eae-post-excerpt',
			]
		);

			$this->add_responsive_control(
				'excerpt_align',
				[
					'label' 		=> __( 'Align Text', 'wts-eae' ),
					'type' 			=> Controls_Manager::CHOOSE,
					'default' 		=> '',
					'options' => [
						'left' => [
							'title' => esc_html__( 'Left', 'elementor' ),
							'icon' => 'eicon-text-align-left',
						],
						'center' => [
							'title' => esc_html__( 'Center', 'elementor' ),
							'icon' => 'eicon-text-align-center',
						],
						'right' => [
							'title' => esc_html__( 'Right', 'elementor' ),
							'icon' => 'eicon-text-align-right',
						],
						'justify' => [
							'title' => esc_html__( 'Justified', 'elementor' ),
							'icon' => 'eicon-text-align-justify',
						],
					],
					'selectors'		=> [
						'{{WRAPPER}} .eae-post-excerpt' => 'text-align: {{VALUE}};',
					],
				]
			);

			$this->start_controls_tabs(
				'excerpt_style_tabs'
			);
	
			$this->start_controls_tab(
				'excerpt_style_tab',
				[
					'label' => __( 'Normal', 'wts-eae' ),
				]
			);
	
			$this->add_control(
				'excerpt_color',
				[
					'label' 	=> __( 'Color', 'wts-eae' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .eae-post-excerpt' => 'color: {{VALUE}};',
					],
				]
			);
	
			$this->add_control(
				'excerpt_background_color',
				[
					'label' 	=> __( 'Background Color', 'wts-eae' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .eae-post-excerpt' => 'background-color: {{VALUE}};',
					],
				]
			);
	
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'excerpt_border',
					'label' => __( 'Border', 'wts' ),
					'selector' => '{{WRAPPER}} .eae-post-excerpt',
				]
			);
	
			$this->end_controls_tab();
	
			$this->start_controls_tab(
				'excerpt_style_tab_hover',
				[
					'label' => __( 'Hover', 'wts-eae' ),
				]
			);
	
			$this->add_control(
				'excerpt_color_hover',
				[
					'label' 	=> __( 'Color', 'wts-eae' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .eae-post-excerpt:hover' => 'color: {{VALUE}};',
					],
				]
			);
	
			$this->add_control(
				'excerpt_background_color_hover',
				[
					'label' 	=> __( 'Background Color', 'wts-eae' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .eae-post-excerpt:hover' => 'background-color: {{VALUE}};',
					],
				]
			);
	
			$this->add_control(
				'excerpt_border_color_hover',
				[
					'label' 	=> __( 'Border Color', 'wts-eae' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .eae-post-excerpt:hover' => 'border-color: {{VALUE}};',
					],
				]
			);
	
			$this->end_controls_tab();
	
			$this->end_controls_tabs();

			$this->add_responsive_control(
				'excerpt_padding',
				[
					'label' 		=> __( 'Padding', 'wts-eae' ),
					'type' 			=> Controls_Manager::DIMENSIONS,
					'size_units' 	=> [ 'px', 'em', '%' ],
					'separator'		=>	'before',
					'selectors' 	=> [
						'{{WRAPPER}} .eae-post-excerpt' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					
				]
			);

			$this->add_responsive_control(
				'excerpt_margin',
				[
					'label' 		=> __( 'Margin', 'wts-eae' ),
					'type' 			=> Controls_Manager::DIMENSIONS,
					'size_units' 	=> [ 'px', 'em', '%' ],
					'selectors' 	=> [
						'{{WRAPPER}} .eae-post-excerpt' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					
				]
			);

		$this->end_controls_section();

	}
	
	public function before_loop() {
		global $post;
		do_action( 'eae/widgets/posts/before_loop', $this->get_settings_for_display(), $post->ID );
	}

	protected function after_loop() {
		global $post;

		/**
		 * After Loop
		 *
		 * Fires right after the loop ends
		 *
		 * @since 2.2.0
		 * @param array 	$settings 	The current widget settings
		 * @param int 		$post_id 	The post ID
		 */
		do_action( 'eae/widgets/posts/after_loop', $this->get_settings_for_display(), $post->ID );
	}

	protected function render_loop_start() {
		$settings = $this->get_settings_for_display();
		$masonry = $settings['masonry'];
		if ( ! in_array( $settings[ 'post_media_position' ], array( 'left', 'right' ) ) ) {
			$layout = 'vertical';		
		} else if ( 'yes' === $settings['post_media'] ) {
			$layout = 'horizontal';
		} else {
			$layout = 'vertical';
		}
		$this->add_render_attribute( [
			// 'metas-separator' => [
			// 	'class' => 'ee-post__meta__separator',
			// ],
			// 'terms-separator' => [
			// 	'class' => [
			// 		'ee-post__terms__separator',
			// 	],
			// ],
			'post-loop' => [
				'class' => [
					'eae-layout-grid',
					'eae-post-loop',
					'eae-post-layout-'.$layout
				],
			],

		] );
		if($masonry == 'yes'){
			$this->add_render_attribute('post-loop', 'class', 'eae-masonry-yes');
		}
		if($settings['post_media'] == 'yes'){
			$this->add_render_attribute('post-loop', 'class', 'eae-image-pos-'.$settings['post_media_position']);
		}

			// $this->parent->add_render_attribute( 'post-loop', 'class', 'ee-grid--' . $this->parent->get_settings( 'classic_layout' ) );

		?><div <?php echo $this->get_render_attribute_string( 'post-loop' ); ?>><?php
	}
	protected function render_loop_end() {
		?></div><!-- .ee-loop --><?php
	}

	protected function eae_render_post_title(){
		global $post;
		$settings = $this->get_settings_for_display();
		$post_title = get_the_title($post->ID);
		
		$this->set_render_attribute('eae-post-title-link','class', 'eae-post-title-link');	
		if($settings['use_link'] === 'yes'){
			$this->set_render_attribute('eae-post-title-link','href', get_permalink($post->ID));
		}	
		if($settings['title_open_in_new_tab'] == 'yes'){
			$this->set_render_attribute('eae-post-title-link','target', '_blank');
		}

		if ( $settings['strip_title'] === 'yes' ) {
			if ( $settings['strip_mode'] === 'word' ) {
				$post_title = wp_trim_words( $post_title, $settings['strip_size'], $settings['strip_append'] );
			} else {
				$post_title = $this->eae_trim_letters( $post_title, 0, $settings['strip_size'], $settings['strip_append'] );
			}
		}
		$title_tag = $settings['post_title_tag'];
		?>
		<div class="eae-post-title-wrapper">
			<<?php echo $title_tag; ?> class="eae-post-title">
				<?php if($settings['use_link'] === 'yes'){
				?>
					<a <?php echo $this->get_render_attribute_string('eae-post-title-link');?>>
				<?php
				}
					echo $post_title;
				if($settings['use_link'] === 'yes'){
				?>
					</a>
				<?php
				} ?>
			</<?php echo $title_tag; ?>>
		</div>
		<?php
	}

	public function eae_trim_letters( $string, $start, $length, $append, $html_entity_decode = true, $more = array() ){

		if ( $html_entity_decode ){
			//Convert HTML entities to their corresponding characters
			$string = html_entity_decode($string);
		}
		//Get truncated string with specified width		
		return mb_strimwidth( $string, $start, $length, $append );

	}

	protected function eae_render_post_thumbnail(){
		global $post;
		$settings = $this->get_settings_for_display();
		if($settings['post_media'] != 'yes'){
			return;
		}
		$image_size = $settings['post_thumbnail_size_size'];
		$post_image = get_the_post_thumbnail( $post->ID, $image_size );

		if ( $post_image === '' ) {
			if ( isset( $settings['fallback_image'] ) && isset( $settings['fallback_image']['id'] ) ) {
				if($settings['fallback_image']['id'] == 0){
					$post_image = '<img src="'.$settings['fallback_image']['url'].'"/>' ;
				}else{
					$post_image = wp_get_attachment_image( $settings['fallback_image']['id'], $image_size );
				}
				
			}
		}
		$wrap_calss = [
			'eae-post-media-wrapper'
		];
		if($settings['enable_image_ratio'] == 'yes'){
			$wrap_calss[] = 'eae_image_ratio_yes';
		}		 
		$this->set_render_attribute('post-media-wrap' , 'class', $wrap_calss);
		if($settings['post_media_link'] == 'yes'){
			$this->set_render_attribute('post-media-link' , 'class', 'eae-posts-media-link');
			$this->set_render_attribute('post-media-link' , 'href',  get_permalink($post->ID));
			if($settings['post_media_blank'] == 'yes'){
				$this->add_render_attribute('post-media-link' , 'target',  '_blank');
			}
		}

		?>
		<div <?php echo $this->get_render_attribute_string('post-media-wrap');?>>
			<?php if($settings['post_media_link'] == 'yes'){?>
			<a <?php echo $this->get_render_attribute_string('post-media-link');?>>
			<?php } ?>
			<?php 
				echo $post_image;	
			?>
			<?php if($settings['post_media_link'] == 'yes'){?>
			</a>
			<?php } ?>
		</div>
		<?php			
	}

	protected function eae_render_post_content(){
		global $post;
		$settings = $this->get_settings_for_display();
		if($settings['show_excerpt'] != 'yes'){
			return '';
		}
		$post_excerpt = wpautop( $post->post_excerpt );
		
		$post_content = wpautop($post->post_content);
		?>
		<div class="eae-post-excerpt">
			<?php 
				
				if ( $post_excerpt !== '' ) {
					$post_excerpt = strip_shortcodes( $post_excerpt );
					$content      = wp_trim_words( $post_excerpt, $settings['excerpt_size'], '...' );
				} else {
					$post_content = strip_shortcodes( $post_content );
					$content      = wp_trim_words( $post_content, $settings['excerpt_size'], '...' );
				}
				
				// if ( Plugin::$instance->db->is_built_with_elementor( $post->ID ) ) {
				// 	$content = Plugin::instance()->frontend->get_builder_content( $post->ID, true );
				// } else {
				// 	$content = do_shortcode( $post_content );

				// 	// if content is edited with gutenberg editor.
				// 	if ( function_exists( 'has_blocks' ) && ! has_blocks( $post->ID )) {
				// 		$content = wpautop( $content );
				// 	}

				// 	if ( isset( $GLOBALS['wp_embed'] ) ) {
				// 		$content = $GLOBALS['wp_embed']->autoembed( $content );
				// 	}
				// }
				echo $content;
			?>
		</div>
		<?php
	}
}    