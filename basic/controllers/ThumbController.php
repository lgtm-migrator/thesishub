<?php

namespace app\controllers;

class ThumbController extends \app\modules\api\ApiController
{
    public $uploadFolder = '../web/uploads/';

    public function actionIndex($filename) {
      //$source = realpath($source);
      $target = dirname($this->uploadFolder) . DIRECTORY_SEPARATOR . $filename;

      $im     = new Imagick($source."[0]"); // 0-first page, 1-second page
      $im->setImageColorspace(255); // prevent image colors from inverting
      $im->setimageformat("jpeg");
      $im->thumbnailimage(160, 120); // width and height
      $im->writeimage($target);
      $im->clear();
      $im->destroy();
    }

    public function actionFile()
    {
        echo 'ok';
    }

    public function actionImage()
    {
        return $this->render('image');
    }

}
