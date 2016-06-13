<?php

namespace app\controllers;

class UploadController extends \app\modules\api\ApiController
{
    public $uploadFolder = '../web/uploads/';

    private function to_slug($str) {
        $str = trim(mb_strtolower($str));
        $str = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str);
        $str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str);
        $str = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $str);
        $str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str);
        $str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str);
        $str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str);
        $str = preg_replace('/(đ)/', 'd', $str);
        $str = preg_replace('/[^a-z0-9-\s\.]/', '', $str);
        $str = preg_replace('/([\s]+)/', '-', $str);
        return $str;
    }

    public function actionFile()
    {
        return $this->render('file');
    }

    public function actionImage()
    {
        return $this->render('image');
    }

    public function actionIndex()
    {

        if ($_FILES AND $_FILES['file']) {
            // TODO: Check file type, file size, ...

            $fileName = $this->to_slug($_FILES['file']['name']);
            $filePath = $this->uploadFolder . $fileName;

            if (move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {
                // convert
                exec("convert {$filePath}[0] {$this->uploadFolder}/thumbs/{$fileName}.png");
                return [
                    'error' => false,
                    'message' => 'Success',
                    'code' => 200,
                    'data' => [
                        'name' => $fileName,
                        'url' => '/uploads/' . $fileName,
                        'type' => $_FILES['file']['type']
                    ]
                ];
            }

            return [
                'error' => true,
                'message' => 'Fail to upload',
                'code' => 500
            ];
        }
    }

}
