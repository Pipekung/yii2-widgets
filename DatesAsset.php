<?php

namespace pipekung\widgets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class DatesAsset extends AssetBundle {

     public $sourcePath = '@rnd/lib/datepick';
     public $css = ['jquery.datepick.css','ui-cupertino.datepick.css'];
     public $js = ['jquery.plugin.min.js','jquery.datepick.js','jquery.datepick.ext.js'];
     public $depends = [
         //'yii\web\YiiAsset',
         //'yii\jui\DatePickerAsset',
         'yii\jui\ThemeAsset',
         //'yii\jui\DatePickerRegionalAsset'
     ];

}
