<?php

namespace pipekung\widgets;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Description of CollapseMenu
 * 
 * For example:
 *
 * echo CollapseMenu::widget([
 *     'items' => [
 *         'Collapsible Group Item #1' => [
 *             'items' => [
 *                  ['label' => '...', 'url' => ['...'], 'options' => ['...']],
 *                  ['label' => '...', 'url' => ['...'], 'options' => ['...']],
 *             ],
 *             'contentOptions' => ['class' => 'in']
 *         ],
 *         'Collapsible Group Item #2' => [
 *             'items' => [
 *                  ['label' => '...', 'url' => ['...'], 'options' => ['...']],
 *                  ['label' => '...', 'url' => ['...'], 'options' => ['...']],
 *             ],
 *             'contentOptions' => [...],
 *             'options' => [...],
 *         ],
 *     ]
 * ]);
 * ```
 *
 * @author Pipekung Specialz <chanja@kku.ac.th>
 * @since 2.0
 */
class CollapseMenu extends Widget {

    public $items = [];

    public function init() {
        parent::init();
        Html::addCssClass($this->options, 'panel-group');
    }

    public function run() {
        echo Html::beginTag('div', $this->options) . "\n";
        echo $this->renderItems() . "\n";
        echo Html::endTag('div') . "\n";
        //$this->registerPlugin('collapse');
        $this->registerScript();
    }

    public function renderItems() {
        $items = [];
        $index = 0;
        foreach ($this->items as $header => $item) {
            $options = ArrayHelper::getValue($item, 'options', []);
            Html::addCssClass($options, 'panel panel-default');
            $items[] = Html::tag('div', $this->renderItem($header, $item, ++$index), $options);
        }

        return implode("\n", $items);
    }

    public function renderItem($header, $item, $index) {
        if (isset($item['items'])) {
            $id = $this->options['id'] . '-collapse' . $index;
            $options = ArrayHelper::getValue($item, 'contentOptions', []);
            $options['id'] = $id;
            Html::addCssClass($options, 'panel-collapse collapse');

            $headerToggle = Html::tag('h4', $header . '<i class="glyphicon glyphicon-collapse-down pull-right"></i>', ['class' => 'panel-title', 'style' => 'padding: 10px 15px;']);

            $header = Html::a($headerToggle, '#' . $id, [
                        'class' => 'collapse-toggle',
                        'data-toggle' => 'collapse',
                        'data-parent' => '#' . $this->options['id']
                    ]) . "\n";

            $menuItems = '';
            foreach ($item['items'] as $menuItem) {
                if (isset($menuItem['options'])) {
                    if (isset($menuItem['options']['style'])) {
                        $menuItem['options']['style'] .= 'border-radius: 0;';
                    } else {
                        $menuItem['options']['style'] = 'border-radius: 0;';
                    }
                } else {
                    $menuItem['options']['style'] = 'border-radius: 0;';
                }

                if (!isset($menuItem['visible']) || $menuItem['visible']) {
                    $link = Html::a($menuItem['label'] . ' <i class="glyphicon glyphicon-chevron-right pull-right"></i>', $menuItem['url'], $menuItem['options']);
                    $menuItems .= Html::tag('li', $link, ['class' => (isset($menuItem['active']) && $menuItem['active']) ? 'active' : '']) . "\n";
                }
            }

            $listMenu = Html::tag('ul', $menuItems, ['class' => 'nav nav-pills nav-stacked']) . "\n";
        } else {
            throw new InvalidConfigException('The "content" option is required.');
        }
        $group = [];

        $group[] = Html::tag('div', $header, ['class' => 'panel-heading', 'style' => 'padding: 0;']);
        $group[] = Html::tag('div', $listMenu, $options);

        return implode("\n", $group);
    }

    public function registerScript() {
        $id = $this->options['id'];
        Yii::$app->view->registerJs("
        $(document).ready(function() {
            $('#$id li.active').parent().parent().addClass('in');
        });
        ");
    }

}
