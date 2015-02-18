<?php

namespace pipekung\widgets;

use Yii;
use yii\helpers\Url;
use yii\web\View;

/**
 * Description of TableView
 *
 * @author Pipekung Specialz <chanja@kku.ac.th>
 * @since 2.0
 */
class TableView extends Widget {

    public $data;
    public $column = [];
    public $id;
    public $class = 'table table-bordered table-striped table-hover';
    public $action;
    private $postData = [];

    public function init() {
        parent::init();

        if (isset($this->action)) {
            if (! isset($this->action['headerStyle'])) {
                $this->action['headerStyle'] = 'width: 120px;';
            }

            if (! isset($this->action['style'])) {
                $this->action['style'] = 'text-align: center;';
            }
        } else {
            $this->action = [
                'template' => [
                    'view' => '<a class="btn btn-xs btn-default" href=""><i class="glyphicon glyphicon-th-list"></i></a>',
                    'update' => '<a class="btn btn-xs btn-primary" href=""><i class="glyphicon glyphicon-pencil"></i></a>',
                    'delete' => '<button type="button" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i></button>',
                ],
                'headerStyle' => 'width: 120px;',
                'style' => 'text-align: center;',
            ];
        }
    }

    public function run() {
        $TbHeader = '';
        foreach ($this->column as $val) {
            $headerStyle = isset($val['headerStyle']) ? $val['headerStyle'] : '';
            $TbHeader .= "<th style='{$headerStyle}'>{$val['header']}</th>";
        }
        $TbHeader .= "<th style='{$this->action['headerStyle']}'></th>";

        $TbData = '';
        foreach ($this->data as $val) {
            $TbData .= '<tr>';
            if ($this->action['template']['update']['inline']) $TbData .= $this->renderDataWithUpdate($val);
            else $TbData .= $this->renderData($val);
            $TbData .= "<td style='{$this->action['style']}'>{$this->renderButton($val)}</td></tr>";
        }
        echo "<table class='{$this->class}' id='{$this->id}'>
            <thead>{$TbHeader}</thead>
            <tbody>{$TbData}</tbody>
        </table>";

        $this->js();
    }

    public function renderData($val) {
        $html = '';
        foreach ($this->column as $val2) {
            $style = isset($val2['style']) ? $val2['style'] : '';
            $html .= "<td style='{$style}'>{$val[$val2['value']]}</td>";
        }
        return $html;
    }

    public function renderDataWithUpdate($val) {
        $html = '';
        foreach ($this->column as $val2) {
            $style = isset($val2['style']) ? $val2['style'] : '';
            if (isset($val2['readOnly']) && $val2['readOnly']) {
                $html .= "<td style='{$style}'>{$val[$val2['value']]}</td>";
            } else {
                $html .= "<td style='{$style}'>
                    <span id='{$val['id']}' attr='{$val2['value']}'>{$val[$val2['value']]}</span>
                    <input id='{$val['id']}' type='text' attr='{$val2['value']}' class='form-control input-sm hide' value='{$val[$val2['value']]}' />
                </td>";
                $this->postData[$val2['value']] = "$('input[id='+ id +'][attr={$val2['value']}]').val()";
            }
        }
        return $html;
    }

    public function renderButton($val) {
        if (in_array('view', $this->action['template']) || isset($this->action['template']['view'])) {
            if (is_array($this->action['template']['view'])) 
                return '<a class="btn btn-xs btn-default" href="{{url-to-view}}"><i class="glyphicon glyphicon-th-list"></i></a>';
            else 
                return '<a class="btn btn-xs btn-default" href="{{url-to-view}}"><i class="glyphicon glyphicon-th-list"></i></a>';
        }

        if (in_array('update', $this->action['template']) || isset($this->action['template']['update'])) {
            if (is_array($this->action['template']['update']) && !$this->action['template']['update']['inline']) 
                return '<a class="btn btn-xs btn-primary" href="'. Url::to([$this->action['template']['update']['url'], 'id' => $val['id']]) .'"><i class="glyphicon glyphicon-pencil"></i></a>';
            elseif ($this->action['template']['update']['inline'])
                return $this->renderEditInline($val);
            else 
                return '<a class="btn btn-xs btn-primary" href="'. Url::to(['update', 'id' => $val['id']]) .'"><i class="glyphicon glyphicon-pencil"></i></a>';
        }

        if (in_array('delete', $this->action['template']) || isset($this->action['template']['delete'])) {
            if (is_array($this->action['template']['delete'])) 
                return '<button type="button" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i></button>';
            else 
                return '<button type="button" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i></button>';
        }

        return '';
    }

    public function renderEditInline($val) {
        return '<a class="btn btn-xs btn-primary pk-update-inline" id="'. $val['id'] .'" href="#'. $val['id'] .'"><i class="glyphicon glyphicon-pencil"></i></a>
        <a class="btn btn-xs btn-success pk-confirm-update hide" id="'. $val['id'] .'" href="#'. $val['id'] .'"><i class="glyphicon glyphicon-ok"></i></a>
        ';
    }

    public function js() {
        $postData = '';
        $updateHtml = '';
        foreach ($this->postData as $k => $v) {
            $postData .= "'hr[{$k}]': $v, ";
            $updateHtml .= "$('span[id='+ id +'][attr={$k}]').text($('input[id='+ id +'][attr={$k}]').val());";
        }
        Yii::$app->view->registerJs("
            $(document).on('click', '.pk-update-inline', function() {
                var index = $(this).parent().parent().index()
                ,   id = $(this).attr('id')
                ;
                $('[id='+ id +']').toggleClass('hide');
            });

            $(document).on('click', '.pk-confirm-update', function() {
                var index = $(this).parent().parent().index()
                ,   id = $(this).attr('id')
                ;
                $.ajax({
                    type: 'post',
                    url: '{$this->action['template']['update']['url']}',
                    data: {
                        'hr[id]': id, {$postData}
                    },
                    success: function() {
                        $('[id='+ id +']').toggleClass('hide');
                        {$updateHtml}
                    }
                });
            });
        ", View::POS_END);
    }

}
