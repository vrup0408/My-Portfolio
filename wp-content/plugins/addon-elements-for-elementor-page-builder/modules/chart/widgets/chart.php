<?php

namespace WTS_EAE\Modules\Chart\Widgets;

use Elementor\Controls_Manager;
use WTS_EAE\Base\EAE_Widget_Base;
use WTS_EAE\Modules\Chart\Skins;
use Elementor\Repeater;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;


class Chart extends EAE_Widget_Base {
	public function get_name() {
		return 'eae-chart';
	}

	public function get_title() {

		return __( 'EAE - Chart', 'wts-eae' );
	}

	public function get_icon() {
		return 'eicon-text-align-left';
	}

	public function get_categories() {
		return [ 'wts-eae' ];
	}

	public function get_script_depends() {
		return [ 'eae-chart' ];
	}


	protected function register_skins() {
		$this->add_skin( new Skins\Skin_Bar_Chart( $this ) );
		$this->add_skin( new Skins\Skin_Horizontal_Bar_Chart( $this ) );
		$this->add_skin( new Skins\Skin_Line_Chart( $this ) );
	}

	// phpcs:ignore PSR2.Classes.PropertyDeclaration.Underscore
	protected $_has_template_content = false;

	protected function register_controls() {
		$this->start_controls_section(
			'section_layout',
			[
				'label' => __( 'Layout', 'wts-eae' ),
			]
		);

		$this->add_control(
			'labels',
			[
				'label'       => __( 'Labels', 'wts-eae' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => '2017, 2018, 2019, 2020',
				'placeholder' => __( 'January, February, March', 'wts-eae' ),
				'description' => __( 'Enter multiple Labels Separated With ( , ). Example: January, February, March etc. ', 'wts-eae' ),
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'chart_data_tab' );

		$repeater->start_controls_tab(
			'content',
			[
				'label' => __( 'Content', 'wts-eae' ),
			]
		);

		$repeater->add_control(
			'dataset_label',
			[
				'label'       => __( 'Label', 'wts-eae' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Lable', 'wts-eae' ),
				'placeholder' => __( 'Enter your label', 'wts-eae' ),
			]
		);

		$repeater->add_control(
			'dataset_data',
			[
				'label'       => __( 'Data', 'wts-eae' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => '10, 50, 13, 35',
				'placeholder' => __( '10, 20, 30', 'wts-eae' ),
				'description' => __( 'Enter Data Values Separated With ( , ). Example: 10, 20, 30 ', 'wts-eae' ),
			]
		);

		$repeater->end_controls_tab();

		$repeater->start_controls_tab(
			'style',
			[
				'label' => __( 'Style', 'wts-eae' ),
			]
		);

		$repeater->add_control(
			'background_color',
			[
				'label'   => __( 'Background Color', 'wts-eae' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '#52C0C0BA',
			]
		);

		$repeater->add_control(
			'background_hover_color',
			[
				'label'   => __( 'Background Hover Color', 'wts-eae' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '#52C0C0E0',
			]
		);

		$repeater->add_control(
			'border_color',
			[
				'label'   => __( 'Border Color', 'wts-eae' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '#49C4C4',
			]
		);

		$repeater->add_control(
			'border_hover_color',
			[
				'label'   => __( 'Border Hover Color', 'wts-eae' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '#49C4C4',
			]
		);

		$repeater->add_control(
			'line_title',
			[
				'label'       => __( 'Line', 'wts-eae' ),
				'type'        => Controls_Manager::HEADING,
				'separator'   => 'before',
				'description' => __( 'Note: These options only work with line chart.', 'wts-eae' ),
			]
		);

		$repeater->add_control(
			'line_description',
			[
				'label'      => __( 'line chart note', 'wts-eae' ),
				'show_label' => false,
				'type'       => Controls_Manager::RAW_HTML,
				'raw'        => __( 'Note: These options only work with line chart.', 'wts-eae' ),
			]
		);

		$repeater->add_control(
			'line_fill_color',
			[
				'label'        => __( 'Background Color', 'wts-eae' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '',
				'label_on'     => __( 'Yes', 'wts-eae' ),
				'label_off'    => __( 'No', 'wts-eae' ),
				'return_value' => 'yes',
			]
		);

		$repeater->add_control(
			'line_bg_color',
			[
				'label'       => __( 'Color', 'wts-eae' ),
				'type'        => Controls_Manager::COLOR,
				'label_block' => false,
				'default'     => 'rgba(0, 0, 0, 0.1)',
				'condition'   => [
					'line_fill_color' => 'yes',
				],
			]
		);

		$repeater->add_control(
			'line_border_color',
			[
				'label'   => __( 'Border Color', 'wts-eae' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '#49C4C4',
			]
		);

		$repeater->add_control(
			'point_background_color',
			[
				'label'   => __( 'Point Background Color', 'wts-eae' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '#49C4C4',
			]
		);

		$repeater->add_control(
			'point_background_hover_color',
			[
				'label'   => __( 'Point Background Hover Color', 'wts-eae' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '#49C4C4',
			]
		);

		$repeater->add_control(
			'point_border_color',
			[
				'label'   => __( 'Point Border Color', 'wts-eae' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '#49C4C4',
			]
		);

		$repeater->add_control(
			'point_border_hover_color',
			[
				'label'   => __( 'Point Border Hover Color', 'wts-eae' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '#49C4C4',
			]
		);

		$repeater->end_controls_tab();

		$this->add_control(
			'dataset',
			[
				'label'       => __( 'Datasets', 'wts-eae' ),
				'type'        => Controls_Manager::REPEATER,
				'show_label'  => true,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'dataset_label'                => __( 'Company A', 'wts-eae' ),
						'dataset_data'                 => '30, 40, 27, 45',
						'background_color'             => '#EE6083B8',
						'background_hover_color'       => '#EE6083D9',
						'border_color'                 => '#F34A74',
						'border_hover_color'           => '#F34A74',
						'line_border_color'            => '#ee6083',
						'point_background_color'       => '#ee6083',
						'point_background_hover_color' => '#ee6083',
						'point_border_color'           => '#ee6083',
						'point_border_hover_color'     => '#ee6083',
					],
					[
						'dataset_label'                => __( 'Company B', 'wts-eae' ),
						'dataset_data'                 => '37, 45, 39, 50',
						'background_color'             => '#3BA3ECB8',
						'background_hover_color'       => '#3BA3ECDE',
						'border_color'                 => '#2999E8',
						'border_hover_color'           => '#2999E8',
						'line_border_color'            => '#3ba3eb',
						'point_background_color'       => '#3ba3eb',
						'point_background_hover_color' => '#3ba3eb',
						'point_border_color'           => '#3ba3eb',
						'point_border_hover_color'     => '#3ba3eb',
					],
				],
				'title_field' => '{{{ dataset_label }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_additional_settings',
			[
				'label' => __( 'Additional Settings', 'wts-eae' ),
			]
		);

		$this->add_responsive_control(
			'eae_chart_height',
			[
				'label'     => __( 'Chart Height', 'wts-eae' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 50,
				'max'       => 1500,
				'step'      => 5,
				'default'   => 500,
				'selectors' => [
					'{{WRAPPER}} .eae-chart-outer-container' => 'height: {{SIZE}}px;',
					'{{WRAPPER}} #eae-chart-canvas' => 'height: {{SIZE}}px !important;',
				],
			]
		);

		$this->add_control(
			'bar_settings_heading',
			[
				'label'     => __( 'Bar Chart', 'wts-eae' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'_skin!' => 'line',
				],
			]
		);

		$this->add_control(
			'bar_width',
			[
				'label'     => __( 'Bar Width', 'wts-eae' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 99,
					],
				],
				'default'   => [
					'unit' => 'px',
					'size' => 80,
				],
				'condition' => [
					'_skin!' => 'line',
				],
			]
		);

		$this->add_control(
			'bar_category_width',
			[
				'label'     => __( 'Bar Category Width', 'wts-eae' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 99,
					],
				],
				'default'   => [
					'unit' => 'px',
					'size' => 85,
				],
				'condition' => [
					'_skin!' => 'line',
				],
			]
		);

		$this->add_control(
			'bar_border_width',
			[
				'label'     => __( 'Bar Border Width', 'wts-eae' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 1,
				'min'       => 1,
				'max'       => 10,
				'condition' => [
					'_skin!' => 'line',
				],
			]
		);

		$this->add_control(
			'line_settings',
			[
				'label'     => __( 'Line Chart', 'wts-eae' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'_skin' => 'line',
				],
			]
		);

		$this->add_control(
			'line_stepped',
			[
				'label'        => __( 'Stepped Line', 'wts-eae' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '',
				'label_on'     => __( 'Yes', 'wts-eae' ),
				'label_off'    => __( 'No', 'wts-eae' ),
				'return_value' => 'yes',
				'condition'    => [
					'_skin' => 'line',
				],
			]
		);

		$this->add_control(
			'line_border_width',
			[
				'label'     => __( 'Line Border Width', 'wts-eae' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 2,
				'min'       => 1,
				'max'       => 20,
				'condition' => [
					'_skin' => 'line',
				],
			]
		);

		$this->add_control(
			'line_point_size',
			[
				'label'     => __( 'Line Point Size', 'wts-eae' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 3,
				'min'       => 1,
				'max'       => 20,
				'condition' => [
					'_skin' => 'line',
				],
			]
		);

		$this->add_control(
			'line_point_hover_size',
			[
				'label'     => __( 'Line Point Hover Size', 'wts-eae' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 3,
				'min'       => 1,
				'max'       => 20,
				'condition' => [
					'_skin' => 'line',
				],
			]
		);

		$this->add_control(
			'line_joint_style',
			[
				'label'     => __( 'Line Joint Style', 'wts-eae' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'miter',
				'options'   => [
					'miter' => __( 'Miter', 'wts-eae' ),
					'round' => __( 'Round', 'wts-eae' ),
					'bevel' => __( 'Bevel', 'wts-eae' ),
				],
				'condition' => [
					'_skin'        => 'line',
					'line_stepped' => 'yes',
				],
			]
		);

		$this->add_control(
			'line_point_style',
			[
				'label'     => __( 'Line Point Style', 'wts-eae' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'circle',
				'options'   => [
					'circle'      => __( 'Circle', 'wts-eae' ),
					'cross'       => __( 'Cross', 'wts-eae' ),
					'crossRot'    => __( 'CrossRot', 'wts-eae' ),
					'rect'        => __( 'Rect', 'wts-eae' ),
					'rectRounded' => __( 'RectRounded', 'wts-eae' ),
					'rectRot'     => __( 'RectRot', 'wts-eae' ),
					'star'        => __( 'Star', 'wts-eae' ),
					'triangle'    => __( 'Triangle', 'wts-eae' ),
				],
				'condition' => [
					'_skin' => 'line',
				],
			]
		);

		$this->add_control(
			'xaxes_display',
			[
				'label'     => __( 'X-Axis', 'wts-eae' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'xaxes_grid_line',
			[
				'label'        => __( 'Enable Grid Lines', 'wts-eae' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'label_on'     => __( 'Yes', 'wts-eae' ),
				'label_off'    => __( 'No', 'wts-eae' ),
				'return_value' => 'yes',
				'description'  => __( ' Enable or Disable X-Axis Grid Lines ', 'wts-eae' ),
			]
		);

		$this->add_control(
			'xaxes_display_title',
			[
				'label'        => __( 'Enable Title', 'wts-eae' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '',
				'label_on'     => __( 'Yes', 'wts-eae' ),
				'label_off'    => __( 'No', 'wts-eae' ),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'xaxes_title',
			[
				'label'       => __( 'Title', 'wts-eae' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'X-Axis Title',
				'placeholder' => __( 'Enter Title', 'wts-eae' ),
				'condition'   => [
					'xaxes_display_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'xaxes_labels_display',
			[
				'label'        => __( 'Enable Labels', 'wts-eae' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'label_on'     => __( 'Yes', 'wts-eae' ),
				'label_off'    => __( 'No', 'wts-eae' ),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'yaxes_display',
			[
				'label'     => __( 'Y-Axis', 'wts-eae' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'yaxes_grid_line',
			[
				'label'        => __( 'Enable Grid Lines', 'wts-eae' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'label_on'     => __( 'Yes', 'wts-eae' ),
				'label_off'    => __( 'No', 'wts-eae' ),
				'return_value' => 'yes',
				'description'  => __( ' Enable or Disable Y-Axis Grid Lines ', 'wts-eae' ),
			]
		);

		$this->add_control(
			'yaxes_display_title',
			[
				'label'        => __( 'Enable Title', 'wts-eae' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '',
				'label_on'     => __( 'Yes', 'wts-eae' ),
				'label_off'    => __( 'No', 'wts-eae' ),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'yaxes_title',
			[
				'label'       => __( 'Title', 'wts-eae' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Y-Axis Title',
				'placeholder' => __( 'Enter Title', 'wts-eae' ),
				'condition'   => [
					'yaxes_display_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'yaxes_labels_display',
			[
				'label'        => __( 'Enable Labels', 'wts-eae' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'label_on'     => __( 'Yes', 'wts-eae' ),
				'label_off'    => __( 'No', 'wts-eae' ),
				'return_value' => 'yes',
				'separator'    => 'after',
			]
		);

		$this->add_control(
			'step_size',
			[
				'label'   => __( 'Step Size', 'wts-eae' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 10,
				'min'     => 0,
				'step'    => 1,
			]
		);

		$this->add_control(
			'axis_range',
			[
				'label'       => __( 'Scale Axis Range', 'wts-eae' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 100,
				'description' => __( 'Maximum number for the scale.', 'wts-eae' ),
			]
		);

		$this->add_control(
			'heading',
			[
				'label'     => __( 'Title', 'wts-eae' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'title_display',
			[
				'label'        => __( 'Enable Title', 'wts-eae' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '',
				'label_on'     => __( 'Yes', 'wts-eae' ),
				'label_off'    => __( 'No', 'wts-eae' ),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => __( 'Title', 'wts-eae' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Add Your Heading',
				'placeholder' => __( 'Enter Title', 'wts-eae' ),
				'condition'   => [
					'title_display' => 'yes',
				],
			]
		);

		$this->add_control(
			'title_position',
			[
				'type'      => Controls_Manager::SELECT,
				'label'     => __( 'Position', 'wts-eae' ),
				'default'   => 'top',
				'options'   => [
					'top'    => __( 'Top', 'wts-eae' ),
					'bottom' => __( 'Bottom', 'wts-eae' ),
				],
				'condition' => [
					'title_display' => 'yes',
				],

			]
		);

		$this->add_control(
			'legend',
			[
				'label'     => __( 'Legend', 'wts-eae' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'legend_display',
			[
				'label'        => __( 'Enable Legend', 'wts-eae' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'label_on'     => 'Yes',
				'label_off'    => 'No',
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'legend_position',
			[
				'label'     => __( 'Position', 'wts-eae' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'top'    => __( 'Top', 'wts-eae' ),
					'left'   => __( 'Left', 'wts-eae' ),
					'bottom' => __( 'Bottom', 'wts-eae' ),
					'right'  => __( 'Right', 'wts-eae' ),
				],
				'default'   => 'top',
				'condition' => [
					'legend_display' => 'yes',
				],
			]
		);

		$this->add_control(
			'legend_align',
			[
				'label'     => __( 'Alignment', 'wts-eae' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'start' => [
						'title' => __( 'Left', 'wts-eae' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'wts-eae' ),
						'icon'  => 'fa fa-align-center',
					],
					'end' => [
						'title' => __( 'Right', 'wts-eae' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'default'   => 'center',
				'condition' => [
					'legend_display' => 'yes',
				],
			]
		);

		$this->add_control(
			'legend_reverse',
			[
				'label'        => __( 'Reverse', 'wts-eae' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'label_on'     => 'Yes',
				'label_off'    => 'No',
				'return_value' => 'yes',
				'condition'    => [
					'legend_display' => 'yes',
				],
			]
		);

		$this->add_control(
			'tooltip',
			[
				'label'     => __( 'Tooltip', 'wts-eae' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'tooltip_display',
			[
				'label'        => __( 'Enable Tooltips', 'wts-eae' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'label_on'     => 'Yes',
				'label_off'    => 'No',
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'tooltip_mode',
			[
				'label'     => __( 'Mode', 'wts-eae' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'index' => __( 'Index', 'wts-eae' ),
					'point' => __( 'Point', 'wts-eae' ),
				],
				'default'   => 'point',
				'condition' => [
					'tooltip_display' => 'yes',
				],
			]
		);

		$this->add_control(
			'animation_title',
			[
				'label'     => __( 'Animation', 'wts-eae' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'chart_animation',
			[
				'label'   => __( 'Animation', 'wts-eae' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'linear'           => __( 'Linear', 'wts-eae' ),
					'easeInQuad'       => __( 'Ease in Quad', 'wts-eae' ),
					'easeOutQuad'      => __( 'Ease out Quad', 'wts-eae' ),
					'easeInOutQuad'    => __( 'Ease in out Quad', 'wts-eae' ),
					'easeInCubic'      => __( 'Ease in Cubic', 'wts-eae' ),
					'easeOutCubic'     => __( 'Ease out Cubic', 'wts-eae' ),
					'easeInOutCubic'   => __( 'Ease in out Cubic', 'wts-eae' ),
					'easeInQuart'      => __( 'Ease in Quart', 'wts-eae' ),
					'easeOutQuart'     => __( 'Ease out Quart', 'wts-eae' ),
					'easeInOutQuart'   => __( 'Ease in out Quart', 'wts-eae' ),
					'easeInQuint'      => __( 'Ease in Quint', 'wts-eae' ),
					'easeOutQuint'     => __( 'Ease out Quint', 'wts-eae' ),
					'easeInOutQuint'   => __( 'Ease in out Quint', 'wts-eae' ),
					'easeInSine'       => __( 'Ease in Sine', 'wts-eae' ),
					'easeOutSine'      => __( 'Ease out Sine', 'wts-eae' ),
					'easeInOutSine'    => __( 'Ease in out Sine', 'wts-eae' ),
					'easeInExpo'       => __( 'Ease in Expo', 'wts-eae' ),
					'easeOutExpo'      => __( 'Ease out Expo', 'wts-eae' ),
					'easeInOutExpo'    => __( 'Ease in out Cubic', 'wts-eae' ),
					'easeInCirc'       => __( 'Ease in Circle', 'wts-eae' ),
					'easeOutCirc'      => __( 'Ease out Circle', 'wts-eae' ),
					'easeInOutCirc'    => __( 'Ease in out Circle', 'wts-eae' ),
					'easeInElastic'    => __( 'Ease in Elastic', 'wts-eae' ),
					'easeOutElastic'   => __( 'Ease out Elastic', 'wts-eae' ),
					'easeInOutElastic' => __( 'Ease in out Elastic', 'wts-eae' ),
					'easeInBack'       => __( 'Ease in Back', 'wts-eae' ),
					'easeOutBack'      => __( 'Ease out Back', 'wts-eae' ),
					'easeInOutBack'    => __( 'Ease in Out Back', 'wts-eae' ),
					'easeInBounce'     => __( 'Ease in Bounce', 'wts-eae' ),
					'easeOutBounce'    => __( 'Ease out Bounce', 'wts-eae' ),
					'easeInOutBounce'  => __( 'Ease in out Bounce', 'wts-eae' ),
				],
				'default' => 'linear',
			]
		);

		$this->add_control(
			'duration_animation',
			[
				'label'   => __( 'Animation Duration', 'wts-eae' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 0,
				'max'     => 10000,
				'step'    => 100,
				'default' => 1000,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => __( 'General', 'wts-eae' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'eae_chart_background_color',
				'label'    => __( 'Background Color', 'wts-eae' ),
				'types'    => [ 'none', 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .eae-chart-outer-container',
			]
		);

		$this->add_control(
			'chart_overlay',
			[
				'label'        => __( 'Overlay', 'wts-eae' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '',
				'label_on'     => 'Yes',
				'label_off'    => 'No',
				'return_value' => 'yes',
				'condition'    => [
					'eae_chart_background_color_background' => 'classic',
				],
			]
		);

		$this->add_control(
			'chart_overlay_color',
			[
				'label'      => __( 'Overlay Color', 'wts-eae' ),
				'type'       => Controls_Manager::COLOR,
				'default'    => 'rgba(0,0,0,0.5)',
				'conditions' => [
					'terms' => [
						[
							'name'  => 'chart_overlay',
							'value' => 'yes',
						],
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .eae-chart-overlay' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'chart_overlay_blend_mode',
			[
				'label'      => __( 'Blend Mode', 'wts-eae' ),
				'type'       => Controls_Manager::SELECT,
				'options'    => [
					''            => __( 'Normal', 'wts-eae' ),
					'multiply'    => 'Multiply',
					'screen'      => 'Screen',
					'overlay'     => 'Overlay',
					'darken'      => 'Darken',
					'lighten'     => 'Lighten',
					'color-dodge' => 'Color Dodge',
					'color-burn'  => 'Color Burn',
					'hue'         => 'Hue',
					'saturation'  => 'Saturation',
					'color'       => 'Color',
					'exclusion'   => 'Exclusion',
					'luminosity'  => 'Luminosity',
				],
				'conditions' => [
					'terms' => [
						[
							'name'  => 'chart_overlay',
							'value' => 'yes',
						],
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .eae-chart-overlay' => 'mix-blend-mode: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'eae_chart_border',
				'label'     => __( 'Border', 'wts-eae' ),
				'selector'  => '{{WRAPPER}} .eae-chart-outer-container',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'eae_chart_border_radius',
			[
				'label'      => __( 'Border Radius', 'wts-eae' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}}  .eae-chart-outer-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'eae_chart_margin',
			[
				'label'      => __( 'Margin', 'wts-eae' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .eae-chart-outer-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'eae_chart_padding',
			[
				'label'      => __( 'Padding', 'wts-eae' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'xaxes_style',
			[
				'label'      => __( 'X-Axis', 'wts-eae' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'xaxes_grid_line',
							'operator' => '==',
							'value'    => 'yes',
						],
						[
							'name'     => 'xaxes_display_title',
							'operator' => '==',
							'value'    => 'yes',
						],
						[
							'name'     => 'xaxes_labels_display',
							'operator' => '==',
							'value'    => 'yes',
						],
					],
				],
			]
		);

		$this->add_control(
			'xaxes_grid_heading',
			[
				'label'     => __( 'Grid', 'wts-eae' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'xaxes_grid_line' => 'yes',
				],
			]
		);

		$this->add_control(
			'xaxes_grid_color',
			[
				'label'     => __( 'Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'xaxes_grid_line' => 'yes',
				],
			]
		);

		$this->add_control(
			'xaxes_grid_width',
			[
				'label'     => __( 'Width', 'wts-eae' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 10,
					],
				],
				'default'   => [
					'unit' => 'px',
					'size' => 1,
				],
				'condition' => [
					'xaxes_grid_line' => 'yes',
				],
				'separator' => 'after',
			]
		);

		$this->add_control(
			'xaxes_title_heading',
			[
				'label'     => __( 'Title', 'wts-eae' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'xaxes_display_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'xaxes_title_color',
			[
				'label'     => __( 'Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'xaxes_display_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'xaxes_title_style',
			[
				'label'        => __( 'Typography', 'wts-eae' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'return_value' => 'yes',
				'condition'    => [
					'xaxes_display_title' => 'yes',
				],
				'separator'    => 'after',
			]
		);

		$this->start_popover();

		$this->add_control(
			'xaxes_title_typo',
			[
				'label'     => __( 'Typography', 'wts-eae' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'after',
				'condition' => [
					'xaxes_display_title' => 'yes',
					'xaxes_title_style'   => 'yes',
				],
			]
		);

		$this->add_control(
			'xaxes_title_font_family',
			[
				'label'     => __( 'Family', 'wts-eae' ),
				'type'      => Controls_Manager::FONT,
				'default'   => '',
				'condition' => [
					'xaxes_display_title' => 'yes',
					'xaxes_title_style'   => 'yes',
				],
			]
		);

		$this->add_control(
			'xaxes_title_font_size',
			[
				'label'     => __( 'Size', 'wts-eae' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 1,
						'max' => 200,
					],
				],
				'default'   => [
					'unit' => 'px',
					'size' => 15,
				],
				'condition' => [
					'xaxes_display_title' => 'yes',
					'xaxes_title_style'   => 'yes',
				],

			]
		);

		$this->add_control(
			'xaxes_title_font_weight',
			[
				'label'     => __( 'Weight', 'wts-eae' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'100'    => __( '100', 'wts-eae' ),
					'200'    => __( '200', 'wts-eae' ),
					'300'    => __( '300', 'wts-eae' ),
					'400'    => __( '400', 'wts-eae' ),
					'500'    => __( '500', 'wts-eae' ),
					'600'    => __( '600', 'wts-eae' ),
					'700'    => __( '700', 'wts-eae' ),
					'800'    => __( '800', 'wts-eae' ),
					'900'    => __( '900', 'wts-eae' ),
					''       => __( 'Default', 'wts-eae' ),
					'normal' => __( 'Normal', 'wts-eae' ),
					'bold'   => __( 'Bold', 'wts-eae' ),
				],
				'condition' => [
					'xaxes_display_title' => 'yes',
					'xaxes_title_style'   => 'yes',
				],
			]
		);

		$this->add_control(
			'xaxes_title_font_style',
			[
				'label'     => __( 'Style', 'wts-eae' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => [
					''        => __( 'Default', 'wts-eae' ),
					'normal'  => __( 'Normal', 'wts-eae' ),
					'italic'  => __( 'Italic', 'wts-eae' ),
					'oblique' => __( 'Oblique', 'wts-eae' ),
				],
				'condition' => [
					'xaxes_display_title' => 'yes',
					'xaxes_title_style'   => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'xaxes_title_line_height',
			[
				'label'     => __( 'Line-Height', 'wts-eae' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 1,
				'default'   => '',
				'condition' => [
					'xaxes_display_title' => 'yes',
					'xaxes_title_style'   => 'yes',
				],
			]
		);

		$this->end_popover();

		$this->add_control(
			'xaxes_label_heading',
			[
				'label'     => __( 'Labels', 'wts-eae' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'xaxes_labels_display' => 'yes',
				],
			]
		);

		$this->add_control(
			'xaxes_label_color',
			[
				'label'     => __( 'Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'xaxes_labels_display' => 'yes',
				],
			]
		);

		$this->add_control(
			'xaxes_lable_style',
			[
				'label'        => __( 'Typography', 'wts-eae' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'return_value' => 'yes',
				'condition'    => [
					'xaxes_labels_display' => 'yes',
				],
			]
		);

		$this->start_popover();

		$this->add_control(
			'xaxes_lable_typo',
			[
				'label'     => __( 'Typography', 'wts-eae' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'xaxes_labels_display' => 'yes',
					'xaxes_lable_style'    => 'yes',
				],
			]
		);

		$this->add_control(
			'xaxes_lable_font_family',
			[
				'label'     => __( 'Family', 'wts-eae' ),
				'type'      => Controls_Manager::FONT,
				'default'   => '',
				'condition' => [
					'xaxes_labels_display' => 'yes',
					'xaxes_lable_style'    => 'yes',
				],
			]
		);

		$this->add_control(
			'xaxes_lable_font_size',
			[
				'label'     => __( 'Size', 'wts-eae' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 1,
						'max' => 200,
					],
				],
				'default'   => [
					'unit' => 'px',
					'size' => 15,
				],
				'condition' => [
					'xaxes_labels_display' => 'yes',
					'xaxes_lable_style'    => 'yes',
				],
			]
		);

		$this->add_control(
			'xaxes_lable_font_weight',
			[
				'label'   => __( 'Weight', 'wts-eae' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'100'       => __( '100', 'wts-eae' ),
					'200'       => __( '200', 'wts-eae' ),
					'300'       => __( '300', 'wts-eae' ),
					'400'       => __( '400', 'wts-eae' ),
					'500'       => __( '500', 'wts-eae' ),
					'600'       => __( '600', 'wts-eae' ),
					'700'       => __( '700', 'wts-eae' ),
					'800'       => __( '800', 'wts-eae' ),
					'900'       => __( '900', 'wts-eae' ),
					''          => __( 'Default', 'wts-eae' ),
					'normal'    => __( 'Normal', 'wts-eae' ),
					'bold'      => __( 'Bold', 'wts-eae' ),
					'condition' => [
						'xaxes_labels_display' => 'yes',
						'xaxes_lable_style'    => 'yes',
					],
				],
			]
		);

		$this->add_control(
			'xaxes_lable_font_style',
			[
				'label'     => __( 'Style', 'wts-eae' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => [
					''        => __( 'Default', 'wts-eae' ),
					'normal'  => __( 'Normal', 'wts-eae' ),
					'italic'  => __( 'Italic', 'wts-eae' ),
					'oblique' => __( 'Oblique', 'wts-eae' ),
				],
				'condition' => [
					'xaxes_labels_display' => 'yes',
					'xaxes_lable_style'    => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'xaxes_lable_line_height',
			[
				'label'     => __( 'Line-Height', 'wts-eae' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 1,
				'default'   => '',
				'condition' => [
					'xaxes_labels_display' => 'yes',
					'xaxes_lable_style'    => 'yes',
				],
			]
		);

		$this->end_popover();

		$this->add_control(
			'xaxes_labels_padding',
			[
				'label'     => __( 'Padding', 'wts-eae' ),
				'type'      => Controls_Manager::SLIDER,
				'condition' => [
					'xaxes_labels_display' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'yaxes_style',
			[
				'label'      => __( 'Y-Axis', 'wts-eae' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[
							'name'     => 'yaxes_grid_line',
							'operator' => '==',
							'value'    => 'yes',
						],
						[
							'name'     => 'yaxes_display_title',
							'operator' => '==',
							'value'    => 'yes',
						],
					],
				],
			]
		);

		$this->add_control(
			'yaxes_grid_heading',
			[
				'label'     => __( 'Grid', 'wts-eae' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'yaxes_grid_line' => 'yes',
				],
			]
		);

		$this->add_control(
			'yaxes_grid_color',
			[
				'label'     => __( 'Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'yaxes_grid_line' => 'yes',
				],
			]
		);
		$this->add_control(
			'yaxes_grid_width',
			[
				'label'     => __( 'Width', 'wts-eae' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 10,
					],
				],
				'default'   => [
					'unit' => 'px',
					'size' => 1,
				],
				'condition' => [
					'yaxes_grid_line' => 'yes',
				],
				'separator' => 'after',
			]
		);

		$this->add_control(
			'yaxes_title_heading',
			[
				'label'     => __( 'Title', 'wts-eae' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'yaxes_display_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'yaxes_title_color',
			[
				'label'     => __( 'Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'yaxes_display_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'yaxes_title_style',
			[
				'label'        => __( 'Typography', 'wts-eae' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'return_value' => 'yes',
				'condition'    => [
					'yaxes_display_title' => 'yes',
				],
				'separator'    => 'after',
			]
		);

		$this->start_popover();

		$this->add_control(
			'yaxes_title_typo',
			[
				'label'     => __( 'Typography', 'wts-eae' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'after',
			]
		);

		$this->add_control(
			'yaxes_title_font_family',
			[
				'label'     => __( 'Family', 'wts-eae' ),
				'type'      => Controls_Manager::FONT,
				'default'   => '',
				'condition' => [
					'yaxes_display_title' => 'yes',
					'yaxes_title_style'   => 'yes',
				],
			]
		);

		$this->add_control(
			'yaxes_title_font_size',
			[
				'label'     => __( 'Size', 'wts-eae' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 1,
						'max' => 200,
					],
				],
				'default'   => [
					'unit' => 'px',
					'size' => 15,
				],
				'condition' => [
					'yaxes_display_title' => 'yes',
					'yaxes_title_style'   => 'yes',
				],

			]
		);

		$this->add_control(
			'yaxes_title_font_weight',
			[
				'label'     => __( 'Weight', 'wts-eae' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'100'    => __( '100', 'wts-eae' ),
					'200'    => __( '200', 'wts-eae' ),
					'300'    => __( '300', 'wts-eae' ),
					'400'    => __( '400', 'wts-eae' ),
					'500'    => __( '500', 'wts-eae' ),
					'600'    => __( '600', 'wts-eae' ),
					'700'    => __( '700', 'wts-eae' ),
					'800'    => __( '800', 'wts-eae' ),
					'900'    => __( '900', 'wts-eae' ),
					''       => __( 'Default', 'wts-eae' ),
					'normal' => __( 'Normal', 'wts-eae' ),
					'bold'   => __( 'Bold', 'wts-eae' ),
				],
				'condition' => [
					'yaxes_display_title' => 'yes',
					'yaxes_title_style'   => 'yes',
				],
			]
		);

		$this->add_control(
			'yaxes_title_font_style',
			[
				'label'     => __( 'Style', 'wts-eae' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => [
					''        => __( 'Default', 'wts-eae' ),
					'normal'  => __( 'Normal', 'wts-eae' ),
					'italic'  => __( 'Italic', 'wts-eae' ),
					'oblique' => __( 'Oblique', 'wts-eae' ),
				],
				'condition' => [
					'yaxes_display_title' => 'yes',
					'yaxes_title_style'   => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'yaxes_title_line_height',
			[
				'label'     => __( 'Line-Height', 'wts-eae' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 1,
				'default'   => '',
				'condition' => [
					'yaxes_display_title' => 'yes',
					'yaxes_title_style'   => 'yes',
				],
			]
		);

		$this->end_popover();

		$this->add_control(
			'yaxes_labels_heading',
			[
				'label'     => __( 'Labels', 'wts-eae' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'yaxes_labels_display' => 'yes',
				],
			]
		);

		$this->add_control(
			'yaxes_label_color',
			[
				'label'     => __( 'Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'yaxes_labels_display' => 'yes',
				],
			]
		);

		$this->add_control(
			'yaxes_lable_style',
			[
				'label'        => __( 'Typography', 'wts-eae' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'return_value' => 'yes',
				'condition'    => [
					'yaxes_labels_display' => 'yes',
				],
				'separator'    => 'after',
			]
		);

		$this->start_popover();

		$this->add_control(
			'yaxes_lable_typo',
			[
				'label'     => __( 'Typography', 'wts-eae' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'after',
				'condition' => [
					'yaxes_labels_display' => 'yes',
					'yaxes_lable_style'    => 'yes',
				],
			]
		);

		$this->add_control(
			'yaxes_lable_font_family',
			[
				'label'     => __( 'Family', 'wts-eae' ),
				'type'      => Controls_Manager::FONT,
				'default'   => '',
				'condition' => [
					'yaxes_labels_display' => 'yes',
					'yaxes_lable_style'    => 'yes',
				],
			]
		);

		$this->add_control(
			'yaxes_lable_font_size',
			[
				'label'     => __( 'Size', 'wts-eae' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 1,
						'max' => 200,
					],
				],
				'default'   => [
					'unit' => 'px',
					'size' => 15,
				],
				'condition' => [
					'yaxes_labels_display' => 'yes',
					'yaxes_lable_style'    => 'yes',
				],

			]
		);

		$this->add_control(
			'yaxes_lable_font_weight',
			[
				'label'     => __( 'Weight', 'wts-eae' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'100'    => __( '100', 'wts-eae' ),
					'200'    => __( '200', 'wts-eae' ),
					'300'    => __( '300', 'wts-eae' ),
					'400'    => __( '400', 'wts-eae' ),
					'500'    => __( '500', 'wts-eae' ),
					'600'    => __( '600', 'wts-eae' ),
					'700'    => __( '700', 'wts-eae' ),
					'800'    => __( '800', 'wts-eae' ),
					'900'    => __( '900', 'wts-eae' ),
					''       => __( 'Default', 'wts-eae' ),
					'normal' => __( 'Normal', 'wts-eae' ),
					'bold'   => __( 'Bold', 'wts-eae' ),
				],
				'condition' => [
					'yaxes_labels_display' => 'yes',
					'yaxes_lable_style'    => 'yes',
				],
			]
		);

		$this->add_control(
			'yaxes_lable_font_style',
			[
				'label'     => __( 'Style', 'wts-eae' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => [
					''        => __( 'Default', 'wts-eae' ),
					'normal'  => __( 'Normal', 'wts-eae' ),
					'italic'  => __( 'Italic', 'wts-eae' ),
					'oblique' => __( 'Oblique', 'wts-eae' ),
				],
				'condition' => [
					'yaxes_labels_display' => 'yes',
					'yaxes_lable_style'    => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'yaxes_lable_line_height',
			[
				'label'     => __( 'Line-Height', 'wts-eae' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 1,
				'default'   => '',
				'condition' => [
					'yaxes_labels_display' => 'yes',
					'yaxes_lable_style'    => 'yes',
				],
			]
		);

		$this->end_popover();

		$this->add_control(
			'yaxes_labels_padding',
			[
				'label'     => __( 'Padding', 'wts-eae' ),
				'type'      => Controls_Manager::SLIDER,
				'condition' => [
					'yaxes_labels_display' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'heading_style',
			[
				'label'     => __( 'Title', 'wts-eae' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'title_display' => 'yes',
				],
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label'     => __( 'Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'title_display' => 'yes',
				],
			]
		);

		$this->add_control(
			'heading_typography',
			[
				'label'        => __( 'Typography', 'wts-eae' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'return_value' => 'yes',
				'condition'    => [
					'title_display' => 'yes',
				],
			]
		);

		$this->start_popover();

		$this->add_control(
			'heading_typo',
			[
				'label'     => __( 'Typography', 'wts-eae' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'after',
				'condition' => [
					'title_display'      => 'yes',
					'heading_typography' => 'yes',
				],
			]
		);

		$this->add_control(
			'heading_font_family',
			[
				'label'     => __( 'Family', 'wts-eae' ),
				'type'      => Controls_Manager::FONT,
				'default'   => '',
				'condition' => [
					'title_display'      => 'yes',
					'heading_typography' => 'yes',
				],
			]
		);

		$this->add_control(
			'heading_font_size',
			[
				'label'     => __( 'Size', 'wts-eae' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 1,
						'max' => 200,
					],
				],
				'default'   => [
					'unit' => 'px',
					'size' => 15,
				],
				'condition' => [
					'title_display'      => 'yes',
					'heading_typography' => 'yes',
				],
			]
		);

		$this->add_control(
			'heading_font_weight',
			[
				'label'     => __( 'Weight', 'wts-eae' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'100'    => __( '100', 'wts-eae' ),
					'200'    => __( '200', 'wts-eae' ),
					'300'    => __( '300', 'wts-eae' ),
					'400'    => __( '400', 'wts-eae' ),
					'500'    => __( '500', 'wts-eae' ),
					'600'    => __( '600', 'wts-eae' ),
					'700'    => __( '700', 'wts-eae' ),
					'800'    => __( '800', 'wts-eae' ),
					'900'    => __( '900', 'wts-eae' ),
					''       => __( 'Default', 'wts-eae' ),
					'normal' => __( 'Normal', 'wts-eae' ),
					'bold'   => __( 'Bold', 'wts-eae' ),
				],
				'condition' => [
					'title_display'      => 'yes',
					'heading_typography' => 'yes',
				],
			]
		);

		$this->add_control(
			'heading_font_style',
			[
				'label'     => __( 'Style', 'wts-eae' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => [
					''        => __( 'Default', 'wts-eae' ),
					'normal'  => __( 'Normal', 'wts-eae' ),
					'italic'  => __( 'Italic', 'wts-eae' ),
					'oblique' => __( 'Oblique', 'wts-eae' ),
				],
				'condition' => [
					'title_display'      => 'yes',
					'heading_typography' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'heading_line_height',
			[
				'label'     => __( 'Line-Height', 'wts-eae' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 1,
				'default'   => '',
				'condition' => [
					'title_display'      => 'yes',
					'heading_typography' => 'yes',
				],
			]
		);

		$this->end_popover();

		$this->add_control(
			'chart_heading_padding',
			[
				'label'     => __( 'Padding', 'wts-eae' ),
				'type'      => Controls_Manager::SLIDER,
				'condition' => [
					'title_display' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'legend_style',
			[
				'label'     => __( 'Legend', 'wts-eae' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'legend_display' => 'yes',
				],
			]
		);

		$this->add_control(
			'legend_color',
			[
				'label'     => __( 'Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'legend_display' => 'yes',
				],
			]
		);

		$this->add_control(
			'legend_typography',
			[
				'label'        => __( 'Typography', 'wts-eae' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'return_value' => 'yes',
				'condition'    => [
					'legend_display' => 'yes',
				],
			]
		);

		$this->start_popover();

		$this->add_control(
			'legend_typography_heading',
			[
				'label'     => __( 'Typography', 'wts-eae' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'after',
				'condition' => [
					'legend_display'    => 'yes',
					'legend_typography' => 'yes',
				],
			]
		);

		$this->add_control(
			'legend_font_family',
			[
				'label'     => __( 'Family', 'wts-eae' ),
				'type'      => Controls_Manager::FONT,
				'default'   => '',
				'condition' => [
					'legend_display'    => 'yes',
					'legend_typography' => 'yes',
				],
			]
		);

		$this->add_control(
			'legend_font_size',
			[
				'label'     => __( 'Size', 'wts-eae' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 1,
						'max' => 200,
					],
				],
				'default'   => [
					'unit' => 'px',
					'size' => 12,
				],
				'condition' => [
					'legend_display'    => 'yes',
					'legend_typography' => 'yes',
				],

			]
		);

		$this->add_control(
			'legend_font_weight',
			[
				'label'     => __( 'Weight', 'wts-eae' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'100'    => __( '100', 'wts-eae' ),
					'200'    => __( '200', 'wts-eae' ),
					'300'    => __( '300', 'wts-eae' ),
					'400'    => __( '400', 'wts-eae' ),
					'500'    => __( '500', 'wts-eae' ),
					'600'    => __( '600', 'wts-eae' ),
					'700'    => __( '700', 'wts-eae' ),
					'800'    => __( '800', 'wts-eae' ),
					'900'    => __( '900', 'wts-eae' ),
					''       => __( 'Default', 'wts-eae' ),
					'normal' => __( 'Normal', 'wts-eae' ),
					'bold'   => __( 'Bold', 'wts-eae' ),
				],
				'condition' => [
					'legend_display'    => 'yes',
					'legend_typography' => 'yes',
				],
			]
		);

		$this->add_control(
			'legend_font_style',
			[
				'label'     => __( 'Style', 'wts-eae' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => [
					''        => __( 'Default', 'wts-eae' ),
					'normal'  => __( 'Normal', 'wts-eae' ),
					'italic'  => __( 'Italic', 'wts-eae' ),
					'oblique' => __( 'Oblique', 'wts-eae' ),
				],
				'condition' => [
					'legend_display'    => 'yes',
					'legend_typography' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'legend_line_height',
			[
				'label'     => __( 'Line-Height', 'wts-eae' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 1,
				'default'   => '',
				'condition' => [
					'legend_display'    => 'yes',
					'legend_typography' => 'yes',
				],
			]
		);

		$this->end_popover();

		$this->add_control(
			'legend_box_width',
			[
				'label'     => __( 'Box Width', 'wts-eae' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 5,
						'max' => 100,
					],
				],
				'condition' => [
					'legend_display' => 'yes',
				],
			]
		);

		$this->add_control(
			'legend_padding',
			[
				'label'     => __( 'Padding', 'wts-eae' ),
				'type'      => Controls_Manager::SLIDER,
				'condition' => [
					'legend_display' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'tooltip_style',
			[
				'label'     => __( 'Tooltip', 'wts-eae' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'tooltip_display' => 'yes',
				],
			]
		);

		$this->add_control(
			'tooltip_background_color',
			[
				'label'     => __( 'Background Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'tooltip_display' => 'yes',
				],
			]
		);

		$this->add_control(
			'tooltip_border_color',
			[
				'label'     => __( 'Border Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'tooltip_display' => 'yes',
				],
			]
		);

		$this->add_control(
			'tooltip_border_width',
			[
				'label'     => __( 'Border Width', 'wts-eae' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 20,
					],
				],
				'condition' => [
					'tooltip_display' => 'yes',
				],
			]
		);

		$this->add_control(
			'tooltip_border_radius',
			[
				'label'     => __( 'Border Radius', 'wts-eae' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 6,
				'condition' => [
					'tooltip_display' => 'yes',
				],
			]
		);

		$this->add_control(
			'tooltip_padding',
			[
				'label'     => __( 'Padding', 'wts-eae' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 6,
				'condition' => [
					'tooltip_display' => 'yes',
				],
			]
		);

		$this->add_control(
			'tooltip_arrow_size',
			[
				'label'     => __( 'Arrow Size', 'wts-eae' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 6,
				'condition' => [
					'tooltip_display' => 'yes',
				],
			]
		);

		$this->add_control(
			'tooltip_heading',
			[
				'label'     => __( 'Title', 'wts-eae' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'tooltip_display' => 'yes',
				],
			]
		);

		$this->add_control(
			'tooltip_title_color',
			[
				'label'     => __( 'Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'tooltip_display' => 'yes',
				],
			]
		);

		$this->add_control(
			'tooltip_typography',
			[
				'label'        => __( 'Typography', 'wts-eae' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'return_value' => 'yes',
				'condition'    => [
					'tooltip_display' => 'yes',
				],
			]
		);

		$this->start_popover();

		$this->add_control(
			'tooltip_typography_heading',
			[
				'label'     => __( 'Typography', 'wts-eae' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'after',
				'condition' => [
					'tooltip_display'    => 'yes',
					'tooltip_typography' => 'yes',
				],
			]
		);

		$this->add_control(
			'tooltip_title_font_family',
			[
				'label'     => __( 'Family', 'wts-eae' ),
				'type'      => Controls_Manager::FONT,
				'default'   => '',
				'condition' => [
					'tooltip_display'    => 'yes',
					'tooltip_typography' => 'yes',
				],
			]
		);

		$this->add_control(
			'tooltip_title_font_size',
			[
				'label'     => __( 'Size', 'wts-eae' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 1,
						'max' => 200,
					],
				],
				'default'   => [
					'unit' => 'px',
					'size' => 12,
				],
				'condition' => [
					'tooltip_display'    => 'yes',
					'tooltip_typography' => 'yes',
				],
			]
		);

		$this->add_control(
			'tooltip_title_font_weight',
			[
				'label'     => __( 'Weight', 'wts-eae' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'100'    => __( '100', 'wts-eae' ),
					'200'    => __( '200', 'wts-eae' ),
					'300'    => __( '300', 'wts-eae' ),
					'400'    => __( '400', 'wts-eae' ),
					'500'    => __( '500', 'wts-eae' ),
					'600'    => __( '600', 'wts-eae' ),
					'700'    => __( '700', 'wts-eae' ),
					'800'    => __( '800', 'wts-eae' ),
					'900'    => __( '900', 'wts-eae' ),
					''       => __( 'Default', 'wts-eae' ),
					'normal' => __( 'Normal', 'wts-eae' ),
					'bold'   => __( 'Bold', 'wts-eae' ),
				],
				'condition' => [
					'tooltip_display'    => 'yes',
					'tooltip_typography' => 'yes',
				],
			]
		);

		$this->add_control(
			'tooltip_title_font_style',
			[
				'label'     => __( 'Style', 'wts-eae' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => [
					''        => __( 'Default', 'wts-eae' ),
					'normal'  => __( 'Normal', 'wts-eae' ),
					'italic'  => __( 'Italic', 'wts-eae' ),
					'oblique' => __( 'Oblique', 'wts-eae' ),
				],
				'condition' => [
					'tooltip_display'    => 'yes',
					'tooltip_typography' => 'yes',
				],
			]
		);

		$this->end_popover();

		$this->add_control(
			'tooltip_title_align',
			[
				'label'     => __( 'Alignment', 'wts-eae' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left' => [
						'title' => __( 'Left', 'wts-eae' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'wts-eae' ),
						'icon'  => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'wts-eae' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'default'   => 'left',
				'condition' => [
					'tooltip_display' => 'yes',
				],
			]
		);

		$this->add_control(
			'tooltip_title_margin',
			[
				'label'     => __( 'Bottom Margin', 'wts-eae' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 6,
				'condition' => [
					'tooltip_display' => 'yes',
				],
			]
		);

		$this->add_control(
			'tooltip_body_heading',
			[
				'label'     => __( 'Body', 'wts-eae' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'tooltip_display' => 'yes',
				],
			]
		);

		$this->add_control(
			'tooltip_body_color',
			[
				'label'     => __( 'Color', 'wts-eae' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'tooltip_display' => 'yes',
				],
			]
		);

		$this->add_control(
			'tooltip_body_typography',
			[
				'label'        => __( 'Typography', 'wts-eae' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'return_value' => 'yes',
				'condition'    => [
					'tooltip_display' => 'yes',
				],
			]
		);

		$this->start_popover();

		$this->add_control(
			'tooltip_typo_heading',
			[
				'label'     => __( 'Typography', 'wts-eae' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'after',
				'condition' => [
					'tooltip_display'         => 'yes',
					'tooltip_body_typography' => 'yes',
				],
			]
		);

		$this->add_control(
			'tooltip_body_font_family',
			[
				'label'     => __( 'Family', 'wts-eae' ),
				'type'      => Controls_Manager::FONT,
				'default'   => '',
				'condition' => [
					'tooltip_display'         => 'yes',
					'tooltip_body_typography' => 'yes',
				],
			]
		);

		$this->add_control(
			'tooltip_body_font_size',
			[
				'label'     => __( 'Size', 'wts-eae' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 1,
						'max' => 200,
					],
				],
				'default'   => [
					'unit' => 'px',
					'size' => 12,
				],
				'condition' => [
					'tooltip_display'         => 'yes',
					'tooltip_body_typography' => 'yes',
				],
			]
		);

		$this->add_control(
			'tooltip_body_font_weight',
			[
				'label'     => __( 'Weight', 'wts-eae' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'100'    => __( '100', 'wts-eae' ),
					'200'    => __( '200', 'wts-eae' ),
					'300'    => __( '300', 'wts-eae' ),
					'400'    => __( '400', 'wts-eae' ),
					'500'    => __( '500', 'wts-eae' ),
					'600'    => __( '600', 'wts-eae' ),
					'700'    => __( '700', 'wts-eae' ),
					'800'    => __( '800', 'wts-eae' ),
					'900'    => __( '900', 'wts-eae' ),
					''       => __( 'Default', 'wts-eae' ),
					'normal' => __( 'Normal', 'wts-eae' ),
					'bold'   => __( 'Bold', 'wts-eae' ),
				],
				'condition' => [
					'tooltip_display'         => 'yes',
					'tooltip_body_typography' => 'yes',
				],
			]
		);

		$this->add_control(
			'tooltip_body_font_style',
			[
				'label'     => __( 'Style', 'wts-eae' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => [
					''        => __( 'Default', 'wts-eae' ),
					'normal'  => __( 'Normal', 'wts-eae' ),
					'italic'  => __( 'Italic', 'wts-eae' ),
					'oblique' => __( 'Oblique', 'wts-eae' ),
				],
				'condition' => [
					'tooltip_display'         => 'yes',
					'tooltip_body_typography' => 'yes',
				],
			]
		);

		$this->end_popover();

		$this->add_control(
			'tooltip_body_align',
			[
				'label'     => __( 'Alignment', 'wts-eae' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left' => [
						'title' => __( 'Left', 'wts-eae' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'wts-eae' ),
						'icon'  => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'wts-eae' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'default'   => 'left',
				'condition' => [
					'tooltip_display' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

}
