<?php

namespace WTS_EAE\Modules\Chart\Skins;

use Elementor\Widget_Base;

class Skin_Line_Chart extends Skin_Base {

	public function get_id() {
		return 'line';
	}

	public function get_title() {
		return __( 'Line', 'wts-eae' );
	}

	public function register_items_control( Widget_Base $widget ) {
		$this->parent = $widget;
	}
	public function render() {
		$this->common_render();
	}
}
