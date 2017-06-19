<?php

namespace AprSoft\DateRangePicker;

use yii\web\AssetBundle;

class DateRangeAsset extends AssetBundle
{

    public $css = [
        'css/daterangepicker.css',
    ];

    public $js = [
        'js/moment.js',
        'js/daterangepicker.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];

    public function init()
    {
        $this->sourcePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
    }

}
