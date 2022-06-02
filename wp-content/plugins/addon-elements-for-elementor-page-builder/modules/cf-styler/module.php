<?php

namespace WTS_EAE\Modules\CfStyler;

use WTS_EAE\Base\Module_Base;

class Module extends Module_Base
{

    public function get_widgets()
    {
        return [
            'CfStyler',
        ];
    }

    public function get_name()
    {
        return 'eae-cf-styler';
    }
}