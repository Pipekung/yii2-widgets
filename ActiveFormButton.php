<?php

namespace pipekung\widgets;

use Yii;
use yii\helpers\Html;

/**
 * Description of ActiveFormButton
 * 
 * For example:
 * 
 * echo ActiveFormButton::widget(['model' => $model]);
 * ```
 *
 * @author Pipekung Specialz <chanja@kku.ac.th>
 * @since 2.0
 */
class ActiveFormButton extends Widget {

    public $model;

    public function init() {
        parent::init();
        $this->options['class'] = 'col-sm-offset-2 col-sm-10';
    }

    public function run() {
        echo Html::beginTag('div', ['class' => 'form-group']) . "\n";
        echo Html::beginTag('div', $this->options) . "\n";
        echo $this->renderItems() . "\n";
        echo Html::endTag('div') . "\n";
        echo Html::endTag('div') . "\n";
    }

    public function renderItems() {
        $items = [
            Html::submitButton($this->model->isNewRecord ? '<i class="glyphicon glyphicon-ok-sign"></i> ' . Yii::t('app', 'Create') : '<i class="glyphicon glyphicon-ok-sign"></i> ' . Yii::t('app', 'Update'), ['class' => $this->model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']),
            Html::a('<i class="glyphicon glyphicon-remove-sign"></i> ' . Yii::t('app', 'Cancel'), ['index'], ['class' => 'btn btn-default']),
        ];

        return implode("\n", $items);
    }

}
