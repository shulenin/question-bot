<?php

namespace app\controllers;

use Yii;
use app\models\Image;
use yii\web\UploadedFile;

class ImageController extends HookController
{
    /**
     * @return string
     */
    public function actionAddForm(): string
    {
        $model = new Image();
        $array = Image::getAll();

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $model->img = UploadedFile::getInstance($model, 'img');
            $model->img->saveAs("uploads/{$model->img->baseName}.{$model->img->extension}");
            $model->save(false);
            header("Refresh: 5");
        }
        return $this->render('add-form', ['model'=>$model, 'array' => $array]);
    }
}
