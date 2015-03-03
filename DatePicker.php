<?php

namespace pipekung\widgets;

use Yii;
use yii\web\View;

/**
 * Description of DatePicker
 *
 * @author Pipekung Specialz <chanja@kku.ac.th>
 * @since 2.0
 */
class DatePicker extends Widget {

	public $model;
	public $form;
	public $name;
	public $attr;
	public $options = [];
	public $between = [];
	public $disabledDate = [];
	protected $label = [];
	protected $element = [];

	public function init() {
		parent::init();

		if (!empty($this->between)) {
			$this->label[0] = $this->model->getAttributeLabel($this->between[0]);
			$this->element[0] = "#" . self::getClassName($this->model) . "-{$this->between[0]}";

			$this->label[1] = $this->model->getAttributeLabel($this->between[1]);
			$this->element[1] = "#" . self::getClassName($this->model) . "-{$this->between[1]}";
		} else {
			$this->label[0] = $this->model->getAttributeLabel($this->attr);
			$this->element[0] = "#" . self::getClassName($this->model) . "-{$this->attr}";
		}

		$this->options = array_merge($this->options, [
			'changeMonth' => true,
			'changeYear' => true,
			'hideIfNoPrevNext' => true,
			'showButtonPanel' => true,
			'monthNamesShort' => ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
			'dateFormat' => 'dd-mm-yy',
		]);
	}

	public function run() {
		if (!empty($this->between)) {
			\yii\jui\DatePicker::widget(['model' => $this->model, 'attribute' => $this->between[0]]);
			echo $this->form->field($this->model, $this->between[0], [
				'addon' => [
					'prepend' => ['content' => '<i class="glyphicon glyphicon-calendar"></i>'],
					'groupOptions' => ['class' => 'col-sm-4'],
				],
			])->textInput(['readonly' => 'readonly', 'placeholder' => "คลิกเลือก {$this->label[0]}"]);

			\yii\jui\DatePicker::widget(['model' => $this->model, 'attribute' => $this->between[1]]);
			echo $this->form->field($this->model, $this->between[1], [
				'addon' => [
					'prepend' => ['content' => '<i class="glyphicon glyphicon-calendar"></i>'],
					'groupOptions' => ['class' => 'col-sm-4'],
				],
			])->textInput(['readonly' => 'readonly', 'placeholder' => "คลิกเลือก {$this->label[1]}"]);
		} else {
			\yii\jui\DatePicker::widget(['model' => $this->model, 'attribute' => $this->attr]);
			echo $this->form->field($this->model, $this->attr, [
				'addon' => [
					'prepend' => ['content' => '<i class="glyphicon glyphicon-calendar"></i>'],
					'groupOptions' => ['class' => 'col-sm-4'],
				],
			])->textInput(['readonly' => 'readonly', 'placeholder' => "คลิกเลือก {$this->label[0]}"]);
		}
		$this->js();
	}

	public function js() {
		$options = json_encode($this->options);
		if (!empty($this->between)) {
			Yii::$app->view->registerJs("
                $('{$this->element[0]}').datepicker({$options});
                $('{$this->element[1]}').datepicker({$options});
                $('{$this->element[0]}').datepicker('option', 'onSelect', function( selectedDate ) { $('{$this->element[1]}').datepicker('option', 'minDate', selectedDate); calculateDate(); });
                $('{$this->element[1]}').datepicker('option', 'onSelect', function( selectedDate ) { $('{$this->element[0]}').datepicker('option', 'maxDate', selectedDate); calculateDate(); });

                var disabledDate = ['" . implode("', '", $this->disabledDate) . "'];
                $('{$this->element[0]}').datepicker('option', 'beforeShowDay', function(date) {
                    var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
                    return [ disabledDate.indexOf(string) == -1 ];
                });
                $('{$this->element[1]}').datepicker('option', 'beforeShowDay', function(date) {
                    var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
                    return [ disabledDate.indexOf(string) == -1 ];
                });
            ", View::POS_END);
		} else {
			Yii::$app->view->registerJs("$('{$this->element[0]}').datepicker({$options});", View::POS_END);
			Yii::$app->view->registerJs("
                $('{$this->element[0]}').datepicker('option', 'onSelect', function() { calculateDate(); });

                var disabledDate = ['" . implode("', '", $this->disabledDate) . "'];
                $('{$this->element[0]}').datepicker('option', 'beforeShowDay', function(date) {
                    var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
                    return [ disabledDate.indexOf(string) == -1 ];
                });
            ", View::POS_END);
		}
	}

	public static function getClassName($model) {
		$model = get_class($model);
		$model = explode('\\', $model);
		$model = $model[count($model) - 1];
		return strtolower($model);
	}

}
