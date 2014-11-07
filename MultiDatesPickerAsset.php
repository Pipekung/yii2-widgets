<?php

namespace pipekung\widgets;

use yii\web\AssetBundle;

/**
 * Asset bundle for RndMultiDatesPicker Widget
 *
 * @author Pipekung Specialz <chanja@kku.ac.th>
 * @since 2.0
 */
class MultiDatesPickerAsset extends AssetBundle {

    public $depends = [
        'yii\web\YiiAsset',
        'yii\jui\DatePickerAsset',
    ];
    
    public function init() {
        $this->setSourcePath('@rnd/lib/multidatespicker');
        $this->setupAssets('css', ['mdp', 'jquery-ui']);
        $this->setupAssets('js', ['jquery-ui.multidatespicker', 'ui.datepicker-th']);
        parent::init();
    }

}
