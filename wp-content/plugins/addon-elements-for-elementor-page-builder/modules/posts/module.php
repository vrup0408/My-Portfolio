<?php

namespace WTS_EAE\Modules\Posts;

use WTS_EAE\Base\Module_Base;

class Module extends Module_Base {

	public function get_widgets() {
		return [
			'Posts',
		];
	}

	public function get_name() {
		return 'eae-posts';
	}

}
