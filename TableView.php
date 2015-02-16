<?php

namespace pipekung\widgets;

use Yii;
use yii\helpers\Url;

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
            $TbHeader .= "<th>{$val['header']}</th>";
        }
        $TbHeader .= "<th style='{$this->action['headerStyle']}'></th>";

        $TbData = '';
        foreach ($this->data as $val) {
            $TbData .= '<tr>';
            foreach ($this->column as $val2) {
                $TbData .= "<td>{$val[$val2['value']]}</td>";
            }
            $TbData .= "<td style='{$this->action['style']}'>";
            if (in_array('view', $this->action['template']) || isset($this->action['template']['view'])) {
                if (is_array($this->action['template']['view'])) 
                    $TbData .= '<a class="btn btn-xs btn-default" href="{{url-to-view}}"><i class="glyphicon glyphicon-th-list"></i></a>';
                else 
                    $TbData .= '<a class="btn btn-xs btn-default" href="{{url-to-view}}"><i class="glyphicon glyphicon-th-list"></i></a>';
            } else $TbData .= '';

            if (in_array('update', $this->action['template']) || isset($this->action['template']['update'])) {
                if (is_array($this->action['template']['update'])) 
                    $TbData .= '<a class="btn btn-xs btn-primary" href="'. Url::to([$this->action['template']['update']['url'], 'id' => $val['id']]) .'"><i class="glyphicon glyphicon-pencil"></i></a>';
                else 
                    $TbData .= '<a class="btn btn-xs btn-primary" href="'. Url::to(['update', 'id' => $val['id']]) .'"><i class="glyphicon glyphicon-pencil"></i></a>';
            } else $TbData .= '';

            if (in_array('delete', $this->action['template']) || isset($this->action['template']['delete'])) {
                if (is_array($this->action['template']['delete'])) 
                    $TbData .= '<button type="button" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i></button>';
                else 
                    $TbData .= '<button type="button" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i></button>';
            } else $TbData .= '';

            $TbData .= '</td></tr>';
        }
        echo "<table class='{$this->class}' id='{$this->id}'>
            <thead>{$TbHeader}</thead>
            <tbody>{$TbData}</tbody>
        </table>";
    }

}
