<?php

namespace WTS_EAE\Modules\DataTable\Widgets;

use WTS_EAE\Base\EAE_Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Utils;
use \Elementor\Plugin;
use WTS_EAE\Classes\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class DataTable extends EAE_Widget_Base {

	public function get_name() {
		return 'eae-data-table';
	}

	public function get_title() {
		return __( 'EAE - Data Table', 'wts-eae' );
	}

	public function get_icon() {
		return 'eicon-table';
	}

	public function get_categories() {
		return [ 'wts-eae' ];
	}

	public function get_keywords() {
		return [
			'table',
			'ea table',
			'ea data table',
			'ea data',
			'data table',
		];
	}

	public function get_script_depends() {
		return [ 'eae-data-table', 'eae-lottie' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'eae-table-header-section',
			[
				'label' => __( 'Header', 'wts-eae' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'header_row_column_type',
			[
				'label'   => __( 'Row | Column', 'wts-eae' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'row',
				'options' => [
					'row'    => __( 'Row', 'wts-eae' ),
					'column' => __( 'Column', 'wts-eae' ),
				],
			]
		);

		$repeater->start_controls_tabs( 'table_head_repeater' );

		$repeater->start_controls_tab(
			'table_head_content',
			[
				'label'     => __( 'Content', 'wts-eae' ),
				'condition' => [
					'header_row_column_type' => 'column',
				],
			]
		);

		$repeater->add_control(
			'head_column_name',
			[
				'label'       => __( 'Text', 'wts-eae' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => __( 'Column Name', 'wts-eae' ),
				'default'     => __( 'Column Name', 'wts-eae' ),
				'dynamic'     => [
					'active' => true,
				],
				'condition'   => [
					'header_row_column_type' => 'column',
				],
			]
		);

		$repeater->add_control(
			'head_column_span',
			[
				'label'     => __( 'Column Span', 'wts-eae' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 1,
				'min'       => 0,
				'max'       => 50,
				'step'      => 1,
				'condition' => [
					'header_row_column_type' => 'column',
				],
			]
		);

		$repeater->add_control(
			'head_row_span',
			[
				'label'     => __( 'Row Span', 'wts-eae' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 1,
				'min'       => 0,
				'max'       => 50,
				'step'      => 1,
				'condition' => [
					'header_row_column_type' => 'column',
				],
			]
		);

		$repeater->add_control(
			'head_column_width',
			[
				'label'     => __( 'Column Width', 'wts-eae' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 0,
				'max'       => 100,
				'step'      => 1,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}.eae-table__head_column ' => 'width: {{VALUE}}%;',
				],
				'condition' => [
					'header_row_column_type' => 'column',
				],
			]
		);

		$repeater->add_control(
			'head_column_alignment',
			[
				'label'     => __( 'Alignment', 'wts-eae' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left' => [
						'title' => __( 'Left', 'wts-eae' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'wts-eae' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'wts-eae' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .eae-table__head-column-wrapper ' => 'text-align: {{VALUE}}',
				],
				'condition' => [
					'header_row_column_type' => 'column',
				],
			]
		);

		$repeater->end_controls_tab();

		$repeater->start_controls_tab(
			'table_head_icon',
			[
				'label'     => __( 'Icon', 'wts-eae' ),
				'condition' => [
					'header_row_column_type' => 'column',
				],
			]
		);

		$repeater->add_control(
			'head_icon_type',
			[
				'label'       => __( 'Icon Type', 'wts-eae' ),
				'label_block' => false,
				'type'        => Controls_Manager::CHOOSE,
				'options'     => [
					'none' => [
						'title' => __( 'None', 'wts-eae' ),
						'icon'  => 'eicon-ban',
					],
					'icon' => [
						'title' => __( 'Icon', 'wts-eae' ),
						'icon'  => 'eicon-star',
					],
					'image' => [
						'title' => __( 'Image', 'wts-eae' ),
						'icon'  => 'eicon-image-bold',
					],
					'animation' => [
						'title' => __( 'Lottie Animation', 'wts-eae' ),
						'icon'  => 'eicon-lottie',
					],
				],
				'default'     => 'none',
				'condition'   => [
					'header_row_column_type' => 'column',
				],
			]
		);

		$repeater->add_control(
			'head_column_icon',
			[
				'label'            => __( 'Icon', 'wts-eae' ),
				'type'             => Controls_Manager::ICONS,
				'label_block'      => true,
				'fa4compatibility' => 'head_icon',
				'default'          => [
					'value'   => 'fas fa-star',
					'library' => 'solid',
				],
				'condition'        => [
					'head_icon_type'         => 'icon',
					'header_row_column_type' => 'column',
				],
			]
		);

		$repeater->add_control(
			'head_column_image',
			[
				'label'       => __( 'Image', 'wts-eae' ),
				'label_block' => true,
				'type'        => Controls_Manager::MEDIA,
				'dynamic'     => [
					'active' => true,
				],
				'default'     => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition'   => [
					'head_icon_type'         => 'image',
					'header_row_column_type' => 'column',
				],
			]
		);

		$repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'head_column_image',
				'label'     => __( 'Image Size', 'wts-eae' ),
				'default'   => 'full',
				'exclude'   => [ 'custom' ],
				'condition' => [
					'head_icon_type'         => 'image',
					'header_row_column_type' => 'column',
				],
			]
		);

		$repeater->add_control(
			'lottie_animation_url',
			[
				'label'       => __( 'Animation JSON URL', 'wts-eae' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'description' => 'Get JSON code URL from <a href="https://lottiefiles.com/" target="_blank">here</a>',
				'label_block' => true,
				'condition'   => [
					'head_icon_type'         => 'animation',
					'header_row_column_type' => 'column',
				],
			]
		);

		$repeater->add_control(
			'lottie_animation_loop',
			[
				'label'        => __( 'Loop', 'wts-eae' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => 'Yes',
				'label_off'    => 'No',
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [
					'head_icon_type'         => 'animation',
					'header_row_column_type' => 'column',
				],
			]
		);

		$repeater->add_control(
			'lottie_animation_reverse',
			[
				'label'        => __( 'Reverse', 'wts-eae' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => 'Yes',
				'label_off'    => 'No',
				'return_value' => 'yes',
				'default'      => '',
				'condition'    => [
					'head_icon_type'         => 'animation',
					'header_row_column_type' => 'column',
				],
			]
		);

		$repeater->add_control(
			'head_column_icon_position',
			[
				'label'                => __( 'Position', 'wts-eae' ),
				'type'                 => Controls_Manager::SELECT,
				'default'              => 'before',
				'options'              => [
					'top'    => __( 'Top', 'wts-eae' ),
					'before' => __( 'Before', 'wts-eae' ),
					'after'  => __( 'After', 'wts-eae' ),
					'bottom' => __( 'Bottom', 'wts-eae' ),
				],
				'condition'            => [
					'head_icon_type!'        => 'none',
					'header_row_column_type' => 'column',
				],
				'selectors_dictionary' => [
					'top'    => 'block',
					'before' => 'inline-block',
					'after'  => 'inline-block',
					'bottom' => 'block',
				],
				'selectors'            => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .eae-table__head-column-wrapper .eae-head-icon' => 'display: {{VALUE}}',
				],
				'render_type'          => 'template',
			]
		);

		$repeater->add_responsive_control(
			'eae_head_icon_size',
			[
				'label'     => __( 'Size', 'wts-eae' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 1,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .eae-table__head-column-wrapper .eae-head-icon'   => 'font-size: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} {{CURRENT_ITEM}} .eae-table__head-column-wrapper .eae-head-img' => 'width: {{SIZE}}{{UNIT}} !important;',
					'{{WRAPPER}} {{CURRENT_ITEM}} .eae-table__head-column-wrapper .eae-lottie-animation svg'    => 'width: {{SIZE}}{{UNIT}} !important;',
				],
				'condition' => [
					'head_icon_type!'        => 'none',
					'header_row_column_type' => 'column',
				],
			]
		);

		$repeater->add_responsive_control(
			'eae_head_icon_spacing',
			[
				'label'     => __( 'Spacing', 'wts-eae' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .eae-table__head-column-wrapper .eae-head-icon-before'    => 'margin-right: {{SIZE}}px',
					'{{WRAPPER}} {{CURRENT_ITEM}} .eae-table__head-column-wrapper .eae-head-icon-after'     => 'margin-left: {{SIZE}}px',
					'{{WRAPPER}} {{CURRENT_ITEM}} .eae-table__head-column-wrapper .eae-head-icon-top'       => 'margin-bottom: {{SIZE}}px',
					'{{WRAPPER}} {{CURRENT_ITEM}} .eae-table__head-column-wrapper .eae-head-icon-bottom'    => 'margin-top: {{SIZE}}px',
				],
				'condition' => [
					'head_icon_type!'        => 'none',
					'header_row_column_type' => 'column',
				],

			]
		);

		$repeater->add_control(
			'head_image_radius',
			[
				'label'      => __( 'Border Radius', 'wts-eae' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min' => 1,
						'max' => 200,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .eae-table__head-column-wrapper .eae-head-icon .eae-head-img' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'head_icon_type'         => 'image',
					'header_row_column_type' => 'column',
				],
			]
		);

		$repeater->end_controls_tab();

		$repeater->start_controls_tab(
			'table_head_style',
			[
				'label'     => __( 'Style', 'wts-eae' ),
				'condition' => [
					'header_row_column_type' => 'column',
				],
			]
		);

		$repeater->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'head_typography',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .eae-table__column-text',
			]
		);

		$repeater->add_control(
			'eae_head_custom_text_color',
			[
				'label'     => __( 'Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .eae-table__column-text' => 'color: {{VALUE}}',
					'{{WRAPPER}} {{CURRENT_ITEM}} .eae-table__head-column-wrapper .eae-head-icon' => 'color: {{VALUE}}',
				],
				'condition' => [
					'header_row_column_type' => 'column',
				],
			]
		);

		$repeater->add_control(
			'eae_head_custom_background_color',
			[
				'label'     => __( 'Background Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}.eae-table__head_column' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'header_row_column_type' => 'column',
				],
			]
		);

		$repeater->add_control(
			'eae_head_custom_icon_color',
			[
				'label'     => __( 'Icon Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'head_icon_type'         => 'icon',
					'header_row_column_type' => 'column',
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .eae-table__head-column-wrapper .eae-head-icon' => 'color: {{VALUE}}',
				],
			]
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'head_row_start',
			[
				'label'     => false,
				'type'      => Controls_Manager::HIDDEN,
				'default'   => __( 'Row Start', 'wts-eae' ),
				'condition' => [
					'header_row_column_type' => 'row',
				],
			]
		);

		$this->add_control(
			'header_data',
			[
				'label'       => __( 'Table', 'wts-eae' ),
				'type'        => Controls_Manager::REPEATER,
				'show_label'  => false,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'header_row_column_type' => 'row',
						'head_row_start'         => __( 'Row Start', 'wts-eae' ),
					],
					[
						'header_row_column_type' => 'column',
						'head_column_name'       => __( 'Atomic Number', 'wts-eae' ),
					],
					[
						'header_row_column_type' => 'column',
						'head_column_name'       => __( 'Chemical Symbol', 'wts-eae' ),
					],
					[
						'header_row_column_type' => 'column',
						'head_column_name'       => __( 'Element Name', 'wts-eae' ),
					],
				],
				'title_field' => '<# print( (header_row_column_type === "column" ) ? head_column_name : ("Row Start") ) #>',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'eae_table_body_section',
			[
				'label' => __( 'Body', 'wts-eae' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'eae_row_column_type',
			[
				'label'   => __( 'Row | Column', 'wts-eae' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'row',
				'options' => [
					'row'    => __( 'Row', 'wts-eae' ),
					'column' => __( 'Column', 'wts-eae' ),
				],
			]
		);

		$repeater->start_controls_tabs( 'table_body_repeater' );

		$repeater->start_controls_tab(
			'table_body_content_tab',
			[
				'label'     => __( 'Content', 'wts-eae' ),
				'condition' => [
					'eae_row_column_type' => 'column',
				],
			]
		);

		$repeater->add_control(
			'body_text_type',
			[
				'label'       => __( 'Type', 'wts-eae' ),
				'label_block' => false,
				'type'        => Controls_Manager::CHOOSE,
				'options'     => [
					'text' => [
						'title' => __( 'Text', 'wts-eae' ),
						'icon'  => 'eicon-t-letter-bold',
					],
					'template' => [
						'title' => __( 'Template', 'wts-eae' ),
						'icon'  => 'eicon-folder',
					],

				],
				'default'     => 'text',
				'condition'   => [
					'eae_row_column_type' => 'column',
				],
			]
		);

		$repeater->add_control(
			'body_column_name',
			[
				'label'       => __( 'Text', 'wts-eae' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => __( 'Column Name', 'wts-eae' ),
				'default'     => __( 'Sample # 1', 'wts-eae' ),
				'dynamic'     => [
					'active' => true,
				],
				'condition'   => [
					'eae_row_column_type' => 'column',
					'body_text_type'      => 'text',

				],
			]
		);

		$repeater->add_control(
			'eae_template_type',
			[
				'label'     => __( 'Type', 'wts-eae' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'saved_section' => __( 'Saved Section', 'wts-eae' ),
					'saved_page'    => __( 'Saved Page', 'wts-eae' ),
					'ae_template'   => __( 'AE-Template', 'wts-eae' ),
				],
				'default'   => 'saved_section',
				'condition' => [
					'eae_row_column_type' => 'column',
					'body_text_type'      => 'template',
				],
			]
		);
		$templates = Helper::select_elementor_page( 'section' );
		$repeater->add_control(
			'table_saved_sections',
			[
				'label'     => __( 'Sections', 'wts-eae' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => $templates,
				'condition' => [
					'eae_row_column_type' => 'column',
					'body_text_type'      => 'template',
					'eae_template_type'   => 'saved_section',
				],
			]
		);

		$templates = Helper::select_elementor_page( 'page' );
		$repeater->add_control(
			'table_saved_pages',
			[
				'label'     => __( 'Pages', 'wts-eae' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => $templates,
				'condition' => [
					'eae_row_column_type' => 'column',
					'body_text_type'      => 'template',
					'eae_template_type'   => 'saved_page',
				],
			]
		);

		$templates = Helper::select_ae_templates();
		$repeater->add_control(
			'table_ae_templates',
			[
				'label'     => __( 'AE-Templates', 'wts-eae' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => $templates,
				'condition' => [
					'eae_row_column_type' => 'column',
					'body_text_type'      => 'template',
					'eae_template_type'   => 'ae_template',
				],
			]
		);

		$repeater->add_control(
			'body_column_link',
			[
				'label'       => __( 'Link', 'wts-eae' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => '#',
				'dynamic'     => [
					'active' => true,
				],
				'condition'   => [
					'eae_row_column_type' => 'column',
				],
			]
		);

		$repeater->add_control(
			'body_column_span',
			[
				'label'     => __( 'Column Span', 'wts-eae' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 1,
				'min'       => 0,
				'max'       => 50,
				'step'      => 1,
				'condition' => [
					'eae_row_column_type' => 'column',
				],
			]
		);

		$repeater->add_control(
			'body_row_span',
			[
				'label'     => __( 'Row Span', 'wts-eae' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 1,
				'min'       => 0,
				'max'       => 50,
				'step'      => 1,
				'condition' => [
					'eae_row_column_type' => 'column',
				],
			]
		);

		$repeater->add_control(
			'body_column_alignment',
			[
				'label'     => __( 'Alignment', 'wts-eae' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left' => [
						'title' => __( 'Left', 'wts-eae' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'wts-eae' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'wts-eae' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .eae-table__col-inner' => 'text-align: {{VALUE}}',
				],
				'condition' => [
					'eae_row_column_type' => 'column',
				],
			]
		);

		$repeater->end_controls_tab();

		$repeater->start_controls_tab(
			'table_row_icon',
			[
				'label'     => __( 'Icon', 'wts-eae' ),
				'condition' => [
					'eae_row_column_type' => 'column',
					'body_text_type'      => 'text',
				],
			]
		);

		$repeater->add_control(
			'body_icon_type',
			[
				'label'       => __( 'Icon Type', 'wts-eae' ),
				'label_block' => false,
				'type'        => Controls_Manager::CHOOSE,
				'options'     => [
					'none' => [
						'title' => __( 'None', 'wts-eae' ),
						'icon'  => 'eicon-ban',
					],
					'icon' => [
						'title' => __( 'Icon', 'wts-eae' ),
						'icon'  => 'eicon-star',
					],
					'image' => [
						'title' => __( 'Image', 'wts-eae' ),
						'icon'  => 'eicon-image-bold',
					],
					'animation' => [
						'title' => __( 'Lottie Animation', 'wts-eae' ),
						'icon'  => 'eicon-lottie',
					],
				],
				'default'     => 'none',
				'condition'   => [
					'eae_row_column_type' => 'column',
					'body_text_type'      => 'text',
				],
			]
		);

		$repeater->add_control(
			'body_column_icon',
			[
				'label'            => __( 'Icon', 'wts-eae' ),
				'type'             => Controls_Manager::ICONS,
				'label_block'      => true,
				'fa4compatibility' => 'head_icon',
				'default'          => [
					'value'   => 'fas fa-star',
					'library' => 'solid',
				],
				'condition'        => [
					'body_icon_type'      => 'icon',
					'eae_row_column_type' => 'column',
					'body_text_type'      => 'text',
				],
			]
		);

		$repeater->add_control(
			'body_column_image',
			[
				'label'       => __( 'Image', 'wts-eae' ),
				'label_block' => true,
				'type'        => Controls_Manager::MEDIA,
				'dynamic'     => [
					'active' => true,
				],
				'default'     => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition'   => [
					'body_icon_type'      => 'image',
					'eae_row_column_type' => 'column',
					'body_text_type'      => 'text',
				],
			]
		);

		$repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'body_column_image',
				'label'     => __( 'Image Size', 'wts-eae' ),
				'default'   => 'full',
				'exclude'   => [ 'custom' ],
				'condition' => [
					'body_icon_type'      => 'image',
					'eae_row_column_type' => 'column',
					'body_text_type'      => 'text',
				],
			]
		);

		$repeater->add_control(
			'body_lottie_animation_url',
			[
				'label'       => __( 'Animation JSON URL', 'wts-eae' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'description' => 'Get JSON code URL from <a href="https://lottiefiles.com/" target="_blank">here</a>',
				'label_block' => true,
				'condition'   => [
					'body_icon_type'      => 'animation',
					'eae_row_column_type' => 'column',
					'body_text_type'      => 'text',
				],
			]
		);

		$repeater->add_control(
			'body_lottie_animation_loop',
			[
				'label'        => __( 'Loop', 'wts-eae' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => 'Yes',
				'label_off'    => 'No',
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [
					'body_icon_type'      => 'animation',
					'eae_row_column_type' => 'column',
					'body_text_type'      => 'text',
				],
			]
		);

		$repeater->add_control(
			'body_lottie_animation_reverse',
			[
				'label'        => __( 'Reverse', 'wts-eae' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => 'Yes',
				'label_off'    => 'No',
				'return_value' => 'yes',
				'default'      => '',
				'condition'    => [
					'body_icon_type'      => 'animation',
					'eae_row_column_type' => 'column',
					'body_text_type'      => 'text',
				],
			]
		);

		$repeater->add_control(
			'body_column_icon_position',
			[
				'label'                => __( 'Position', 'wts-eae' ),
				'type'                 => Controls_Manager::SELECT,
				'default'              => 'before',
				'options'              => [
					'top'    => __( 'Top', 'wts-eae' ),
					'before' => __( 'Before', 'wts-eae' ),
					'after'  => __( 'After', 'wts-eae' ),
					'bottom' => __( 'Bottom', 'wts-eae' ),
				],
				'condition'            => [
					'body_icon_type!'     => 'none',
					'eae_row_column_type' => 'column',
					'body_text_type'      => 'text',
				],

				'selectors_dictionary' => [
					'top'    => 'block',
					'before' => 'inline-block',
					'after'  => 'inline-block',
					'bottom' => 'block',
				],
				'selectors'            => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .eae-table__body-column-wrapper .eae-body-icon' => 'display: {{VALUE}}',
				],
				'render_type'          => 'template',
			]
		);

		$repeater->add_responsive_control(
			'body_icon_size',
			[
				'label'     => __( 'Size', 'wts-eae' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 1,
						'max' => 150,
					],
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .eae-table__body-column-wrapper .eae-cell-icon'   => 'font-size: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} {{CURRENT_ITEM}} .eae-table__body-column-wrapper .eae-body-image' => 'width: {{SIZE}}{{UNIT}} !important;',
					'{{WRAPPER}} {{CURRENT_ITEM}} .eae-table__body-column-wrapper .eae-table-lottie-animation svg'    => 'width: {{SIZE}}{{UNIT}} !important;',
				],
				'condition' => [
					'body_icon_type!'     => 'none',
					'eae_row_column_type' => 'column',
					'body_text_type'      => 'text',
				],
			]
		);

		$repeater->add_responsive_control(
			'body_icon_spacing',
			[
				'label'     => __( 'Spacing', 'wts-eae' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .eae-table__body-column-wrapper .eae-body-icon-before'    => 'margin-right: {{SIZE}}px',
					'{{WRAPPER}} {{CURRENT_ITEM}} .eae-table__body-column-wrapper .eae-body-icon-after'     => 'margin-left: {{SIZE}}px',
					'{{WRAPPER}} {{CURRENT_ITEM}} .eae-table__body-column-wrapper .eae-body-icon-top'       => 'margin-bottom: {{SIZE}}px',
					'{{WRAPPER}} {{CURRENT_ITEM}} .eae-table__body-column-wrapper .eae-body-icon-bottom'    => 'margin-top: {{SIZE}}px',
				],
				'condition' => [
					'body_icon_type!'     => 'none',
					'eae_row_column_type' => 'column',
					'body_text_type'      => 'text',
				],

			]
		);

		$repeater->add_control(
			'body_image_radius',
			[
				'label'      => __( 'Border Radius', 'wts-eae' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min' => 1,
						'max' => 200,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .eae-table__body-column-wrapper .eae-body-icon .eae-body-image' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'body_icon_type'      => 'image',
					'eae_row_column_type' => 'column',
					'body_text_type'      => 'text',
				],
			]
		);

		$repeater->end_controls_tab();

		$repeater->start_controls_tab(
			'table_row_style',
			[
				'label'     => __( 'Style', 'wts-eae' ),
				'condition' => [
					'eae_row_column_type' => 'column',
				],
			]
		);

		$repeater->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'body_typography',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .eae-table-body__text',
			]
		);

		$repeater->add_control(
			'eae_col_custom_text_color',
			[
				'label'     => __( 'Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .eae-table-body__text' => 'color: {{VALUE}} !important',
					'{{WRAPPER}} {{CURRENT_ITEM}} .eae-table__body-column-wrapper .eae-cell-icon' => 'color: {{VALUE}} !important',
				],
				'condition' => [
					'eae_row_column_type' => 'column',
				],
			]
		);

		$repeater->add_control(
			'eae_col_custom_background_color',
			[
				'label'     => __( 'Background Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}.eae-table__body_row_column' => 'background-color: {{VALUE}} !important',
				],
				'condition' => [
					'eae_row_column_type' => 'column',
				],
			]
		);

		$repeater->add_control(
			'eae_col_custom_icon_color',
			[
				'label'     => __( 'Icon Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'body_icon_type' => 'icon',
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .eae-table__body-column-wrapper .eae-cell-icon' => 'color: {{VALUE}} !important',
				],
				'condition' => [
					'eae_row_column_type' => 'column',
				],
			]
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'body_row_start',
			[
				'label'     => false,
				'type'      => Controls_Manager::HIDDEN,
				'default'   => __( 'Row Start', 'wts-eae' ),
				'condition' => [
					'eae_row_column_type' => 'row',
				],
			]
		);

		$this->add_control(
			'body_row_data',
			[
				'label'       => __( 'Table Row', 'wts-eae' ),
				'type'        => Controls_Manager::REPEATER,
				'show_label'  => false,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'eae_row_column_type' => 'row',
						'body_row_start'      => __( 'Row Start', 'wts-eae' ),
					],
					[
						'eae_row_column_type' => 'column',
						'body_column_name'    => __( '1', 'wts-eae' ),
					],
					[
						'eae_row_column_type' => 'column',
						'body_column_name'    => __( 'H', 'wts-eae' ),
					],
					[
						'eae_row_column_type' => 'column',
						'body_column_name'    => __( 'Hydrogen', 'wts-eae' ),
					],
					[
						'eae_row_column_type' => 'row',
						'body_row_start'      => __( 'Row Start', 'wts-eae' ),
					],
					[
						'eae_row_column_type' => 'column',
						'body_column_name'    => __( '2', 'wts-eae' ),
					],
					[
						'eae_row_column_type' => 'column',
						'body_column_name'    => __( 'He', 'wts-eae' ),
					],
					[
						'eae_row_column_type' => 'column',
						'body_column_name'    => __( 'Helium', 'wts-eae' ),
					],
					[
						'eae_row_column_type' => 'row',
						'body_row_start'      => __( 'Row Start', 'wts-eae' ),
					],
					[
						'eae_row_column_type' => 'column',
						'body_column_name'    => __( '3', 'wts-eae' ),
					],
					[
						'eae_row_column_type' => 'column',
						'body_column_name'    => __( 'Li', 'wts-eae' ),
					],
					[
						'eae_row_column_type' => 'column',
						'body_column_name'    => __( 'Lithium', 'wts-eae' ),
					],
				],
				'title_field' => '<# print( (eae_row_column_type === "column" ) ? body_column_name : ("Row Start") ) #>',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'eae_table_setting_section',
			[
				'label' => __( 'Table Settings', 'wts-eae' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'eae_table_width',
			[
				'label'      => __( 'Width', 'wts-eae' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
					'%' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .eae-table-container .eae-table-wrapper' => 'width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'eae_table_alignment',
			[
				'label'                => __( 'Alignment', 'wts-eae' ),
				'type'                 => Controls_Manager::CHOOSE,
				'options'              => [
					'left' => [
						'title' => __( 'Left', 'wts-eae' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'wts-eae' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'wts-eae' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'              => 'left',
				'selectors_dictionary' => [
					'left'   => 'margin-right: auto',
					'center' => 'margin: 0 auto',
					'right'  => 'margin-left: auto',
				],
				'selectors'            => [
					'{{WRAPPER}} .eae-table-container .eae-table-wrapper' => '{{VALUE}}',
				],
			]
		);

		$this->add_control(
			'eae_table_search',
			[
				'label'              => __( 'Search', 'wts-eae' ),
				'type'               => Controls_Manager::SWITCHER,
				'description'        => __( 'Search/Filter through the table', 'wts-eae' ),
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'eae_table_search_placeholder',
			[
				'label'     => __( 'Placeholder', 'wts-eae' ),
				'type'      => Controls_Manager::TEXT,
				'dynamic'   => [ 'active' => true ],
				'default'   => __( 'Search...', 'wts-eae' ),
				'condition' => [
					'eae_table_search' => 'yes',
				],
			]
		);

		$this->add_control(
			'sort_heading',
			[
				'label'     => __( 'Sorting', 'wts-eae' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'eae_sortable',
			[
				'label'        => __( 'Sortable Table', 'wts-eae' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'wts-eae' ),
				'label_off'    => __( 'No', 'wts-eae' ),
				'description'  => __( 'Sort table entries on the click of table headings.', 'wts-eae' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->add_control(
			'sort_icon_type',
			[
				'label'       => __( 'Icon Type', 'wts-eae' ),
				'label_block' => false,
				'type'        => Controls_Manager::CHOOSE,
				'options'     => [
					'none' => [
						'title' => __( 'None', 'wts-eae' ),
						'icon'  => 'eicon-ban',
					],
					'default' => [
						'title' => __( 'Default', 'wts-eae' ),
						'icon'  => 'eicon-info-circle',
					],
					'custom' => [
						'title' => __( 'Custom', 'wts-eae' ),
						'icon'  => 'eicon-pencil',
					],
				],
				'default'     => 'default',
				'condition'   => [
					'eae_sortable' => 'yes',
				],
			]
		);

		$this->add_control(
			'sort_icon',
			[
				'label'            => __( 'Default', 'wts-eae' ),
				'type'             => Controls_Manager::ICONS,
				'label_block'      => true,
				'fa4compatibility' => 'icon',
				'default'          => [
					'value'   => 'fas fa-arrows-alt-v',
					'library' => 'solid',
				],
				'recommended'      => [
					'fa-solid' => [
						'arrows-alt-v',
					],
				],
				'condition'        => [
					'eae_sortable'   => 'yes',
					'sort_icon_type' => 'custom',
				],
			]
		);

		$this->add_control(
			'sort_icon_up',
			[
				'label'            => __( 'Ascending', 'wts-eae' ),
				'type'             => Controls_Manager::ICONS,
				'label_block'      => true,
				'fa4compatibility' => 'icon',
				'default'          => [
					'value'   => 'fas fa-long-arrow-alt-up',
					'library' => 'solid',
				],
				'recommended'      => [
					'fa-solid' => [
						'long-arrow-alt-up',
						'arrow-up',
						'sort-amount-up',
						'sort-amount-up-alt',
						'level-up-alt',
						'caret-square-up',
						'angle-double-up',
						'sort-alpha-up-alt',
						'sort-numeric-up-alt',
					],
				],
				'condition'        => [
					'eae_sortable'   => 'yes',
					'sort_icon_type' => 'custom',
				],
			]
		);

		$this->add_control(
			'sort_icon_down',
			[
				'label'            => __( 'Descending', 'wts-eae' ),
				'type'             => Controls_Manager::ICONS,
				'label_block'      => true,
				'fa4compatibility' => 'icon',
				'default'          => [
					'value'   => 'fas fa-long-arrow-alt-down',
					'library' => 'solid',
				],
				'recommended'      => [
					'fa-solid' => [
						'long-arrow-alt-down',
						'arrow-down',
						'sort-amount-down',
						'sort-amount-down-alt',
						'level-down-alt',
						'caret-square-down',
						'angle-double-down',
						'sort-alpha-down-alt',
						'sort-numeric-down-alt',
					],
				],
				'condition'        => [
					'eae_sortable'   => 'yes',
					'sort_icon_type' => 'custom',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'eae_table_style_section',
			[
				'label' => __( 'Table', 'wts-eae' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'eae_table_background_color',
				'label'    => __( 'Background Color', 'wts-eae' ),
				'types'    => [ 'classic', 'gradient' ],
				'exclude'  => [ 'image' ],
				'selector' => '{{WRAPPER}} .eae-table',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'eae_table_border',
				'label'     => __( 'Border', 'wts-eae' ),
				'selector'  => '{{WRAPPER}} .eae-table',
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'eae-header-style-section',
			[
				'label' => __( 'Header', 'wts-eae' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'header_typography',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .eae-table__column-text',
			]
		);

		$this->start_controls_tabs( 'header_style_tabs' );

		$this->start_controls_tab(
			'tab_header_normal_style',
			[
				'label' => __( 'Normal', 'wts-eae' ),
			]
		);

		$this->add_control(
			'header_color',
			[
				'label'     => __( 'Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fff',
				'selectors' => [
					'{{WRAPPER}} .eae-table__column-text' => 'color: {{VALUE}};',
					'{{WRAPPER}} .eae-table__head-column-wrapper .eae-head-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'header_background_color',
			[
				'label'     => __( 'Background Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#40aef8',
				'selectors' => [
					'{{WRAPPER}} .eae-table__head_column' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'header_icon_color',
			[
				'label'     => __( 'Icon Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .eae-table__head-column-wrapper .eae-head-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_header_hover_style',
			[
				'label' => __( 'Hover', 'wts-eae' ),
			]
		);

		$this->add_control(
			'header_hover_color',
			[
				'label'     => __( 'Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-table__head_column:hover .eae-table__column-text' => 'color: {{VALUE}};',
					'{{WRAPPER}} .eae-table__head_column:hover .eae-table__head-column-wrapper .eae-head-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'header_hover_background_color',
			[
				'label'     => __( 'Background Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-table__head_column:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'header_hover_icon_color',
			[
				'label'     => __( 'Icon Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .eae-table__head_column:hover .eae-table__head-column-wrapper .eae-head-icon' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'header_border_hover_color',
			[
				'label'     => __( 'Border Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'header_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .eae-table__head_column:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'header_border',
				'fields_options' => [
					'border' => [
						'default' => 'solid',
					],
					'width'  => [
						'default' => [
							'top'    => 1,
							'right'  => 1,
							'bottom' => 1,
							'left'   => 1,
							'unit'   => 'px',
						],
					],
				],
				'selector'       => '{{WRAPPER}} .eae-table .eae-table-head .eae-table__head_column',
				'separator'      => 'before',
			]
		);

		$this->add_responsive_control(
			'eae_header_padding',
			[
				'label'      => __( 'Padding', 'wts-eae' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [
					'top'    => 12,
					'right'  => 12,
					'bottom' => 12,
					'left'   => 12,
					'unit'   => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .eae-table__head_column' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
				'separator'  => 'before',
			]
		);
		$this->add_responsive_control(
			'header_column_alignment',
			[
				'label'     => __( 'Alignment', 'wts-eae' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left' => [
						'title' => __( 'Left', 'wts-eae' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'wts-eae' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'wts-eae' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .eae-table__head-column-wrapper ' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'eae-rows-style-section',
			[
				'label' => __( 'Rows', 'wts-eae' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'rows_typography',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .eae-table-body__text',
			]
		);

		$this->add_control(
			'row_strip_style',
			[
				'label'        => __( 'Striped Rows', 'wts-eae' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '',
				'label_on'     => 'Yes',
				'label_off'    => 'No',
				'return_value' => 'yes',
			]
		);

		$this->start_controls_tabs( 'rows_striped_tabs' );

		$this->start_controls_tab(
			'tab_rows_even_style',
			[
				'label'     => __( 'Even', 'wts-eae' ),
				'condition' => [
					'row_strip_style' => 'yes',
				],
			]
		);

		$this->add_control(
			'rows_even_color',
			[
				'label'     => __( 'Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .eae-table .eae-table__body .eae-table__body-row:nth-child(even) .eae-table__col-inner .eae-table-body__text' => 'color: {{VALUE}};',
					'{{WRAPPER}} .eae-table .eae-table__body .eae-table__body-row:nth-child(even) .eae-table__body-column-wrapper .eae-cell-icon' => 'color: {{VALUE}};',
				],
				'condition' => [
					'row_strip_style' => 'yes',
				],
			]
		);

		$this->add_control(
			'rows_even_hover_color',
			[
				'label'     => __( 'Hover Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .eae-table .eae-table__body .eae-table__body-row:nth-child(even):hover .eae-table__col-inner .eae-table-body__text' => 'color: {{VALUE}};',
					'{{WRAPPER}} .eae-table .eae-table__body .eae-table__body-row:nth-child(even):hover .eae-table__body-column-wrapper .eae-cell-icon' => 'color: {{VALUE}};',
				],
				'condition' => [
					'row_strip_style' => 'yes',
				],
			]
		);

		$this->add_control(
			'row_even_background_color',
			[
				'label'     => __( 'Background Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-table .eae-table__body .eae-table__body-row:nth-child(even)' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'row_strip_style' => 'yes',
				],
			]
		);

		$this->add_control(
			'row_even_hover_background_color',
			[
				'label'     => __( 'Hover Background Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-table .eae-table__body .eae-table__body-row:nth-child(even):hover' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'row_strip_style' => 'yes',
				],
			]
		);

		$this->add_control(
			'row_even_icon_color',
			[
				'label'     => __( 'Icon Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .eae-table .eae-table__body .eae-table__body-row:nth-child(even) .eae-table__body-column-wrapper .eae-cell-icon' => 'color: {{VALUE}};',
				],
				'condition' => [
					'row_strip_style' => 'yes',
				],
			]
		);

		$this->add_control(
			'row_even_hover_icon_color',
			[
				'label'     => __( 'Hover Icon Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .eae-table .eae-table__body .eae-table__body-row:nth-child(even):hover .eae-table__body-column-wrapper .eae-cell-icon' => 'color: {{VALUE}};',
				],
				'condition' => [
					'row_strip_style' => 'yes',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_rows_odd_style',
			[
				'label'     => __( 'Odd', 'wts-eae' ),
				'condition' => [
					'row_strip_style' => 'yes',
				],
			]
		);

		$this->add_control(
			'rows_odd_color',
			[
				'label'     => __( 'Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .eae-table .eae-table__body .eae-table__body-row:nth-child(odd) .eae-table__col-inner .eae-table-body__text' => 'color: {{VALUE}};',
					'{{WRAPPER}} .eae-table .eae-table__body .eae-table__body-row:nth-child(odd) .eae-table__body-column-wrapper .eae-cell-icon' => 'color: {{VALUE}};',
				],
				'condition' => [
					'row_strip_style' => 'yes',
				],
			]
		);

		$this->add_control(
			'rows_odd_hover_color',
			[
				'label'     => __( 'Hover Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .eae-table .eae-table__body .eae-table__body-row:nth-child(odd):hover .eae-table__col-inner .eae-table-body__text' => 'color: {{VALUE}};',
					'{{WRAPPER}} .eae-table .eae-table__body .eae-table__body-row:nth-child(odd):hover .eae-table__body-column-wrapper .eae-cell-icon' => 'color: {{VALUE}};',
				],
				'condition' => [
					'row_strip_style' => 'yes',
				],
			]
		);

		$this->add_control(
			'row_odd_background_color',
			[
				'label'     => __( 'Background Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-table .eae-table__body .eae-table__body-row:nth-child(odd)' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'row_strip_style' => 'yes',
				],
			]
		);

		$this->add_control(
			'row_odd_hover_background_color',
			[
				'label'     => __( 'Hover Background Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-table .eae-table__body .eae-table__body-row:nth-child(odd):hover' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'row_strip_style' => 'yes',
				],
			]
		);

		$this->add_control(
			'row_odd_icon_color',
			[
				'label'     => __( 'Icon Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .eae-table .eae-table__body .eae-table__body-row:nth-child(odd) .eae-table__body-column-wrapper .eae-cell-icon' => 'color: {{VALUE}};',
				],
				'condition' => [
					'row_strip_style' => 'yes',
				],
			]
		);

		$this->add_control(
			'row_odd_hover_icon_color',
			[
				'label'     => __( 'Hover Icon Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .eae-table .eae-table__body .eae-table__body-row:nth-child(odd):hover .eae-table__body-column-wrapper .eae-cell-icon' => 'color: {{VALUE}};',
				],
				'condition' => [
					'row_strip_style' => 'yes',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->start_controls_tabs( 'rows_style_tabs' );

		$this->start_controls_tab(
			'tab_rows_normal_style',
			[
				'label'     => __( 'Normal', 'wts-eae' ),
				'condition' => [
					'row_strip_style!' => 'yes',
				],
			]
		);

		$this->add_control(
			'rows_color',
			[
				'label'     => __( 'Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .eae-table-body__text' => 'color: {{VALUE}};',
					'{{WRAPPER}} .eae-table__body-column-wrapper .eae-cell-icon' => 'color: {{VALUE}};',
				],
				'condition' => [
					'row_strip_style!' => 'yes',
				],
			]
		);

		$this->add_control(
			'row_background_color',
			[
				'label'     => __( 'Background Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-table .eae-table__body-row' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'row_strip_style!' => 'yes',
				],
			]
		);

		$this->add_control(
			'row_icon_color',
			[
				'label'     => __( 'Icon Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .eae-table__body-column-wrapper .eae-cell-icon' => 'color: {{VALUE}};',
				],
				'condition' => [
					'row_strip_style!' => 'yes',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_rows_hover_style',
			[
				'label'     => __( 'Hover', 'wts-eae' ),
				'condition' => [
					'row_strip_style!' => 'yes',
				],
			]
		);

		$this->add_control(
			'row_hover_color',
			[
				'label'     => __( 'Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-table__body_row_column:hover .eae-table-body__text' => 'color: {{VALUE}};',
					'{{WRAPPER}} .eae-table__body_row_column:hover .eae-table__col-inner .eae-cell-icon' => 'color: {{VALUE}};',
				],
				'condition' => [
					'row_strip_style!' => 'yes',
				],
			]
		);

		$this->add_control(
			'row_hover_background_color',
			[
				'label'     => __( 'Background Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-table__body-row:hover' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'row_strip_style!' => 'yes',
				],
			]
		);

		$this->add_control(
			'row_hover_icon_color',
			[
				'label'     => __( 'Icon Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .eae-table__body_row_column:hover .eae-table__col-inner .eae-cell-icon' => 'color: {{VALUE}};',
				],
				'condition' => [
					'row_strip_style!' => 'yes',
				],
			]
		);
		$this->add_control(
			'row_border_hover_color',
			[
				'label'     => __( 'Border Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'row_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .eae-table__body_row_column:hover' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'row_strip_style!' => 'yes',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'row_border',
				'fields_options' => [
					'border' => [
						'default' => 'solid',
					],
					'width'  => [
						'default' => [
							'top'    => 1,
							'right'  => 1,
							'bottom' => 1,
							'left'   => 1,
							'unit'   => 'px',
						],
					],
				],
				'selector'       => '{{WRAPPER}} .eae-table .eae-table__body .eae-table__body_row_column',
				'separator'      => 'before',
			]
		);

		$this->add_responsive_control(
			'eae_row_padding',
			[
				'label'      => __( 'Padding', 'wts-eae' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [
					'top'    => 12,
					'right'  => 12,
					'bottom' => 12,
					'left'   => 12,
					'unit'   => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .eae-table__body_row_column' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'eae_row_alignment',
			[
				'label'     => __( 'Alignment', 'wts-eae' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left' => [
						'title' => __( 'Left', 'wts-eae' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'wts-eae' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'wts-eae' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .eae-table__col-inner' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'eae-column-style-section',
			[
				'label' => __( 'Column', 'wts-eae' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'column_typography',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .eae-table-body__text',
			]
		);

		$this->start_controls_tabs( 'column_style_tabs' );

		$this->start_controls_tab(
			'tab_column_even_style',
			[
				'label' => __( 'Even', 'wts-eae' ),

			]
		);

		$this->add_control(
			'column_even_color',
			[
				'label'     => __( 'Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-table .eae-table__body_row_column:nth-child(even) .eae-table__body-column-wrapper .eae-table-body__text' => 'color: {{VALUE}}',
					'{{WRAPPER}} .eae-table .eae-table__body_row_column:nth-child(even) .eae-table__body-column-wrapper i' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'column_even_hover_color',
			[
				'label'     => __( 'Hover Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-table .eae-table__body_row_column:nth-child(even):hover .eae-table__body-column-wrapper .eae-table-body__text' => 'color: {{VALUE}}',
					'{{WRAPPER}} .eae-table .eae-table__body_row_column:nth-child(even):hover .eae-table__body-column-wrapper i' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'column_even_background_color',
			[
				'label'     => __( 'Background Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-table .eae-table__body_row_column:nth-child(even)' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'column_even_hover_background_color',
			[
				'label'     => __( 'Hover Background Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-table .eae-table__body_row_column:nth-child(even):hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'column_even_icon_color',
			[
				'label'     => __( 'Icon Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .eae-table .eae-table__body_row_column:nth-child(even) .eae-table__body-column-wrapper i' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'column_even_hover_icon_color',
			[
				'label'     => __( 'Hover Icon Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .eae-table .eae-table__body_row_column:nth-child(even):hover .eae-table__body-column-wrapper i' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_column_odd_style',
			[
				'label' => __( 'Odd', 'wts-eae' ),

			]
		);

		$this->add_control(
			'column_odd_color',
			[
				'label'     => __( 'Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-table .eae-table__body_row_column:nth-child(odd) .eae-table__body-column-wrapper .eae-table-body__text' => 'color: {{VALUE}}',
					'{{WRAPPER}} .eae-table .eae-table__body_row_column:nth-child(odd) .eae-table__body-column-wrapper i' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'column_odd_hover_color',
			[
				'label'     => __( 'Hover Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-table .eae-table__body_row_column:nth-child(odd):hover .eae-table__body-column-wrapper .eae-table-body__text' => 'color: {{VALUE}}',
					'{{WRAPPER}} .eae-table .eae-table__body_row_column:nth-child(odd):hover .eae-table__body-column-wrapper i' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'column_odd_background_color',
			[
				'label'     => __( 'Background Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-table .eae-table__body_row_column:nth-child(odd)' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'column_odd_hover_background_color',
			[
				'label'     => __( 'Hover Background Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eae-table .eae-table__body_row_column:nth-child(odd):hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'column_odd_icon_color',
			[
				'label'     => __( 'Icon Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .eae-table .eae-table__body_row_column:nth-child(odd) .eae-table__body-column-wrapper i' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'column_odd_hover_icon_color',
			[
				'label'     => __( 'Hover Icon Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .eae-table .eae-table__body_row_column:nth-child(odd):hover .eae-table__body-column-wrapper i' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'eae-table-search-section',
			[
				'label'     => __( 'Search', 'wts-eae' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'eae_table_search' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'eae_table_search_width',
			[
				'label'      => __( 'Width', 'wts-eae' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min' => 1,
						'max' => 500,
					],
					'%' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'default'    => [
					'unit' => '%',
					'size' => 50,
				],
				'selectors'  => [
					'{{WRAPPER}} .eae-search-wrap' => 'width: {{SIZE}}{{UNIT}}',
				],
				'condition'  => [
					'eae_table_search' => 'yes',
				],
			]
		);

		$this->add_control(
			'eae_table_search_alignment',
			[
				'label'     => __( 'Alignment', 'wts-eae' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left' => [
						'title' => __( 'Left', 'wts-eae' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'wts-eae' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'wts-eae' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'   => 'right',

				'selectors' => [
					'{{WRAPPER}} .eae-table-search-wrap ' => 'text-align: {{VALUE}}',
				],
				'condition' => [
					'eae_table_search' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'search_bottom_spacing',
			[
				'label'     => __( 'Bottom Spacing', 'wts-eae' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 1,
						'max' => 100,
					],

				],
				'default'   => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .eae-table-search-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'eae_table_search' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'search_border',
				'label'     => __( 'Border', 'wts-eae' ),
				'selector'  => '{{WRAPPER}} .eae-search-wrap',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'search_radius',
			[
				'label'     => __( 'Border Radius', 'wts-eae' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'   => [
					'unit' => 'px',
					'size' => 2,
				],
				'selectors' => [
					'{{WRAPPER}} .eae-search-wrap' => 'border-radius: {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'eae_table_search' => 'yes',
				],
			]
		);

		$this->add_control(
			'search_input_heading',
			[
				'label'     => __( 'Input', 'wts-eae' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'eae_table_search' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'search_typography',
				'global'    => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
				'selector'  => '{{WRAPPER}} .eae-table-search-field',
				'condition' => [
					'eae_table_search' => 'yes',
				],
			]
		);

		$this->add_control(
			'eae_table_search_color',
			[
				'label'     => __( 'Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#7A7A7A',
				'selectors' => [
					'{{WRAPPER}} .eae-table-search-field' => 'color: {{VALUE}}',
					'{{WRAPPER}} ::placeholder'           => 'color: {{VALUE}}',
				],
				'condition' => [
					'eae_table_search' => 'yes',
				],
			]
		);

		$this->add_control(
			'eae_table_search_background_color',
			[
				'label'     => __( 'Background Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#eceeef',
				'selectors' => [
					'{{WRAPPER}} .eae-table-search-field' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'eae_table_search' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'search_input_padding',
			[
				'label'      => __( 'Padding', 'wts-eae' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'    => '10',
					'right'  => '10',
					'bottom' => '10',
					'left'   => '10',
					'unit'   => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .eae-table-search-field' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'search_icon_heading',
			[
				'label'     => __( 'Icon', 'wts-eae' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'eae_table_search' => 'yes',
				],
			]
		);

		$this->add_control(
			'search_icon_position',
			[
				'label'        => __( 'Position', 'wts-eae' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'before',
				'options'      => [
					'before' => __( 'Before', 'wts-eae' ),
					'after'  => __( 'After', 'wts-eae' ),
				],
				'condition'    => [
					'eae_table_search' => 'yes',
				],
				'prefix_class' => 'eae-table--search-icon--',
				'render_type'  => 'template',
			]
		);

		$this->add_responsive_control(
			'eae_search_icon_size',
			[
				'label'     => __( 'Size', 'wts-eae' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 1,
						'max' => 50,
					],
				],
				'default'   => [
					'size' => '20',
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .search-icon i' => 'font-size: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'eae_table_search' => 'yes',
				],
			]
		);

		$this->add_control(
			'eae_search_icon_color',
			[
				'label'     => __( 'Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#7A7A7A73',
				'selectors' => [
					'{{WRAPPER}} .search-icon i' => 'color: {{VALUE}}',
				],
				'condition' => [
					'eae_table_search' => 'yes',
				],
			]
		);

		$this->add_control(
			'eae_search_icon_background_color',
			[
				'label'     => __( 'Background Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#eceeef',
				'selectors' => [
					'{{WRAPPER}} .search-icon' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'eae_table_search' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'search_icon_padding',
			[
				'label'      => __( 'Padding', 'wts-eae' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'    => '10',
					'right'  => '10',
					'bottom' => '10',
					'left'   => '10',
					'unit'   => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .search-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'eae-table-sort-section',
			[
				'label'     => __( 'Sort', 'wts-eae' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'eae_sortable'    => 'yes',
					'sort_icon_type!' => 'none',
				],
			]
		);

		$this->add_control(
			'eae_sort_icon_color',
			[
				'label'     => __( 'Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fff',
				'selectors' => [
					'{{WRAPPER}} .eae-sort-icon .eae-icon-sort-icon .eae-icon' => 'color: {{VALUE}}',
				],
				'condition' => [
					'eae_sortable'    => 'yes',
					'sort_icon_type!' => 'none',
				],
			]
		);
		$this->add_control(
			'eae_sort_hover_icon_color',
			[
				'label'     => __( 'Hover Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fff',
				'selectors' => [
					'{{WRAPPER}} .eae-table__head__wrapper:hover .eae-sort-icon .eae-icon' => 'color: {{VALUE}}',
				],
				'condition' => [
					'eae_sortable'    => 'yes',
					'sort_icon_type!' => 'none',
				],
			]
		);

		$this->add_responsive_control(
			'eae_sort_icon_size',
			[
				'label'     => __( 'Size', 'wts-eae' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 1,
						'max' => 50,
					],
				],
				'default'   => [
					'size' => '18',
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .eae-table__head__wrapper .eae-sort-icon .eae-icon' => 'font-size: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'eae_sortable'    => 'yes',
					'sort_icon_type!' => 'none',
				],
			]
		);

		$this->end_controls_section();
	}



	protected function render() {

		$settings = $this->get_settings();

		$this->add_render_attribute( 'table-container', 'class', [ 'eae-table-container' ] );

		$this->add_render_attribute( 'table-wrapper', 'class', [ 'eae-table-wrapper' ] );

		if ( $settings['eae_sortable'] === 'yes' ) {
			$this->add_render_attribute( 'table', 'class', 'eae-table__sortable' );
		}

		$table_data = [
			'sort'   => ( $settings['eae_sortable'] === 'yes' ) ? true : false,
			'search' => ( $settings['eae_table_search'] === 'yes' ) ? true : false,
		];

		$this->add_render_attribute(
			'table',
			[
				'class'         => 'eae-table',
				'data-settings' => wp_json_encode( $table_data ),
			]
		);

		if ( $settings['eae_table_search'] === 'yes' ) {
			$this->add_render_attribute(
				'eae-search',
				[
					'class'        => 'eae-table-search-field',
					'id'           => 'eae-searchable',
					'type'         => 'search',
					'title'        => 'search',
					'placeholder'  => $settings['eae_table_search_placeholder'],
					'autocomplete' => 'off',
				]
			);
			$this->add_render_attribute( 'table', 'class', 'eae-table__search' );
		}

		?>

		<div <?php echo $this->get_render_attribute_string( 'table-container' ); ?>>
			<div <?php echo $this->get_render_attribute_string( 'table-wrapper' ); ?>>
			<?php if ( $settings['eae_table_search'] === 'yes' ) { ?>
				<div class="eae-table-search-wrap">
					<div class="eae-search-wrap">
						<?php if ( $settings['search_icon_position'] === 'before' ) { ?>
							<div class="search-icon">
								<i class="fa fas fa-search"></i>
							</div>
						<?php } ?>
						<input <?php echo $this->get_render_attribute_string( 'eae-search' ); ?>>

						<?php if ( $settings['search_icon_position'] === 'after' ) { ?>
							<div class="search-icon">
								<i class="fa fas fa-search"></i>
							</div>
						<?php } ?>
					</div>    
				</div>
			<?php } ?>
				<div class="eae-table-wrap">
				
				<table <?php echo $this->get_render_attribute_string( 'table' ); ?>>
					<?php $this->table_render_header( $settings ); ?>
					<?php $this->table_render_body( $settings ); ?>
				</table>
				</div>			
			</div>
		</div>

		<?php
	}

	protected function table_render_header( $settings ) {

		$this->add_render_attribute( 'table_head', 'class', [ 'eae-table-head' ] );
		?>

		<thead <?php echo $this->get_render_attribute_string( 'table_head' ); ?>>
			<?php
				$counter     = 0;
				$header_data = $settings['header_data'];
				$row_counter = 0;
				// count rows in header
			foreach ( $header_data as $head_data ) {
				if ( $head_data['header_row_column_type'] === 'row' ) {
					$row_counter++;
				}
			}

			foreach ( $header_data as $index => $head_data ) {
				if ( $head_data['header_row_column_type'] === 'row' ) {
					$this->render_head_row( $counter );
					$counter++;
				} else {
					$sortable = $counter === $row_counter ? true : false;
					$this->render_head_column( $head_data, $index, $settings, $sortable );
				}
			}
			?>
		</thead> 
		<?php
	}

	public function render_head_row( $counter ) {

		$this->set_render_attribute( 'table_head_row', 'class', [ 'eae-table-row' ] );
		if ( $counter ) {
			?>
			</tr><tr <?php echo $this->get_render_attribute_string( 'table_head_row' ); ?>>
		<?php } else { ?>
			<tr <?php echo $this->get_render_attribute_string( 'table_head_row' ); ?>>
			<?php
		}
	}

	public function render_head_column( $head_data, $index, $settings, $sortable ) {

		$id        = $head_data['_id'];
		$head_text = $head_data['head_column_name'];

		$head_column_repeater_key = $this->get_repeater_setting_key( 'head_column_span', 'header_data', $index );

		$this->set_render_attribute(
			$head_column_repeater_key,
			[
				'class' => [ 'eae-table__head_column', 'elementor-repeater-item-' . $id ],
			]
		);

		if ( $settings['eae_sortable'] === 'yes' && $sortable ) {
			$this->add_render_attribute( $head_column_repeater_key, 'class', 'eae-table__sortable-head' );
		}

		// colspan & rowspan
		if ( $head_data['head_column_span'] > 1 ) {
			$this->add_render_attribute( $head_column_repeater_key, 'colspan', $head_data['head_column_span'] );
		}
		if ( $head_data['head_row_span'] > 1 ) {
			$this->add_render_attribute( $head_column_repeater_key, 'rowspan', $head_data['head_row_span'] );
		}
		$this->set_render_attribute( 'main-wrap', 'class', 'eae-table__head__wrapper' );
		if ( $head_data['head_column_icon_position'] === 'before' || $head_data['head_column_icon_position'] === 'after' ) {
			$this->set_render_attribute( 'main-wrap', 'style', 'flex-direction: row;' );
		} else {
			$this->set_render_attribute( 'main-wrap', 'style', 'flex-direction: column;' );
		}
		?>

		<th <?php echo $this->get_render_attribute_string( $head_column_repeater_key ); ?>>
			<div <?php echo $this->get_render_attribute_string( 'main-wrap' ); ?> >
				<div class="eae-table__head-column-wrapper">

					<?php
					if ( $head_data['head_column_icon_position'] === 'before' || $head_data['head_column_icon_position'] === 'top' ) :
						$this->render_head_icon( $head_data );
					endif;
					?>
					<?php if ( ! empty( $head_text ) ) : ?>
						<span class="eae-table__column-text"><?php echo esc_attr( $head_text ); ?></span>
					<?php endif; ?>

					<?php
					if ( $head_data['head_column_icon_position'] === 'after' || $head_data['head_column_icon_position'] === 'bottom' ) :
						$this->render_head_icon( $head_data );
					endif;
					?>

				</div>
				<?php
				if ( $settings['eae_sortable'] === 'yes' && $sortable ) :
					$this->render_sort_icon( $settings );
				endif;
				?>
			</div>      
		</th>
		<?php
	}

	public function render_sort_icon( $settings ) {

		if ( $settings['sort_icon_type'] === 'default' || $settings['sort_icon_type'] === 'custom' ) :
			?>
			<div class="eae-sort-icon">
					<span class='eae-icon-sort-icon'>
						<?php if ( $settings['sort_icon_type'] === 'default' ) : ?>
							<i class="fas fa-sort eae-icon"></i>
						<?php endif; ?> 
						<?php if ( $settings['sort_icon_type'] === 'custom' ) : ?>
							<i class="<?php echo esc_attr( $settings['sort_icon']['value'] ); ?> eae-icon"></i>
						<?php endif; ?>  
					</span>

					<span class='eae-icon-sort-icon eae-sort-icon-up'>
						<?php if ( $settings['sort_icon_type'] === 'default' ) : ?>
							<i class="fas fa-sort-up eae-icon"></i>
						<?php endif; ?>
						<?php if ( $settings['sort_icon_type'] === 'custom' ) : ?>
							<i class="<?php echo esc_attr( $settings['sort_icon_up']['value'] ); ?> eae-icon"></i>
						<?php endif; ?>  
					</span>

					<span class='eae-icon-sort-icon eae-sort-icon-down'>
						<?php if ( $settings['sort_icon_type'] === 'default' ) : ?>
							<i class="fas fa-sort-down eae-icon"></i>
						<?php endif; ?> 
						<?php if ( $settings['sort_icon_type'] === 'custom' ) : ?>
							<i class="<?php echo esc_attr( $settings['sort_icon_down']['value'] ); ?> eae-icon"></i>
						<?php endif; ?> 
					</span>
				   
			</div>

			<?php
		endif;
	}

	public function render_head_icon( $head_data ) {

		if ( ! empty( $head_data['head_column_icon'] ) || ! empty( $head_data['head_column_image']['url'] ) || ! empty( $head_data['lottie_animation_url'] ) ) {

			$head_icon_type = $head_data['head_icon_type'];
			$id             = $head_data['_id'];

			if ( $head_icon_type !== 'none' ) {

				$this->set_render_attribute( 'eae-icon', 'class', [ 'eae-head-icon-' . $head_data['head_column_icon_position'], 'eae-head-icon' ] );

				?>

				<span <?php echo $this->get_render_attribute_string( 'eae-icon' ); ?>>

					<?php if ( $head_icon_type === 'icon' && ! empty( $head_data['head_column_icon']['value'] ) ) { ?>
						<i class="<?php echo esc_attr( $head_data['head_column_icon']['value'] ); ?> eae-head-icon"></i>  
						<?php
					} elseif ( $head_icon_type === 'image' ) {
						if ( ! empty( $head_data['head_column_image']['id'] ) || ! empty( $head_data['head_column_image']['url'] ) ) {
							$eae_image = wp_get_attachment_image_url( $head_data['head_column_image']['id'], $head_data['head_column_image_size'] );

							if ( ! $eae_image ) {
								$eae_image = $head_data['head_column_image']['url'];
							}
							?>

							<img class='eae-head-img' src="<?php echo esc_attr( $eae_image ); ?>"/>	
							<?php
							/* if close */
						}
					} elseif ( ! empty( $head_data['lottie_animation_url'] ) ) {

						$lottie_data = [
							'id'      => 'eae-animation-' . $id,
							'url'     => $head_data['lottie_animation_url'],
							'loop'    => ( $head_data['lottie_animation_loop'] === 'yes' ) ? true : false,
							'reverse' => ( $head_data['lottie_animation_reverse'] === 'yes' ) ? true : false,
						];

						$this->set_render_attribute(
							'head-animation',
							[
								'class'                => [ 'eae-lottie-animation', 'eae-lottie' ],
								'id'                   => [ 'eae-animation-' . $id ],
								'data-lottie-settings' => wp_json_encode( $lottie_data ),
							]
						);
						?>
						<div <?php echo $this->get_render_attribute_string( 'head-animation' ); ?>></div>
					<!-- elseif close -->
					<?php } ?>

				</span>

				<?php

			}
		}
	}

	protected function table_render_body( $settings ) {

		$this->add_render_attribute( 'table_body', 'class', [ 'eae-table__body' ] );

		?>
			<tbody <?php echo $this->get_render_attribute_string( 'table_body' ); ?>>
			<?php
			$row_count = 0;
			$table_row = [];

			foreach ( $settings['body_row_data'] as $data ) {
				$rows_id = uniqid();

				if ( $data['eae_row_column_type'] === 'row' ) {

					$table_row[] = [
						'id'   => $rows_id,
						'type' => $data['eae_row_column_type'],
					];

					$this->render_row( $row_count );
					$row_count++;
				} else {
					$this->render_column( $data, $table_row );
				}
			}
			?>
			</tbody>
			<?php
	}


	public function render_row( $row_count ) {

		$this->set_render_attribute( 'table_body_row', 'class', [ 'eae-table__body-row' ] );

		if ( $row_count ) {
			?>
			</tr><tr <?php echo $this->get_render_attribute_string( 'table_body_row' ); ?>>
		<?php } else { ?>
			<tr <?php echo $this->get_render_attribute_string( 'table_body_row' ); ?>>
			<?php
		}
	}

	public function render_column( $data, $table_row ) {

		if ( $data['eae_row_column_type'] === 'column' ) {
			$row_keys         = array_keys( $table_row );
			$column_last_keys = end( $row_keys );
			$row_id           = $table_row[ $column_last_keys ]['id'];
		}

		$body_text = $data['body_column_name'];

		$row_column_repeater_key = $this->get_repeater_setting_key( 'body_column_span', 'body_row_data', $row_id );

		$id = $data['_id'];
		$this->set_render_attribute( $row_column_repeater_key, 'class', [ 'eae-table__body_row_column', 'elementor-repeater-item-' . $id ] );

		if ( ! empty( $data['body_column_span'] ) ) {
			$this->set_render_attribute( $row_column_repeater_key, 'colspan', $data['body_column_span'] );
		}
		if ( ! empty( $data['body_row_span'] ) ) {
			$this->set_render_attribute( $row_column_repeater_key, 'rowspan', $data['body_row_span'] );
		}

		$elem = 'div';
		$this->set_render_attribute( 'table_text', 'class', 'eae-table__col-inner' );

		if ( ! empty( $data['body_column_link']['url'] ) ) {
			$elem = 'a';

			$this->set_render_attribute(
				'table_text',
				[
					'href'   => $data['body_column_link']['url'],
					'target' => $data['body_column_link']['is_external'] ? '_blank' : '',
					'rel'    => $data['body_column_link']['nofollow'] ? 'nofollow' : '',
				]
			);

		} else {
			$this->remove_render_attribute( 'table_text', 'href' );
		}

		?>

		<td <?php echo $this->get_render_attribute_string( $row_column_repeater_key ); ?>>  
			<div class="eae-table__body-column-wrapper">
			<?php
			printf(
				'<%1$s %2$s>',
				$elem,
				$this->get_render_attribute_string( 'table_text' )
			);
			?>
			<?php if ( $data['body_text_type'] !== 'template' ) : ?>   
				<?php
				if ( $data['body_column_icon_position'] === 'before' || $data['body_column_icon_position'] === 'top' ) :
					$this->render_icon( $data );
				endif;
			endif;
			?>
			<?php if ( ! empty( $body_text ) && $data['body_text_type'] !== 'template' ) : ?>
				<span class="eae-table-body__text"><?php echo esc_html( $body_text ); ?></span>
			<?php endif; ?>

			<?php
			/* Render template */ if ( $data['body_text_type'] === 'template' ) :

				if ( $data['eae_template_type'] === 'saved_section' && ! empty( $data['table_saved_sections'] ) ) :
					echo Plugin::$instance->frontend->get_builder_content( intval( $data['table_saved_sections'] ), true );
				endif;
				if ( $data['eae_template_type'] === 'saved_page' && ! empty( $data['table_saved_pages'] ) ) :
					echo Plugin::$instance->frontend->get_builder_content( intval( $data['table_saved_pages'] ), true );
				endif;
				if ( $data['eae_template_type'] === 'ae_template' && ! empty( $data['table_ae_templates'] ) ) :
					echo Plugin::$instance->frontend->get_builder_content( intval( $data['table_ae_templates'] ), true );
				endif;

			endif;
			?>

			<?php if ( $data['body_text_type'] !== 'template' ) : ?> 
				<?php
				if ( $data['body_column_icon_position'] === 'after' || $data['body_column_icon_position'] === 'bottom' ) :
					$this->render_icon( $data );
				endif;
			endif;
			?>
			<?php
				printf(
					'</%1$s>',
					$elem
				);
			?>
			</div>
		</td>

		<?php
	}

	public function render_icon( $data ) {

		//cloumn icon
		if ( ! empty( $data['body_column_icon'] ) || ! empty( $data['body_column_image']['url'] ) || ! empty( $data['lottie_animation_url'] ) ) {

			$body_icon_type = $data['body_icon_type'];
			if ( $body_icon_type !== 'none' ) {
				$this->set_render_attribute( 'eae-icons', 'class', [ 'eae-body-icon-' . $data['body_column_icon_position'], 'eae-body-icon' ] );
				?>
					<span <?php echo $this->get_render_attribute_string( 'eae-icons' ); ?>>
						<?php if ( $body_icon_type === 'icon' && ! empty( $data['body_column_icon']['value'] ) ) { ?>
							<i class="<?php echo esc_attr( $data['body_column_icon']['value'] ); ?> eae-cell-icon"></i>  
							<?php
						} elseif ( $body_icon_type === 'image' ) {
							if ( ! empty( $data['body_column_image']['id'] ) || ! empty( $data['body_column_image']['url'] ) ) {
									$image = wp_get_attachment_image_url( $data['body_column_image']['id'], $data['body_column_image_size'] );

								if ( ! $image ) {
									$image = $data['body_column_image']['url'];
								}
								?>
								<img class="eae-body-image" src="<?php echo esc_attr( $image ); ?>"/>
								<?php
							}
						} elseif ( ! empty( $data['body_lottie_animation_url'] ) ) {

							$lottie_data = [
								'id'      => 'eae-animation-' . $data['_id'],
								'url'     => $data['body_lottie_animation_url'],
								'loop'    => ( $data['body_lottie_animation_loop'] === 'yes' ) ? true : false,
								'reverse' => ( $data['body_lottie_animation_reverse'] === 'yes' ) ? true : false,
							];
							$this->set_render_attribute(
								'body-animation',
								[
									'class'                => [ 'eae-table-lottie-animation', 'eae-lottie' ],
									'id'                   => [ 'eae-animation-' . $data['_id'] ],
									'data-lottie-settings' => wp_json_encode( $lottie_data ),
								]
							);
							?>
								<div <?php echo $this->get_render_attribute_string( 'body-animation' ); ?>></div>
							<?php } //else if close ?>
					</span>
				<?php
				//inner if close
			}
			// outer if close
		}
		// cloumn icon close
	}

}
