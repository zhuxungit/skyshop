<?php
namespace app\controllers;

use yii\web\Controller;

/**
 * 购物车类
 * Class CartController
 * @package app\controllers
 */
class CartController extends Controller
{
//    public $layout = false;

    public function actionIndex()
    {
        $this->layout = 'layout1';
        return $this->render('index');
    }
}