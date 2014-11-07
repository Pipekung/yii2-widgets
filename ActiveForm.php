<?php

namespace pipekung\widgets;

use yii\base\InvalidConfigException;
use yii\helpers\Html;
use kartik\widgets\ActiveFormAsset;
use kartik\widgets\ActiveField;

/**
 * Extends the ActiveForm widget to handle various
 * bootstrap form types.
 *
 * Example(s):
 * ```php
 * // Horizontal Form
 * $form = ActiveForm::begin([
 *      'id' => 'form-signup',
 *      'type' => ActiveForm::TYPE_HORIZONTAL
 * ]);
 * // Inline Form
 * $form = ActiveForm::begin([
 *      'id' => 'form-login',
 *      'type' => ActiveForm::TYPE_INLINE
 *      'fieldConfig' => ['autoPlaceholder'=>true]
 * ]);
 * // Horizontal Form Configuration
 * $form = ActiveForm::begin([
 *      'id' => 'form-signup',
 *      'type' => ActiveForm::TYPE_HORIZONTAL
 *      'formConfig' => ['labelSpan' => 2, 'deviceSize' => ActiveForm::SIZE_SMALL]
 * ]);
 *
 * @author Pipekung Specialz <chanja@kku.ac.th>
 * @since 2.0
 */
class ActiveForm extends \kartik\widgets\ActiveForm {

    public function init() {
        parent::init();
    }

}
