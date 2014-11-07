<?php

namespace pipekung\widgets;

use Yii;
use yii\helpers\Html;

/**
 * Description of ActiveViewButton
 * 
 * For example:
 * 
 * echo ActiveViewButton::widget(['model' => $model]);
 * ```
 *
 * @author Pipekung Specialz <chanja@kku.ac.th>
 * @since 2.0
 */
class ActiveViewButton extends Widget {

    public $model;
    public $items = [];

    public function init() {
        parent::init();
    }

    public function run() {
        echo Html::beginTag('p') . "\n";
        echo $this->initItems() . "\n";
        echo Html::endTag('p') . "\n";
    }

    public function initItems() {
        $items = [
            Html::a('<i class="glyphicon glyphicon-chevron-left"></i> ' . Yii::t('app', 'Back'), ['index'], ['class' => 'btn btn-default']),
            $this->renderItems() . "\n",
            Html::a('<i class="glyphicon glyphicon-edit"></i> ' . Yii::t('app', 'Update'), ['update', 'id' => $this->model->id], ['class' => 'btn btn-primary']),
            Html::a('<i class="glyphicon glyphicon-trash"></i> ' . Yii::t('app', 'Delete'), ['delete', 'id' => $this->model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]),
        ];

        return implode("\n", $items);
    }

    public function renderItems() {
        $items = [];
        foreach ($this->items as $val) {
            $items[] = Html::a('<i class="glyphicon glyphicon-'. $val['icon'] .'"></i> ' . Yii::t('app', $val['label']), $val['url'], $val['options']);
        }

        return implode("\n", $items);
    }

}
