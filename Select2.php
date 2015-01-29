<?php

namespace pipekung\widgets;

/**
 * Description of DatePicker
 *
 * @author Pipekung Specialz <chanja@kku.ac.th>
 * @since 2.0
 */
class Select2 extends Widget {

    public $model;
    public $form;
    public $name;
    public $attr;
    public $data;
    public $options;
    protected $label;

    public function init() {
        parent::init();

        $this->label = $this->model->getAttributeLabel($this->attr);
        $this->options = [
            'placeholder' => "คลิกเลือก {$this->label}"
        ];
    }

    public function run() {
        echo $this->form->field($this->model, $this->attr)->widget(\kartik\widgets\Select2::classname(), [
            'language' => 'th',
            'data' => $this->data,
            'options' => $this->options,
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
    }

}
