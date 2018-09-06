<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "login_count".
 *
 * @property integer $id
 * @property string $content
 * @property integer $type
 * @property integer $count
 */
class LoginCount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'login_count';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'count'], 'integer'],
            [['content'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => 'Content',
            'type' => 'Type',
            'count' => 'Count',
        ];
    }
}
