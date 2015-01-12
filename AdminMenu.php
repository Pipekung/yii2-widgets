<?php

namespace pipekung\widgets;

use yii\helpers\Html;

/**
 * Description of DatePicker
 *
 * @author Pipekung Specialz <chanja@kku.ac.th>
 * @since 2.0
 */
class AdminMenu extends Widget {

    public function init() {
        parent::init();
    }

    public function run() {
            
        echo Html::beginTag('p');
        echo Html::a('Assigments', ['/admin'], ['class' => 'btn btn-outline btn-primary']) . '&nbsp;';
        echo Html::a('Role', ['/admin/role'], ['class' => 'btn btn-outline btn-primary']) . '&nbsp;';
        echo Html::a('Permission', ['/admin/permission'], ['class' => 'btn btn-outline btn-primary']) . '&nbsp;';
        echo Html::a('Route', ['/admin/route'], ['class' => 'btn btn-outline btn-primary']) . '&nbsp;';
        echo Html::a('Rule', ['/admin/rule'], ['class' => 'btn btn-outline btn-primary']) . '&nbsp;';
        echo Html::a('Menu', ['/admin/menu'], ['class' => 'btn btn-outline btn-primary']) . '&nbsp;';
        echo Html::endTag('p');

    }

}
