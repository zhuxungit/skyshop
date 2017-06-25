<?php
namespace app\models;
use yii\db\ActiveRecord;

/**
 * 商品模型类
 * Class Product
 * @package app\models
 */
class Product extends ActiveRecord
{
    //七牛参数
    const AK = 'PK1e1WmCk5jP-UNga-ngNTAq272-_xpQ_2dweTM-';
    const SK = '8UWdCnqkostNvISWMmxJOy1C6DVR82urKnvMJg6a';
    const DOMAIN = 'os2v0d1yw.bkt.clouddn.com';
    const BUCKET = 'sky-shop';

    public function rules()
    {
        return [
            ['title','required','message'=>'标题不能为空'],
            ['descr','required','message'=>'描述不能为空'],
            ['cateid','required','message'=>'商品分类必须选择'],
            ['price','required','message'=>'单价不能为空'],
            [['price','saleprice'],'number','min'=>0.01,'message'=>'价格必须是正数'],
            ['num','integer','min'=>0,'message'=>'库存必须是非负整数'],
            [['issale','ishot','pics','istui'],'safe'],
            [['cover'],'required','message'=>'封面图片必须选择']
        ];
    }

    public function attributeLabels()
    {
        return [
            'cateid' => '分类名称',
            'title'  => '商品名称',
            'descr'  => '商品描述',
            'price'  => '商品价格',
            'ishot'  => '是否热卖',
            'issale' => '是否促销',
            'saleprice' => '促销价格',
            'num'    => '库存',
            'cover'  => '图片封面',
            'pics'   => '商品图片',
            'ison'   => '是否上架',
            'istui'   => '是否推荐',
        ];
    }


    public static function tableName()
    {
        return "{{%product}}";
    }

    /**
     * 添加商品
     * @param $data
     * @return bool
     */
    public function add($data)
    {
        if ($this->load($data) && $this->save()) {
            return true;
        }
        return false;
    }

//    public function getProfile()
//    {
//        //一对一的关联hasOne,一对多的关联hasMany，
//        //第一个参数为要关联的子表模型的类名
//        //第二个参数为子表的userid关联主表的userid
//        return $this->hasOne(Profile::className(),['userid'=>'userid']);
//    }

public function getCategory()
{
    return $this->hasOne(Category::className(),['cateid'=>'cateid']);
}


}