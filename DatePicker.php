<?php

namespace pipekung\widgets;

use yii\web\View;
use pipekung\classes\Common;

/**
 * Description of DatePicker
 *
 * @author Pipekung Specialz <chanja@kku.ac.th>
 * @since 2.0
 */
class DatePicker extends Widget {

    public $model;
    public $form;
    public $name;
    public $attr;
    public $clientOptions = array();
    protected $label;
    protected $element;

    public function init() {
        parent::init();

        $this->label = $this->model->getAttributeLabel($this->attr);
        $this->element = "#". Common::getClassName($this->model) ."-{$this->attr}";
        $this->clientOptions = array_merge($this->clientOptions, [
            'changeMonth' => true,
            'changeYear' => true,
            'hideIfNoPrevNext' => true,
            'showButtonPanel' => true,
            'monthNamesShort' => ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
            'dateFormat' => 'dd-mm-yy',
        ]);
    }

    public function run() {
        \yii\jui\DatePicker::widget(['model' => $this->model, 'attribute' => $this->attr]);
        echo $this->form->field($this->model, $this->attr, [
            'addon' => [
                'prepend' => ['content' => '<i class="glyphicon glyphicon-calendar"></i>'],
                'groupOptions' => ['class' => 'col-sm-4'],
            ]
        ])->textInput(['readonly' => 'readonly', 'placeholder' => "คลิกเลือก {$this->label}"]);
        $this->js();
    }

    public function js() {
        $options = json_encode($this->clientOptions);
        \Yii::$app->view->registerJs("\$('{$this->element}').datepicker({$options});", View::POS_END);
    }

}
