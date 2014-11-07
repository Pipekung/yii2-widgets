<?php

namespace pipekung\widgets;

use kartik\widgets\FileInput;
use yii\helpers\Html;

/**
 * Description of FileUpload
 *
 * @author ksorn <ksorn@kku.ac.th>
 * @since 2.0
 */
class FileUpload extends Widget {

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
    }

    public function run() {
       

       echo $this->form->field($this->model, $this->attr)->widget(FileInput::classname(), [
                        'options' => ['accept' => ''],
                        'pluginOptions' => [
                        'showPreview' => false,
                        'showCaption' => true,
                        'showRemove' => true,
                        'showUpload' => false,
                        

                        ]

                    ]);
       if( $this->model->getAttribute($this->attr)  !== null){
            echo '<div class="file-upload-update"><label class="col-sm-2"> </label>' .Html::a($this->model->getAttribute($this->attr), ['/uploads/'.$this->model->getAttribute($this->attr)]). '</div>';
        }

    }

}
