<?php
namespace app\models;
use yii\db\ActiveRecord;

class Test extends ActiveRecord
{
    public static function tableName()
    {
//        return parent::tableName(); // TODO: Change the autogenerated stub
        return "{{%test}}";
    }
}