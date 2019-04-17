<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Options;
use yii\web\NotFoundHttpException;

class ImageController extends Controller
{

    /**
     * 单页
     *
     * @param string $name
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView($name)
    {
        $images = Options::getBannersByType($name);
        if (!$images) {
            throw new NotFoundHttpException('None Found');
        }
        return $this->render('view', [
            'images' => $images,
            'tips' => Options::findOne(['name' => $name])->tips,
        ]);
    }

}