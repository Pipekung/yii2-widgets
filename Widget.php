<?php

namespace pipekung\widgets;

use Yii;
use yii\helpers\Json;

/**
 * @author Pipekung Specialz <chanja@kku.ac.th>
 * @since 2.0
 */
class Widget extends \kartik\widgets\Widget {

    public $options = [];
    public $clientOptions = [];
    public $clientEvents = [];

    public function init() {
        parent::init();
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }
    }

}
