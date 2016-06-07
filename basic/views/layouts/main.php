<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use mdm\admin\components\MenuHelper;
use mdm\admin\components\Helper;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" data-ng-app="app">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title data-ng-bind="pageTitle"><?= Html::encode($this->title) ?></title>

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,400italic,500,700,900' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Playfair+Display:400italic' rel='stylesheet' type='text/css'>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

    <script>paceOptions = {ajax: {trackMethods: ['GET', 'POST']}};</script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.js"></script>
    <link href="//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/red/pace-theme-minimal.css" rel="stylesheet" />

    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap" ng-controller="MainController">
    <?php
    NavBar::begin([
        'brandLabel' => 'ThesisHub',
        'brandUrl' => '#/',
        'options' => [
            'class' => 'navbar navbar-default sticky-nav',
        ],
    ]);

    ?>

    <form class="navbar-form navbar-left" role="search" action="/search">
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Search" name="q" />
        </div>
    </form>

    <?php

    // echo Nav::widget([
    //     'options' => ['class' => 'nav navbar-nav navbar-right'],
    //     'items' =>  [
    //         ['label' => 'Home', 'url' => ['/site/index']],
    //         ['label' => 'Thesis', 'url' => ['/thesis']],
    //         ['label' => 'Admin', 'url' => ['/admin']],
    //         ['label' => 'Contact', 'url' => ['/site/contact']],
            
    //         Yii::$app->user->isGuest ? (
    //             ['label' => 'Login', 'url' => ['/auth/login']]
    //         ) : (

    //             ['label' => 'Logout (' . Yii::$app->user->identity->username . ')', 'url' => ['/auth/logout']]

    //             // '<li>'
    //             // . Html::beginForm(['/auth/logout'], 'post')
    //             // . Html::submitButton(
    //             //     'Logout (' . Yii::$app->user->identity->username . ')',
    //             //     ['class' => 'btn btn-link']
    //             // )
    //             // . Html::endForm()
    //             // . '</li>'
    //         )
    //     ],
    // ]);
    
    $menuItems = [
            ['label' => '', 'url' => ['/site/index']],
            ['label' => 'Thesis', 'url' => ['/']],
            ['label' => 'Admin', 'url' => ['/admin']],
            ['label' => 'Contact', 'url' => ['/site/contact']],
            
            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/auth/login']]
            ) : (

                ['label' => 'Logout (' . Yii::$app->user->identity->username . ')', 'url' => ['/auth/logout']]

                // '<li>'
                // . Html::beginForm(['/auth/logout'], 'post')
                // . Html::submitButton(
                //     'Logout (' . Yii::$app->user->identity->username . ')',
                //     ['class' => 'btn btn-link']
                // )
                // . Html::endForm()
                // . '</li>'
            )
        ];

    // $menuItems = Helper::filter($menuItems);

    // echo Nav::widget([
    //     'options' => ['class' => 'nav navbar-nav navbar-right'],
    //     'items' => $menuItems,
    // ]);
    
    ?>

        <ul class="nav navbar-nav navbar-right">
            <li data-match-route="/$">
                <a href="#/">Home</a>
            </li>
            <li data-match-route="/thesis">
                <a href="#/thesis">Thesis</a>
            </li>
            <li data-match-route="/contact">
                <a href="#/contact">Contact</a>
            </li>
            <li data-match-route="/dashboard" ng-show="loggedIn()" class="ng-hide">
                <a href="#/dashboard">Dashboard</a>
            </li>
            <li ng-class="{active:isActive('/logout')}" ng-show="loggedIn()" ng-click="logout()"  class="ng-hide">
                <a href="">Logout</a>
            </li>
            <li data-match-route="/login" ng-hide="loggedIn()">
                <a href="#/login">Login</a>
            </li>
        </ul>

    <?php

    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Thesis Hub <?= date('Y') ?></p>

        <p class="pull-right">
            <a href="/admin">/admin</a>
            <?= Yii::powered() ?>
        </p>
    </div>
</footer>

<?php $this->endBody() ?>


</body>
</html>
<?php $this->endPage() ?>
