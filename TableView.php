<?php

namespace pipekung\widgets;

/**
 * Description of TableView
 *
 * @author Pipekung Specialz <chanja@kku.ac.th>
 * @since 2.0
 */
class TableView extends Widget {

    public $data;
    public $column = [];
    public $class = 'table table-bordered table-striped table-hover';

    public function init() {
        parent::init();
    }

    public function run() {
        $TbHeader = '';
        foreach ($this->column as $val) {
            $TbHeader .= "<th>{$val['header']}</th>";
        }
        $TbHeader .= '<th style="width: 80px;"></th>';

        $TbData = '';
        foreach ($this->data as $val) {
            $TbData .= '<tr>';
            foreach ($this->column as $val2) {
                $TbData .= "<td>{$val[$val2['value']]}</td>";
            }
            $TbData .= '<td style="text-align: center;">
                <a class="btn btn-xs btn-primary" href=""><i class="glyphicon glyphicon-pencil"></i></a> 
                <button type="button" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i></button>
            </td>';
            $TbData .= '</tr>';
        }

        echo <<< HTML
<table class="{$this->class}">
    <thead>
        {$TbHeader}
    </thead>
    <tbody>
        {$TbData}
    </tbody>
</table>
HTML;
    }

}
