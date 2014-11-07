<?php

namespace pipekung\widgets;

use Yii;
use rnd\classes\Common;

/**
 * Description of RndDateTimePicker
 *
 * @author Pipekung Specialz <chanja@kku.ac.th>
 * @since 2.0
 */
class DateTimePicker extends Widget {

    public $model;
    public $form;
    public $name;
    public $attr;
    public $options;
    public $between = [];
    protected $classModel;
    protected $label;

    public function init() {
        parent::init();
        
        $this->classModel = Common::getClassName($this->model);
        
        if (empty($this->between)) {
            $this->label = $this->model->getAttributeLabel($this->attr);
        } else {
            $this->label[0] = $this->model->getAttributeLabel($this->between[0]);
            $this->label[1] = $this->model->getAttributeLabel($this->between[1]);
        }
        
        $this->options = array_merge([
            'format' => 'Y-m-d H:i',
            'lang' => 'th',
            'datepicker' => true,
            'timepicker' => true,
            'disabledWeekends' => true,
            'inline' => false,
            'scrollMonth' => false,
            'yearStart' => date('Y') - 100,
            'yearEnd' => date('Y') + 100,
            'minTime' => '08:30',
            'maxTime' => '22:30',
            'step' => 30,
//            'weekends' => [
//                '2014/01/01', '2014/01/02', '2014/12/30', '2014/12/31'
//            ],
//            'allowTimes' => [
//                '08:30', '09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '12:00', '12:30',
//                '13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00',
//                '17:30', '18:00', '18:30', '19:00', '19:30', '20:00', '20:30', '21:00', '21:30',
//            ]
        ], $this->options);
    }

    public function run() {
        if (empty($this->between)) {
            $this->renderField();
            $this->registerScript();
        } else {
            $this->renderMultiField();
            $this->registerScript(true);
        }
    }
    
    public function renderField() {
        echo $this->form->field($this->model, $this->attr, [
            'addon' => [
                'prepend' => ['content' => '<i class="glyphicon glyphicon-calendar"></i>'],
                'groupOptions' => ['class' => 'col-sm-4'],
            ]
        ])->textInput(['readonly' => 'readonly', 'placeholder' => "คลิกเลือก {$this->label}", 'class' => 'form-control hasDateTimePicker']);
    }
    
    public function renderMultiField() {
        echo $this->form->field($this->model, $this->between[0], [
            'addon' => [
                'prepend' => ['content' => '<i class="glyphicon glyphicon-calendar"></i>'],
                'groupOptions' => ['class' => 'col-sm-4'],
            ]
        ])->textInput(['readonly' => 'readonly', 'placeholder' => "คลิกเลือก {$this->label[0]}", 'class' => 'form-control hasDateTimePicker']);
        echo $this->form->field($this->model, $this->between[1], [
            'addon' => [
                'prepend' => ['content' => '<i class="glyphicon glyphicon-calendar"></i>'],
                'groupOptions' => ['class' => 'col-sm-4'],
            ]
        ])->textInput(['readonly' => 'readonly', 'placeholder' => "คลิกเลือก {$this->label[1]}", 'class' => 'form-control hasDateTimePicker']);
    }
    
    public function registerScript($multi=false) {
        $view = $this->getView();
        RndDateTimePickerAsset::register($view);
        
        $option = '';
        foreach ($this->options as $k => $val) {
            if (is_array($val)) {
                $tmp = implode("', '", $val);
                $option .= "'{$k}': ['{$tmp}'],";
            } else {
                if ($k === 'disabledWeekends') continue;
                elseif ($k === 'id') continue;
                $option .= "'{$k}': '{$val}',";
            }
        }
        
        $disabledWeekends = '';
        if (isset($this->options['disabledWeekends']) && $this->options['disabledWeekends']) {
            $disabledWeekends = "onGenerate:function( ct ){
                jQuery(this).find('.xdsoft_date.xdsoft_weekend').addClass('xdsoft_disabled');
            },";
        }
        
        if ($multi) {
$js = <<< JS
    jQuery('#{$this->classModel}-{$this->between[0]}').datetimepicker({
        {$option}
        {$disabledWeekends}
        onShow:function( ct ){
            this.setOptions({
                maxDate:jQuery('#{$this->classModel}-{$this->between[1]}').val()?jQuery('#{$this->classModel}-{$this->between[1]}').val():false
            })
        },
    });
    jQuery('#{$this->classModel}-{$this->between[1]}').datetimepicker({
        {$option}
        {$disabledWeekends}
        onShow:function( ct ){
            this.setOptions({
                minDate:jQuery('#{$this->classModel}-{$this->between[0]}').val()?jQuery('#{$this->classModel}-{$this->between[0]}').val():false
            })
        },
    });
JS;
        } else {
$js = <<< JS
    jQuery('#{$this->classModel}-{$this->attr}').datetimepicker({
        {$disabledWeekends}
        {$option}
    });
JS;
        }
        
        Yii::$app->view->registerJs($js);
    }

}
