<?php

namespace AprSoft\DateRangePicker;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;
use yii\widgets\InputWidget;

class DateRangePicker extends InputWidget
{

    //配置选项
    public $clientOptions = [
        "locale" => [
            "format" => "YYYY/MM/DD",
            "separator" => " - ",
            "applyLabel" => "确   定",
            "cancelLabel" => "取   消",
            "fromLabel" => "From",
            "toLabel" => "To",
            "customRangeLabel" => "自定义",
            "daysOfWeek" => [
                "日", "一", "二", "三", "四", "五", "六",
            ],
            "monthNames" => [
                "1月", "2月", "3月", "4月", "5月", "6月", "7月", "8月", "9月", "10月", "11月", "12月",
            ],
            "firstDay" => 1,
        ],
    ];
    //默认配置
    protected $_options = [

    ];

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {

        $this->options['id'] = $this->hasModel() ? Html::getInputId($this->model, $this->attribute) : $this->id;

        $this->options['class'] = isset($this->options['class']) ? $this->options['class'] : 'form-control';
        $this->_options = [
            "alwaysShowCalendars" => true,
            "startDate" => date('Y/m', time()) . "/01",
            "endDate" => date('Y/m', time()) . "/" . date('t', time()),
            "ranges" => $this->getRanges(),
            "opens" => "left",
            "autoUpdateInput" => false,

        ];
        $this->clientOptions = ArrayHelper::merge($this->_options, $this->clientOptions);
        parent::init();
    }

    public function run()
    {
        $this->registerAssets();
        if ($this->hasModel()) {
            return Html::activeTextInput($this->model, $this->attribute, $this->options);
        } else {
            return Html::textInput($this->id, $this->value, $this->options);
        }
    }

    protected function registerAssets()
    {
        DateRangePickerAsset::register($this->view);
        $clientOptions = Json::encode($this->clientOptions);
        $script = "$('#" . $this->options['id'] . "').daterangepicker(" . $clientOptions . ");";
        $script .= "$('#" . $this->options['id'] . "').on('apply.daterangepicker', function(ev, picker) { $(this).val(picker.startDate.format('YYYY/MM/DD') + ' - ' + picker.endDate.format('YYYY/MM/DD')); });";
        $script .= "$('#" . $this->options['id'] . "').on('cancel.daterangepicker', function(ev, picker) { $(this).val(''); });";
        $this->view->registerJs($script, View::POS_READY);
    }

    protected function getRanges()
    {
        $ranges = [];
        //今天
        $day = date('Y/m/d', time());

        $ranges['今天'] = [$day, $day];
        //昨天
        $yesterday = date('Y/m/d', strtotime("-1 day"));
        $ranges['昨天'] = [$yesterday, $yesterday];
        //最近7天
        $seven_day = date('Y/m/d', strtotime("-7 day"));
        $ranges['最近7天'] = [$seven_day, $day];
        //最近30天
        $th_day = date('Y/m/d', strtotime("-30 day"));
        $ranges['最近30天'] = [$th_day, $day];
//        $date=date('Y-m-d');  //当前日期
        //        $first=1; //$first =1 表示每周星期一为开始日期 0表示每周日为开始日期
        //        $w=date('w',strtotime($date));  //获取当前周的第几天 周日是 0 周一到周六是 1 - 6
        //        $now_start=date('Y-m-d',strtotime("$date -".($w ? $w - $first : 6).' days')); //获取本周开始日期，如果$w是0，则表示周日，减去 6 天
        //        $now_end=date('Y-m-d',strtotime("$now_start +6 days"));  //本周结束日期
        //
        //        $ranges['本周'] = [$now_start, $now_end];
        //获取当前月份
        $month = date('Y-m', time());
        //开始时间
        $start_month = $month . '-' . '01';
        //结束时间
        $end_month = $month . '-' . date('t', time());
        $ranges['本月'] = [$start_month, $end_month];
        //获取当前年份
        $year = date('Y', time());
        //开始时间
        $start_year = $year . '-' . '01' . '-' . '01';
        //结束时间
        $end_year = $year . '-' . '12' . '-' . date('t', strtotime($year . '-' . '12'));
        $ranges['今年'] = [$start_year, $end_year];

        return $ranges;
    }
}
