<?php

namespace WTS_EAE\Modules\Chart\Skins;

use WTS_EAE\Classes\Post_Helper;
use Elementor\Skin_Base as Elementor_Skin_Base;
use WTS_EAE\Modules\Chart\Classes\Map_Data;
use Elementor\Widget_Base;
abstract class Skin_Base extends Elementor_Skin_Base {

	protected function _register_controls_actions() {

		add_action( 'elementor/element/eae-charts/tl_skins/after_section_end', [ $this, 'register_style_controls' ] );
	}

	public function register_controls( Widget_Base $widget ) {
		$this->parent = $widget;
	}

	public function common_render() {
		$settings = $this->parent->get_settings_for_display();

		require_once EAE_PATH . 'modules/chart/classes/map-data.php';

		$this->parent->add_render_attribute(
			'chart-container',
			[
				'class'         => 'eae-chart-outer-container',
				'data-settings' => Map_Data::render_chart( $settings ),
			]
		);
		$this->parent->add_render_attribute( 'wrapper', 'class', 'eae-chart-wrapper' );
		$this->parent->add_render_attribute( 'chart-canvas', 'id', 'eae-chart-canvas' );

		?>
			<div <?php echo $this->parent->get_render_attribute_string( 'chart-container' ); ?>>
				<?php if ( ! empty( $settings['eae_chart_background_color_image']['id'] ) && $settings['chart_overlay'] === 'yes' ) { ?>
				<div class="eae-chart-overlay"></div>
				<?php } ?>
				<div <?php echo $this->parent->get_render_attribute_string( 'wrapper' ); ?>>
					<canvas <?php echo $this->parent->get_render_attribute_string( 'chart-canvas' ); ?> ></canvas>
				</div>
			</div>

		<?php
	}
}
