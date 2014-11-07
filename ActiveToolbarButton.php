<?php

namespace pipekung\widgets;

use Yii;
use yii\helpers\Html;

/**
 * Description of ActiveToolbarButton
 * 
 * For example:
 * 
 * echo ActiveToolbarButton::widget();
 * ```
 *
 * @author Pipekung Specialz <chanja@kku.ac.th>
 * @since 2.0
 */
class ActiveToolbarButton extends Widget {

    public function init() {
        parent::init();
        $this->options['class'] = 'btn-group';
        $this->options['style'] = 'margin-bottom: 20px;';
    }

    public function run() {
        echo Html::beginTag('div', $this->options) . "\n";
        echo $this->renderItems() . "\n";
        echo Html::endTag('div') . "\n";
        $this->registerScript();
    }

    public function renderItems() {
        $items = [
            Html::a('<i class="glyphicon glyphicon-plus-sign"></i> ' . 'Create', ['create'], ['class' => 'btn btn-success']),
            Html::button('<i class="glyphicon glyphicon-search"></i> Search', ['type' => 'button', 'class' => 'btn btn-default']),
        ];

        return implode("\n", $items);
    }

    public function registerScript() {
        $id = $this->options['id'];
        Yii::$app->view->registerJs("
        $(document).on('click', 'div#$id button', function() {
            $('.search').toggle('fade');
        });
        ");
    }

}
