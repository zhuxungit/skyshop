<?php
namespace app\controllers;
use yii\web\Controller;

class ProductController extends Controller
{
    public $layout = false;

    /**
     * 商品列表
     * @return string
     */
    public function actionIndex()
    {
        $this->layout="layout2";
        return $this->render('index');
    }

    public function actionDetail()
    {
        $this->layout="layout2";
        return $this->render('detail');
    }

}