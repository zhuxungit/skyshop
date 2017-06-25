<?php

namespace app\controllers;

use yii\web\Controller;
//use app\models\Test;

/**
 * 前台主控制器
 * Class IndexController
 * @package app\controllers
 */
class IndexController extends Controller
{
    /**
     * @return string 返回模板
     */
    public function actionIndex()
    {
        $this->layout = "layout1";
        return $this->render("index");
    }

}
