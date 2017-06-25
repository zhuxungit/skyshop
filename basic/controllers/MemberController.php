<?php
namespace app\controllers;

use Yii;
use app\models\User;
use yii\web\Controller;

/**
 * Class MemberController
 * @package app\controllers
 */
class MemberController extends Controller
{
    /**
     * 登录注册页面
     * @return string
     */
    public function actionAuth()
    {
        $this->layout = "layout2";
        $model = new User();
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->login($post)) {
                $this->redirect(["index/index"]);
                Yii::$app->end();
            }
        }

        $model->userpass = '';
        return $this->render("auth", ['model' => $model]);
    }

    /**
     * 注册
     */
    public function actionReg()
    {
        $this->layout = 'layout2';
        $model = new User();
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->regByMail($post)) {
                Yii::$app->session->setFlash('info', '电子邮件发送成功');
            }
        }
        return $this->render('auth', ['model' => $model]);
    }

    /**
     * 登出
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->session->remove('username');
        Yii::$app->session->remove('isLogin');
        if (isset(Yii::$app->session['isLogin'])) {
            return $this->goBack(Yii::$app->request->referrer);
        }

    }

}