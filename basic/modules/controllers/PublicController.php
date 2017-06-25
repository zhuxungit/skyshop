<?php
namespace app\modules\controllers;

use Yii;
use yii\web\Controller;
use app\modules\models\Admin;

/**
 * Class PublicController
 * @package app\modules\controllers
 */
class PublicController extends Controller
{
    /**
     * 登录
     */
    public function actionLogin()
    {
        $this->layout = false;
        $model = new Admin;
        //判断是否是post提交数据
        if (Yii::$app->request->isPost) {
            //获取post提交的数据
            $post = Yii::$app->request->post();
//            var_dump($post);
            if ($model->login($post)) {
                $this->redirect(["default/index"]);
                Yii::$app->end();
            }
        }
        return $this->render("login", ['model' => $model]);
    }

    /**
     * 登出
     */
    public function actionLogout()
    {
        //清除session
        Yii::$app->session->removeAll();
        if (!isset(Yii::$app->session['admin']['isLogin'])) {
            $this->redirect(['public/login']);
            Yii::$app->end();
        }
        //跳回原页面
        $this->goBack();
    }

    /**
     * 通过邮件找回密码
     */
    public function actionSeekpassword()
    {
        $this->layout = false;
        $model = new Admin();
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();

//                        echo '<pre>';
//            var_dump($post);die;


            if ($model->seekPass($post)){
                Yii::$app->session->setFlash('info','电子邮箱已经发送成功，请查收');
            }



        }


        return $this->render("seekpassword",['model'=>$model]);
    }

}