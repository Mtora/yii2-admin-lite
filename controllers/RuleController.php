<?php
namespace app\controllers;

use app\models\AuthRule;
use app\models\LoginCount;
use Yii;
use yii\data\Pagination;

use app\models\User;

class RuleController extends CmController
{
    public function actionIndex() {

        $query = AuthRule::find();
        $pagination = new Pagination(['totalCount' => $query->count(), 'pageSize' => Yii::$app->params['page_size']]);
        $rules = $query->offset($pagination->offset)->limit($pagination->limit)->all();

        return $this->render('index', [
            'models' => $rules,
            'pagination' => $pagination,
        ]);
    }
}
