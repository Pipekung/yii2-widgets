<?php

namespace pipekung\widgets;

use yii\jui\InputWidget;

class Dates extends InputWidget {

    public $form;
    public $model;
    public $attribute;
    public $class;
    public $language;
    public $isDefault = false;
    public $addDates = '';
    public $options = [];
    public $htmlOptions = [];

    /**
     * @var string The i18n Jquery UI script file. It uses scriptUrl property as
     * base url.
     */
    public $i18nScriptFile = 'jquery-ui-i18n.min.js';

    /**
     * @var array The default options called just one time per request. This
     * options will alter every other CJuiDatePicker instance in the page.
     * It has to be set at the first call of CJuiDatePicker widget in the
     * request.
     */
    public $defaultOptions;

    /**
     * @var boolean If true, shows the widget as an inline calendar and the input
     * as a hidden field.
     */
    public $flat = false;

    /**
     * Run this widget.
     * This method registers necessary javascript and renders the needed HTML
     * code.
     */
    public function run() {


        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }
        $this->htmlOptions['id'] = $id = $this->options['id'];

        $view = $this->getView();
        RndDatesAsset::register($view);



        echo '<div id="hrvacationtype-name2" class="box"></div>';
        // echo $this->form->field($this->model, $this->attribute, array(
//             'class' => $this->class,
//             'readonly' => true,
//             'style' => 'background-color:#FFF;',
//         ));


        echo $this->form->field($this->model, 'name')->textInput(['maxlength' => 150]);
        $clientId = 'hrvacationtype-name'; //get_class($this->model) . '_' . $this->attribute;
//        if ($this->addDates != "") {
//            $dates = explode(',', $this->addDates);
//            $this->addDates = "";
//            foreach ($dates as $value) {
//                $this->addDates.="'" . $value . "',";
//            }
//
//            $js = "
//                      jQuery('#" . $clientId . "').multiDatesPicker(
//                      {
//                        dateFormat: 'yy-mm-dd', 
//                        beforeShowDay: $.datepicker.noWeekends,
//                        addDates: [" . $this->addDates . "]
//                      });";
//        } else {
//
//            $js = "
//                      jQuery('#" . $clientId . "').multiDatesPicker(
//                      {
//                        dateFormat: 'yy-mm-dd',                        
//                      });";
//        }



        $js = "
                      $('#hrvacationtype-name2').datepick(
{
multiSelect: 999, monthsToShow: 1, monthsToStep: 2, 
    prevText: 'Prev', nextText: 'Next',
    renderer: $.datepick.themeRollerRenderer
}                      
);";

//        $js="jQuery('#" . $clientId . "').datepicker(
//                      {
//                        dateFormat: 'yy-mm-dd',                        
//                      });";
//        $js.='
//                        $("#' . $clientId . '").keypress(function(e){
//                                if (e.keyCode === 8) {
//                                return false;
//                            };
//                        });                        
//                  
//                ';
        //Multi-language support required 
        //https://github.com/dubrox/Multiple-Dates-Picker-for-jQuery-UI/issues/61
        //
            //$.datepicker.setDefaults($.datepicker.regional["th"]);
        //$("#' . $clientId . '").datepicker("refresh"); 
        //$cs = Yii::app()->getClientScript();
        //$cs->registerScript(__CLASS__ . '#' . $this->id, $js, CClientScript::POS_READY);

        $view->registerJs($js);
    }

}

?>
