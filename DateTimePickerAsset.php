<?php

namespace pipekung\widgets;

/**
 * Asset bundle for RndDateTimePicker Widget
 *
 * @author Pipekung Specialz <chanja@kku.ac.th>
 * @since 2.0
 */
class DateTimePickerAsset extends AssetBundle {

    public function init() {
        $this->setSourcePath('@rnd/lib/datetimepicker');
        $this->setupAssets('css', ['jquery.datetimepicker']);
        $this->setupAssets('js', ['jquery.datetimepicker']);
        parent::init();
    }

}
