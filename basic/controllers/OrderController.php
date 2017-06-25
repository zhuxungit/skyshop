<?php
namespace app\controllers;

use yii\web\Controller;

/**
 * 收银台
 * Class OrderController
 * @package app\controllers
 */
class OrderController extends Controller
{
//    public $layout = false;

    /**
     * 收银台页面
     * @return string
     */
    public function actionCheck()
    {
        $this->layout = "layout1";
        return $this->render("check");
    }

    /**
     * 用户订单中心
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = "layout2";
        return $this->render("index");
    }


}