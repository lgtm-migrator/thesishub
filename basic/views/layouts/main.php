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

      <meta name="author" content="Lê Văn Duyệt - 13520171" />
      <meta name="author" content="Trần Thị Huyền Trang - 13520907" />
      <meta name="author" content="Võ Minh Quân - 13520668" />

      <!--
      _____    _______    ____
      |  __ \  |__   __|  / __ \
      | |  | |    | |    | |  | |
      | |  | |    | |    | |  | |
      | |__| |    | |    | |__| |
      |_____/     |_|     \___\_\
                                  Team

      ThesisHub - UIT

      -->

      <?= Html::csrfMetaTags() ?>
        <title data-ng-bind="pageTitle">
          <?= Html::encode($this->title) ?>
        </title>
        <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
        <link href='http://fonts.googleapis.com/css?family=Playfair+Display:400italic' rel='stylesheet' type='text/css'>
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
        <script>
          paceOptions = {
            ajax: {
              trackMethods: ['GET', 'POST']
            }
          };
        </script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.js"></script>
        <link href="//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/red/pace-theme-minimal.css" rel="stylesheet" />
        <?php $this->head() ?>
    </head>

    <body>
      <?php $this->beginBody() ?>
        <div class="wrap" ng-controller="MainController">
          <div class="navbar navbar-inverse">
            <div class="container">
              <div class="row" style="padding-top: 10px">
                <div class="col-md-3 col-xs-4">
                  <a href="#/" title="Trang chủ">
                    <img src="/public/thesishub.png" alt="Khoaluan.vn - Thư viện tài liệu số trực tuyến" style="height: 70px;"></a>
                </div>
                <div class="col-md-9 col-xs-8 no-padding" style="padding-top: 10px;">

                  <form id="userControlHeader_SearchPanel" class="col-md-7 col-xs-7 search-panel-main" ng-submit="doSearch()" >
                    <div class="input-group">
                      <input name="q" ng-model="navbarSearchKeyword" type="text" id="userControlHeader_txtSearch" class="form-control" placeholder="Nhập từ khóa..." style="border: 0px;">
                      <span class="input-group-btn">
                        <a ng-click="doSearch()" id="userControlHeader_btnSearch" class="btn btn-default btn-primary" href="javascript:__doPostBack('ctl00$userControlHeader$btnSearch','')" style="height: 34px;"><span class="glyphicon glyphicon-search"></span></a>
                      </span>
                    </div>
                  </form>
                  <div>

                    <div class="b-header-3">
                      <ul class="b-header-3__user pull-right">

                        <li class="b-header-3__user-name pull-right">
                          <a href="javascript:void(0)" class="b-header-3__user-link clearfix" title="Thông Tin Tài Khoản">
                            <img width="34" height="34" class="b-header-3__user-avatar" src="http://www.khoaluan.vn/Images/Icons/avartar.png" alt="Khoaluan.vn - Thư viện tài liệu số trực tuyến">
                            <ul class="b-header-3__user-text">
                              <li class="b-header-3__user-text-name" ng-hide="loggedIn()"><span class="b-header-3__user-short-name">Đăng nhập</span></li>
                              <li class="b-header-3__user-text-name" ng-show="loggedIn()"><span class="b-header-3__user-short-name">Chào {{getUser().name}}</span></li>
                              <li class="b-header-3__user-text-account"><span>Tài khoản <span class="tk-hidden-md">&amp; thông tin</span></span>
                              </li>
                            </ul>
                            <span class="caret b-header-3__caret"></span>
                          </a>
                          <div class="b-header-3__hover-box custom_hover_box">
                            <ul class="b-header-3__user-dropdown arrow_top">
                              <li id="dd-new-account" class="b-header-3__user-dropdown__item">
                                <div id="socialLoginList" ng-show="loggedIn()" class="ng-hide">
                                  <a href="#/profile" class="user-box-list">&middot; Trang cá nhân</a> <br />
                                  <a href="#/account" class="user-box-list">&middot; Tài liệu của tôi</a> <br />
                                  <a href="#/contact" class="user-box-list">&middot; Liên hệ</a> <br />
                                  <a href="javascript:;" ng-click="logout()"  class="user-box-list text-danger">&middot; Thoát</a>
                                  <br /><hr style="margin-top: 0px;" />
                                  <a href="#/thesis/create" class="btn btn-info">Đăng tải</a>
                                </div>

                                <div class="b-header-3__user-new-account" ng-hide="loggedIn()">
                                  Chưa có tài khoản?
                                  <a href="#/login" title="Tạo tài khoản mới">Tạo tài khoản</a>

                                  <br />
                                  <br />

                                  <a href="#/login" title="Đăng nhập" class="btn btn-info login-btn" style="color:#FFF">Đăng nhập</a>
                                </div>
                              </li>
                              <li class="b-header-3__user-dropdown__item"></li>
                            </ul>
                          </div>
                        </li>
                      </ul>
                    </div>

                  </div>
                </div>
              </div>
            </div>
            <div class="container-fluid no-padding">
              <div class="navbar-collapse menuGradient">
                <ul style="display: inline-block; float: none !important;" class="nav navbar-nav">
                  <li>
                    <a style="min-width: 50px;" href="#/">
                      <img style="vertical-align: top;" src="http://www.khoaluan.vn/Images/Icons/Home.png"></a>
                  </li>

                  <li ng-repeat="dep in departments">
                    <div class="b-header-3 hoverDiv" style="background: transparent;">
                      <ul class="b-header-3__user b-header-3__main-menu-ul pull-right">
                        <li class="b-header-3__user-name">
                          <a class="b-header-3__main-menu-a" ng-href="#/department/{{dep.department_id}}">
                                {{dep.department_name}}
                              </a>
                          <div class="b-header-3__hover-box" style="top: 28px;">
                            <ul class="b-header-3__user-dropdown arrow_top1" style="min-width: 480px; height: 266px; text-align: left;">
                              <li
                                  class="b-header-3__user-dropdown__item"
                                  style="padding-left: 10px; width: 49%; float: left;"
                                  ng-repeat="tag in tagscount" ng-if="tag.department_id == dep.department_id">

                                  <a href="#/search?q={{tag.name}}"
                                  style="border-bottom: 1px solid #eee; margin-bottom: 7px;"
                                  class="b-header-3__user-dropdown__link">
                                  {{tag.name}} <span class="label label-info">{{tag.count}}</span>
                                </a>
                              </li>

                            </ul>
                          </div>
                        </li>
                      </ul>
                    </div>
                    <div class="spaceMenu"></div>
                  </li>
                </ul>
              </div>
            </div>
          </div

                <div class="container">
                  <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    ]) ?>
                    <?= $content ?>
                </div>
        </div>

        <footer class="footer" style="height: 130px;">
          <center>KHOA HỆ THỐNG THÔNG TIN - TRƯỜNG ĐẠI HỌC CÔNG NGHỆ THÔNG TIN</center>
          <center> Địa chỉ : Đại học Công Nghệ Thông Tin, KM20 Xa lộ Hà Nội P.Linh Trung Q.Thủ Đức</center>
          <center>Tp.HCM - ĐT: 083 725 2002 (Ext: 119)</center>
          <center>Email: info.httt@uit.edu.vn</center>
          <center>Phát triển bởi : Khoa Hệ thống thông tin - DTQ.</center>
        </footer>
        <?php $this->endBody() ?>
    </body>

    </html>
    <?php $this->endPage() ?>
