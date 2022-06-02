<?php
/**
 * Chart Widget Data
 */
namespace WTS_EAE\Modules\Chart\Classes;

class Map_Data {

	public static function render_chart( $settings ) {
		$chart_settings = wp_json_encode(
			[
				'type'    => $settings['_skin'],
				'data'    => [
					'labels'   => explode( ',', esc_html( $settings['labels'] ) ),
					'datasets' => self::chart_data( $settings ),
				],
				'options' => self::chart_option( $settings ),
			]
		);

		return $chart_settings;
	}

	public static function chart_data( $settings ) {

		$chart_data = [];
		$datasets   = $settings['dataset'];

		if ( ! empty( $datasets ) ) {
			foreach ( $datasets as $dataset ) {
				$dataset['label'] = ! empty( $dataset['dataset_label'] ) ? esc_html( $dataset['dataset_label'] ) : '';
				$dataset['data']  = ! empty( $dataset['dataset_data'] ) ? array_map( 'trim', explode( ',', $dataset['dataset_data'] ) ) : '';

				if ( $settings['_skin'] === 'bar' || $settings['_skin'] === 'horizontalBar' ) {
					$dataset['backgroundColor']      = ! empty( $dataset['background_color'] ) ? $dataset['background_color'] : '#52C0C0BA';
					$dataset['hoverBackgroundColor'] = ! empty( $dataset['background_hover_color'] ) ? $dataset['background_hover_color'] : '#52C0C0E0';
					$dataset['borderWidth']          = ! empty( $settings['bar_border_width'] ) ? $settings['bar_border_width'] : 1;
					$dataset['borderColor']          = ! empty( $dataset['border_color'] ) ? $dataset['border_color'] : '#49C4C4';
					$dataset['hoverBorderColor']     = ! empty( $dataset['border_hover_color'] ) ? $dataset['border_hover_color'] : '#49C4C4';
				}

				// Line Chart
				if ( $settings['_skin'] === 'line' ) {
					$dataset['pointBackgroundColor']      = ! empty( $dataset['point_background_color'] ) ? $dataset['point_background_color'] : '#49C4C4';
					$dataset['pointHoverBackgroundColor'] = ! empty( $dataset['point_background_hover_color'] ) ? $dataset['point_background_hover_color'] : '#49C4C4';
					$dataset['pointBorderColor']          = ! empty( $dataset['point_border_color'] ) ? $dataset['point_border_color'] : '#49C4C4';
					$dataset['pointHoverBorderColor']     = ! empty( $dataset['point_border_hover_color'] ) ? $dataset['point_border_hover_color'] : '#49C4C4';
					$dataset['borderWidth']               = ! empty( $settings['line_border_width'] ) ? $settings['line_border_width'] : 2;
					$dataset['borderColor']               = ! empty( $dataset['line_border_color'] ) ? $dataset['line_border_color'] : '#49C4C4';
					$dataset['pointRadius']               = ! empty( $settings['line_point_size'] ) ? $settings['line_point_size'] : 4;
					$dataset['pointHoverRadius']          = ! empty( $settings['line_point_hover_size'] ) ? $settings['line_point_hover_size'] : 4;
					$dataset['fill']                      = $dataset['line_fill_color'] === 'yes' ? true : false;
					$dataset['backgroundColor']           = $dataset['fill'] === true ? $dataset['line_bg_color'] : 'rgba(0, 0, 0, 0)';
					$dataset['borderJoinStyle']           = ! empty( $settings['line_joint_style'] ) ? $settings['line_joint_style'] : 'miter';
					$dataset['pointStyle']                = ! empty( $settings['line_point_style'] ) ? $settings['line_point_style'] : 'circle';
					$dataset['steppedLine']               = $settings['line_stepped'] === 'yes' ? true : false;
				}

				$chart_data[] = $dataset;

			}
		}

		return $chart_data;
	}

