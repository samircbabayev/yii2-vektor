<?php

namespace common\widgets;

use yii\base\Widget;
use common\models\Category;
use Yii;
use yii\helpers\ArrayHelper;

class MenuWidget extends Widget
{
  public $tpl;
  public $data; // массив категорий из бд
  public $tree; // результат работы функции, массив дерева
  public $menuHtml; // готовая разметка
  public $model; // модель текущей категории при отрисовке селекта

  public function init()
  {
    parent::init();
    if ($this->tpl === null) {
      $this->tpl = 'menu';
    }
    $this->tpl .= '.php';
  }

  public function run()
  {
    // get cache
    // if ($this->tpl == 'menu.php') {
    //   $menu = \Yii::$app->cache->get('menu');
    //   if ($menu) {
    //     return $menu;
    //   }
    // }

    $this->data = Category::find()->indexBy('id')->all();

    foreach ($this->data as $x) {
      $this->data[$x['id']]['name'] = $this->data[$x['id']]->translation['name'];;
    }

    $this->data = ArrayHelper::toArray($this->data);

    $this->tree = $this->getTree();

    $this->menuHtml = $this->getMenuHtml($this->tree);
    // // set cache
    // if ($this->tpl == 'menu.php') {
    //   \Yii::$app->cache->set('menu', $this->menuHtml, 60);
    // }

    return $this->menuHtml;
  }


  protected function getTree()
  {
    $tree = [];
    foreach ($this->data as $id => &$node) {
      if (!$node['parent_id']) {
        $tree[$id] = &$node;
        $tree[$id]['name'] = \Yii::t('app', $tree[$id]['name']);
      } else {
        $this->data[$node['parent_id']]['childs'][$node['id']] = &$node;
      }
    }

    return $tree;
  }

  protected function getMenuHtml($tree, $tab = '', $i = 0)
  {
    $str = '';
    foreach ($tree as $category) {
      $str .= $this->catToTemplate($category, $tab, $i);
    }

    return $str;
  }

  protected function catToTemplate($category, $tab, $i)
  {
    ob_start();
    include __DIR__ . '/menu_tpl/' . $this->tpl;

    return ob_get_clean();
  }
}
