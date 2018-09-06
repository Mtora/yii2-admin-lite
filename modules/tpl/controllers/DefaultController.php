<?php

namespace app\modules\tpl\controllers;

use Yii;
use yii\web\Controller;

/**
 * Default controller for the `tpl` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $model = new \app\modules\tpl\models\TemplateForm();
        $hobby = ['0' => '篮球', '1' => '足球', '2' => '排球'];
        
        
        return $this->render('index', [
            'model' => $model,
            'hobby' => $hobby,
            'tpl'   => Yii::$app->params['activeFormTpl'],
        ]);
    }
}