	public static function chart_option( $settings ) {

		$xaxes_grid_line      = $settings['xaxes_grid_line'] === 'yes' ? true : false;
		$xaxes_title_display  = $settings['xaxes_display_title'] === 'yes' ? true : false;
		$xaxes_labels_display = $settings['xaxes_labels_display'] === 'yes' ? true : false;
		$yaxes_labels_display = $settings['yaxes_labels_display'] === 'yes' ? true : false;
		$yaxes_grid_line      = $settings['yaxes_grid_line'] === 'yes' ? true : false;
		$yaxes_title_display  = $settings['yaxes_display_title'] === 'yes' ? true : false;
		$legend_display       = $settings['legend_display'] === 'yes' ? true : false;
		$title_display        = $settings['title_display'] === 'yes' ? true : false;
		$display_tooltip      = $settings['tooltip_display'] === 'yes' ? true : false;

		$title = [
			'display'    => $title_display,
			'text'       => $settings['title'],
			'position'   => ! empty( $settings['title_position'] ) ? $settings['title_position'] : 'top',
			'fontColor'  => ! empty( $settings['heading_color'] ) ? $settings['heading_color'] : '#666',
			'fontFamily' => ! empty( $settings['heading_font_family'] ) ? $settings['heading_font_family'] : 'auto',
			'fontSize'   => ! empty( $settings['heading_font_size']['size'] ) ? $settings['heading_font_size']['size'] : 16,
			'fontStyle'  => ( ! empty( $settings['heading_font_style'] ) ? $settings['heading_font_style'] : '' ) . ' ' . ( ! empty( $settings['heading_font_weight'] ) ? $settings['heading_font_weight'] : '' ),
			'lineHeight' => ! empty( $settings['heading_line_height'] ) ? $settings['heading_line_height'] : 1.2,
			'padding'    => ! empty( $settings['chart_heading_padding']['size'] ) ? $settings['chart_heading_padding']['size'] : 10,
		];

		$Legend = [
			'display'  => $legend_display,
			'position' => ! empty( $settings['legend_position'] ) ? $settings['legend_position'] : 'top',
			'align'    => $settings['legend_align'],
			'reverse'  => $settings['legend_reverse'] === 'yes' ? true : false,
			'labels'   => [
				'boxWidth'   => ! empty( $settings['legend_box_width']['size'] ) ? $settings['legend_box_width']['size'] : 40,
				'fontColor'  => ! empty( $settings['legend_color'] ) ? $settings['legend_color'] : '#666',
				'fontFamily' => ! empty( $settings['legend_font_family'] ) ? $settings['legend_font_family'] : 'auto',
				'fontSize'   => ! empty( $settings['legend_font_size']['size'] ) ? $settings['legend_font_size']['size'] : 12,
				'fontStyle'  => ( ! empty( $settings['legend_font_style'] ) ? $settings['legend_font_style'] : '' ) . ' ' . ( ! empty( $settings['legend_font_weight'] ) ? $settings['legend_font_weight'] : '' ),
				'lineHeight' => ! empty( $settings['legend_line_height'] ) ? $settings['legend_line_height'] : 1.2,
				'padding'    => ! empty( $settings['legend_padding']['size'] ) ? $settings['legend_padding']['size'] : 10,
			],
		];

		$tooltip = [
			'enabled'           => $display_tooltip,
			'mode'              => ! empty( $settings['tooltip_mode'] ) ? $settings['tooltip_mode'] : 'nearest',
			'backgroundColor'   => ! empty( $settings['tooltip_background_color'] ) ? $settings['tooltip_background_color'] : 'rgba(0, 0, 0, 0.8)',
			'borderColor'       => ! empty( $settings['tooltip_border_color'] ) ? $settings['tooltip_border_color'] : 'rgba(0, 0, 0, 0.8)',
			'borderWidth'       => ! empty( $settings['tooltip_border_width']['size'] ) ? $settings['tooltip_border_width']['size'] : 1,
			'cornerRadius'      => ! empty( $settings['tooltip_border_radius'] ) ? $settings['tooltip_border_radius'] : 6,
			'xPadding'          => ! empty( $settings['tooltip_padding'] ) ? $settings['tooltip_padding'] : 6,
			'yPadding'          => ! empty( $settings['tooltip_padding'] ) ? $settings['tooltip_padding'] : 6,
			'caretSize'         => ! empty( $settings['tooltip_arrow_size'] ) ? $settings['tooltip_arrow_size'] : 5,
			'titleFontColor'    => ! empty( $settings['tooltip_title_color'] ) ? $settings['tooltip_title_color'] : '#fff',
			'titleFontFamily'   => ! empty( $settings['tooltip_title_font_family'] ) ? $settings['tooltip_title_font_family'] : 'auto',
			'titleFontSize'     => ! empty( $settings['tooltip_title_font_size']['size'] ) ? $settings['tooltip_title_font_size']['size'] : 12,
			'titleFontStyle'    => ( ! empty( $settings['tooltip_title_font_style'] ) ? $settings['tooltip_title_font_style'] : '' ) . ' ' . ( ! empty( $settings['tooltip_title_font_weight'] ) ? $settings['tooltip_title_font_weight'] : '' ),
			'titleAlign'        => ! empty( $settings['tooltip_title_align'] ) ? $settings['tooltip_title_align'] : 'left',
			'titleMarginBottom' => ! empty( $settings['tooltip_title_margin'] ) ? $settings['tooltip_title_margin'] : 6,
			'bodyFontColor'     => ! empty( $settings['tooltip_body_color'] ) ? $settings['tooltip_body_color'] : '#fff',
			'bodyFontFamily'    => ! empty( $settings['tooltip_body_font_family'] ) ? $settings['tooltip_body_font_family'] : 'auto',
			'bodyFontSize'      => ! empty( $settings['tooltip_body_font_size']['size'] ) ? $settings['tooltip_body_font_size']['size'] : 12,
			'bodyFontStyle'     => ( ! empty( $settings['tooltip_body_font_style'] ) ? $settings['tooltip_body_font_style'] : '' ) . ' ' . ( ! empty( $settings['tooltip_body_font_weight'] ) ? $settings['tooltip_body_font_weight'] : '' ),
			'bodySpacing'       => 6,
			'bodyAlign'         => ! empty( $settings['tooltip_body_align'] ) ? $settings['tooltip_body_align'] : 'left',
		];

		/** X- Axes configuration */

		if ( $xaxes_grid_line === 'yes' ) {
			$xaxes_grid = [
				'drawBorder' => false,
				'color'      => ! empty( $settings['xaxes_grid_color'] ) ? $settings['xaxes_grid_color'] : 'rgba(0, 0, 0, 0.1)',
				'lineWidth'  => ! empty( $settings['xaxes_grid_width']['size'] ) ? $settings['xaxes_grid_width']['size'] : 1,
			];
		} else {
			$xaxes_grid = [];
		}

		$xaxes_labels = [
			'display'     => $xaxes_labels_display,
			'beginAtZero' => true,
			'stepSize'    => isset( $settings['step_size'] ) ? $settings['step_size'] : 10,
			'max'         => isset( $settings['axis_range'] ) ? $settings['axis_range'] : 100,
			'fontColor'   => ! empty( $settings['xaxes_label_color'] ) ? $settings['xaxes_label_color'] : '#666',
			'fontFamily'  => ! empty( $settings['xaxes_lable_font_family'] ) ? $settings['xaxes_lable_font_family'] : 'auto',
			'fontSize'    => ! empty( $settings['xaxes_lable_font_size']['size'] ) ? $settings['xaxes_lable_font_size']['size'] : 12,
			'fontStyle'   => ( ! empty( $settings['xaxes_lable_font_style'] ) ? $settings['xaxes_lable_font_style'] : '' ) . ' ' . ( ! empty( $settings['xaxes_lable_font_weight'] ) ? $settings['xaxes_lable_font_weight'] : '' ),
			'lineHeight'  => ! empty( $settings['xaxes_lable_line_height'] ) ? $settings['xaxes_lable_line_height'] : 1.2,
			'padding'     => ! empty( $settings['xaxes_labels_padding']['size'] ) ? $settings['xaxes_labels_padding']['size'] : 10,
		];

		if ( $xaxes_title_display === 'yes' ) {
			$xaxes_Title = [
				'display'     => $xaxes_title_display,
				'labelString' => $settings['xaxes_title'],
				'fontColor'   => ! empty( $settings['xaxes_title_color'] ) ? $settings['xaxes_title_color'] : '#666',
				'fontFamily'  => ! empty( $settings['xaxes_title_font_family'] ) ? $settings['xaxes_title_font_family'] : 'auto',
				'fontSize'    => ! empty( $settings['xaxes_title_font_size']['size'] ) ? $settings['xaxes_title_font_size']['size'] : 15,
				'fontStyle'   => ( ! empty( $settings['xaxes_title_font_style'] ) ? $settings['xaxes_title_font_style'] : '' ) . ' ' . ( ! empty( $settings['xaxes_title_font_weight'] ) ? $settings['xaxes_title_font_weight'] : '' ),
				'lineHeight'  => ! empty( $settings['xaxes_title_line_height'] ) ? $settings['xaxes_title_line_height'] : 1.2,
			];
		} else {
			$xaxes_Title = [];
		}

		/** Y- Axes configuration */

		if ( $yaxes_grid_line === 'yes' ) {
			$yaxes_grid = [
				'drawBorder' => false,
				'color'      => ! empty( $settings['yaxes_grid_color'] ) ? $settings['yaxes_grid_color'] : 'rgba(0, 0, 0, 0.1)',
				'lineWidth'  => ! empty( $settings['yaxes_grid_width']['size'] ) ? $settings['yaxes_grid_width']['size'] : 1,
			];
		} else {
			$yaxes_grid = [];
		}

		$yaxes_labels = [
			'display'     => $yaxes_labels_display,
			'beginAtZero' => true,
			'stepSize'    => isset( $settings['step_size'] ) ? $settings['step_size'] : 1,
			'max'         => isset( $settings['axis_range'] ) ? $settings['axis_range'] : 10,
			'fontColor'   => ! empty( $settings['yaxes_label_color'] ) ? $settings['yaxes_label_color'] : '#666',
			'fontFamily'  => ! empty( $settings['yaxes_lable_font_family'] ) ? $settings['yaxes_lable_font_family'] : 'auto',
			'fontSize'    => ! empty( $settings['yaxes_lable_font_size']['size'] ) ? $settings['yaxes_lable_font_size']['size'] : 12,
			'fontStyle'   => ( ! empty( $settings['yaxes_lable_font_style'] ) ? $settings['yaxes_lable_font_style'] : '' ) . ' ' . ( ! empty( $settings['yaxes_lable_font_weight'] ) ? $settings['yaxes_lable_font_weight'] : '' ),
			'lineHeight'  => ! empty( $settings['yaxes_lable_line_height'] ) ? $settings['yaxes_lable_line_height'] : 1.2,
			'padding'     => ! empty( $settings['yaxes_labels_padding']['size'] ) ? $settings['yaxes_labels_padding']['size'] : 10,
		];

		if ( $yaxes_title_display === 'yes' ) {
			$yaxes_Title = [
				'display'     => $yaxes_title_display,
				'labelString' => $settings['yaxes_title'],
				'fontColor'   => ! empty( $settings['yaxes_title_color'] ) ? $settings['yaxes_title_color'] : '#666',
				'fontFamily'  => ! empty( $settings['yaxes_title_font_family'] ) ? $settings['yaxes_title_font_family'] : 'auto',
				'fontSize'    => ! empty( $settings['yaxes_title_font_size']['size'] ) ? $settings['yaxes_title_font_size']['size'] : 15,
				'fontStyle'   => ( ! empty( $settings['yaxes_title_font_style'] ) ? $settings['yaxes_title_font_style'] : '' ) . ' ' . ( ! empty( $settings['yaxes_title_font_weight'] ) ? $settings['yaxes_title_font_weight'] : '' ),
				'lineHeight'  => ! empty( $settings['yaxes_title_line_height'] ) ? $settings['yaxes_title_line_height'] : 1.2,
			];
		} else {
			$yaxes_Title = [];
		}

		/** Options Array */

		$options = [

			'title'               => $title,
			'tooltips'            => $tooltip,
			'legend'              => $Legend,
			'animation'           => [
				'easing'   => $settings['chart_animation'],
				'duration' => $settings['duration_animation'],
			],
			'layout'              => [
				'padding' => [
					'top'    => $settings['eae_chart_padding']['top'],
					'right'  => $settings['eae_chart_padding']['right'],
					'bottom' => $settings['eae_chart_padding']['bottom'],
					'left'   => $settings['eae_chart_padding']['left'],
				],
			],
			'maintainAspectRatio' => false,
			'scales'              => [
				'xAxes' => [
					[
						'ticks'              => $xaxes_labels,
						'scaleLabel'         => $xaxes_Title,
						'gridLines'          => $xaxes_grid,
						'barPercentage'      => ( ! empty( $settings['bar_width']['size'] ) ) ? $settings['bar_width']['size'] / 100 : '0.80000000000000004',
						'categoryPercentage' => ( ! empty( $settings['bar_category_width']['size'] ) ) ? $settings['bar_category_width']['size'] / 100 : '0.84999999999999998',
					],
				],
				'yAxes' => [
					[
						'ticks'              => $yaxes_labels,
						'scaleLabel'         => $yaxes_Title,
						'gridLines'          => $yaxes_grid,
						'barPercentage'      => ( ! empty( $settings['bar_width']['size'] ) ) ? $settings['bar_width']['size'] / 100 : '0.80000000000000004',
						'categoryPercentage' => ( ! empty( $settings['bar_category_width']['size'] ) ) ? $settings['bar_category_width']['size'] / 100 : '0.84999999999999998',
					],

				],

			],

		];

		return $options;
	}

}
