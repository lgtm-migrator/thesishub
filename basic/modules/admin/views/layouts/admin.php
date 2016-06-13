<?php

use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

$controller = $this->context;
$menus = [
    [ 'label' => 'Home', 'url' => '/admin' ],
    [ 'label' => 'Thesis', 'url' => '/admin/thesis' ],
    [ 'label' => 'Users', 'url' => '/admin/user' ],
    [ 'label' => 'Menu', 'url' => '/system_role/menu' ],
    [ 'label' => 'Roles', 'url' => '/system_role/role' ],
];

$route = $controller->route;
// echo '$route -> ' . $route;
foreach ($menus as $i => $menu) {
    if ($menu['url'] === '/admin') continue;

    $menus[$i]['active'] = strpos('/' . $route, $menu['url']) === 0;
}

$this->params['nav-items'] = $menus;
?>
<?php $this->beginContent($controller->module->mainLayout) ?>
<div class="container">
<div class="row">
    <div class="col-sm-3">
        <div id="manager-menu" class="list-group">
            <?php
            foreach ($menus as $menu) {
                $label = Html::tag('i', '', ['class' => 'glyphicon glyphicon-chevron-right pull-right']) .
                    Html::tag('span', Html::encode($menu['label']), []);
                $active = isset($menu['active']) && $menu['active'] ? ' active' : '';
                echo Html::a($label, $menu['url'], [
                    'class' => 'list-group-item' . $active,
                ]);
            }
            ?>
        </div>
    </div>
    <div class="col-sm-9">
        <?= $content ?>
    </div>
</div>
<?php
list(, $url) = Yii::$app->assetManager->publish('@mdm/admin/assets');
$this->registerCssFile($url . '/list-item.css');
?>
</div>
<?php $this->endContent(); ?>
