<?php

namespace WTS_EAE\Modules\Chart\Skins;

use Elementor\Widget_Base;

class Skin_Horizontal_Bar_Chart extends Skin_Base {

	public function get_id() {
		return 'horizontalBar';
	}

	public function get_title() {
		return __( 'Horizontal Bar', 'wts-eae' );
	}

	public function register_items_control( Widget_Base $widget ) {
		$this->parent = $widget;
	}
	public function render() {
		$this->common_render();
	}
}
