<?php

namespace WTS_EAE\Modules\Chart\Skins;

use Elementor\Widget_Base;

class Skin_Polar_Area_Chart extends Skin_Base {

	public function get_id() {
		return 'polarArea';
	}

	public function get_title() {
		return __( 'Polar Area', 'wts-eae' );
	}

	public function register_items_control( Widget_Base $widget ) {
		$this->parent = $widget;
	}
	public function render() {
		$this->common_render();
	}
}
