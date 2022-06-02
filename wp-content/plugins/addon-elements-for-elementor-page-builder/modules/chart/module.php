<?php

namespace WTS_EAE\Modules\Chart;

use WTS_EAE\Base\Module_Base;

class Module extends Module_Base {

	public function get_widgets() {
		return [
			'Chart',
		];
	}

	public function get_name() {
		return 'eae-chart';
	}

	public function get_title() {

		return __( 'Chart', 'wts-eae' );
	}

}
