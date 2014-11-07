<?php

namespace pipekung\widgets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class DatesPickerAsset extends AssetBundle {

//public function init() {
//        $this->setSourcePath('@rnd/lib/multidatespicker');
//        $this->setupAssets('css', ['mdp.css', 'pepper-ginder-custom.css']);
//        $this->setupAssets('js', ['jquery-ui.multidatespicker.js']);
//        parent::init();
//    }
     public $sourcePath = '@rnd/lib/multidatespicker';
     public $css = ['mdp.css', 'pepper-ginder-custom.css'];
     public $js = ['jquery-ui.multidatespicker.js','ui.datepicker-th.js'];
     public $depends = [
         'yii\web\YiiAsset',
         'yii\jui\DatePickerAsset',
         //'yii\jui\DatePickerRegionalAsset'
     ];

}
