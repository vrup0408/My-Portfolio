<?php

namespace WTS_EAE\Modules\DataTable;

use WTS_EAE\Base\Module_Base;

class Module extends Module_Base {

	public function get_widgets() {
		return [
			'DataTable',
		];
	}

	public function get_name() {
		return 'eae-data-table';
	}

}
