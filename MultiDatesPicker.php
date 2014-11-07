<?php

namespace pipekung\widgets;

use Yii;
use rnd\classes\Common;

/**
 * Description of RndMultiDatesPicker
 *
 * @author Pipekung Specialz <chanja@kku.ac.th>
 * @since 2.0
 */
class MultiDatesPicker extends Widget {

    public $model;
    public $form;
    public $name;
    public $attr;
    public $options;
    protected $classModel;
    protected $label;

    public function init() {
        parent::init();
        
        $this->classModel = Common::getClassName($this->model);
        $this->label = $this->model->getAttributeLabel($this->attr);
        $this->options = array_merge([
            'dateFormat' => "yy-mm-dd",
            'multidate' => true,
            'disabledWeekends' => true,
            'monthNamesShort' => ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน',
		'กรกฏาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
        ], $this->options);
    }

    public function run() {
        $this->renderField();
        $this->registerScript();
    }
    
    public function renderField() {
        echo $this->form->field($this->model, $this->attr, [
            'addon' => [
                'prepend' => ['content' => '<i class="glyphicon glyphicon-calendar"></i>'],
                //'groupOptions' => ['class' => 'col-sm-4'],
            ]
        ])->textInput(['readonly' => 'readonly', 'placeholder' => "คลิกเลือก {$this->label}"]);
    }
    
    public function registerScript($multi=false) {
        $view = $this->getView();
        RndMultiDatesPickerAsset::register($view);
        
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
            $disabledWeekends = "'beforeShowDay': $.datepicker.noWeekends, ";
        }
        
        $js = <<< JS
            jQuery('#{$this->classModel}-{$this->attr}').multiDatesPicker({
                {$disabledWeekends}
                {$option}
            });
JS;
        
        Yii::$app->view->registerJs($js);
    }

}
