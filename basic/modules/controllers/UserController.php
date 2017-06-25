<?php
namespace app\modules\controllers;

use app\models\Profile;
use app\models\User;
use PHPUnit\Framework\Exception;
use Symfony\Component\DomCrawler\Field\InputFormField;
use Yii;
use yii\web\Controller;
use yii\data\Pagination;

class UserController extends Controller
{

    /**
     * 用户登录
     */
    public function actionAuth()
    {
        $this->layout = 'layout2';
        $model = new User();
        if (Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            if ($model->login($post)) {
                return $this->goBack(Yii::$app->request->referrer);
            }
        }
        return $this->render('auth',['model'=>$model]);
    }

    public function actionLogout()
    {
        Yii::$app->session->remove('loginname');
        Yii::$app->session->remove('isLogin');
        if (!isset(Yii::$app->session['isLogin'])) {
            return $this->goBack(Yii::$app->request->referrer);
        }
    }

    /**
     * 用户列表
     */
    public function actionUsers()
    {
        $this->layout = 'layout1';

        //在模型中存在对应的getProfile方法，实现关联查询
        $model = User::find()->joinWith('profile');

        //实现分页
        $count = $model->count();
        $pageSize = Yii::$app->params['pageSize']['user'];

        $pager = new Pagination(['totalCount'=>$count,'pageSize'=>$pageSize]);
        $users = $model->offset($pager->offset)->limit($pager->limit)->all();

        return $this->render('users',['users'=>$users,'pager'=>$pager]);
    }

    /**
     * 添加用户
     */
    public function actionReg()
    {
        $this->layout = 'layout1';
        $model = new User();
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->reg($post)) {
                Yii::$app->session->setFlash('info','添加成功');
            }
        }

        $model->userpass = '';
        $model->repass = '';
        return $this->render('reg',['model'=>$model]);
    }

    /**
     * 删除用户表同时也要删除用户信息表，使用事物
     */
    public function actionDel()
    {
//        var_dump((int)Yii::$app->request->get('userid'));die;
        try{
            $userid = (int)Yii::$app->request->get('userid');
            //如果userid没有获取到抛出异常
            if (empty($userid)) {
                throw new \Exception();
            }
            //打开实务
            $trans = Yii::$app->db->beginTransaction();
            //删除profile表失败抛出异常
            if($obj = Profile::find()->where("userid=:id",[':id'=>$userid])->all()){
                $res =  Profile::deleteAll('userid=:id',[':id'=>$userid]);
                if (empty($res)) {
                    throw new \Exception();
                }
            }
            //删除user表失败抛出异常
            if (!User::deleteAll('userid=:id',[':id'=>$userid])) {
                throw new \Exception();
            }
            //没有抛出异常则提交
            $trans->commit();
        }catch (\Exception $e) {
            //如果有异常,回滚
            if (Yii::$app->db->getTransaction()) {
                $trans->rollBack();
            }
        }
        $this->redirect(['user/users']);
    }




}