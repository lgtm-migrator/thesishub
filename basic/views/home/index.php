<?php
/* @var $this yii\web\View */
$this->title = 'Thesis Hub';
?>
<div class="site-index">
  <div class="jumbotron">
    <h1>Thesis Hub!</h1>
    <p class="lead">You have successfully created your Yii-powered application.</p>
    <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>
  </div>
  <div class="body-content">
  </div>
  <div class="container">
    <div class="panel panel-default">
      <div class="panel-body">A Basic Panel</div>
    </div>

    <div>

    <?php
      foreach ($department as $depart) {
         $txt = '<div>'. $depart->department_name ;
         foreach ($mostIDthesis as $thesis){
            $txt.= '<div>'. $thesis->thesis_name . '</div>';
         }
         $txt.= '</div>';
          echo $txt;
      }
    ?>
    </div>

  </div>
</div>