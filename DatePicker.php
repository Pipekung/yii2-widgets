<?php

namespace pipekung\widgets;

use yii\jui\DatePicker;

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

    public function init() {
        parent::init();

        $this->label = $this->model->getAttributeLabel($this->attr);
        $this->clientOptions = array_merge($this->clientOptions, [
        ]);
    }

    public function run() {
        DatePicker::widget(['model' => $this->model, 'attribute' => $this->attr, 'clientOptions' => $this->clientOptions]);
        echo $this->form->field($this->model, $this->attr, [
            'addon' => [
                'prepend' => ['content' => '<i class="glyphicon glyphicon-calendar"></i>'],
                'groupOptions' => ['class' => 'col-sm-4'],
            ]
        ])->textInput(['readonly' => 'readonly', 'placeholder' => "คลิกเลือก {$this->label}"]);
    }

}
