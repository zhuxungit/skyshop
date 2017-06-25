<?php
namespace app\modules\controllers;

use app\modules\models\Admin;
use Yii;
use yii\web\Controller;
use yii\data\Pagination;

class ManageController extends Controller
{
    /**
     * 接收修改密码邮件参数，并处理
     * @return string
     */
    public function actionMailchangepass()
    {
        $this->layout=false;
        //参数校验
        //http://www.yiishop.com/index.php?r=admin%2Fmanage%2Fmailchangepass&timestamp=1497977993&adminuser=admin&token=d11c1c1594cf312e4d59584f469849ab
        $time = Yii::$app->request->get("timestamp");
        $adminuser = Yii::$app->request->get("adminuser");
        $token = Yii::$app->request->get("token");
        $model = new Admin;

//        var_dump($model);

        $mytoken = $model->createToken($adminuser, $time);
        if ($token != $mytoken) {
            $this->redirect(['public/login']);
            Yii::$app->end();
        }
        //五分钟连接失效
        if (time() - $time > 3600) {
            $this->redirect(['public/login']);
            Yii::$app->end();
        }

        $model->adminuser = $adminuser;

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();

//            echo '<pre>';
//            var_dump($post);die;

            if ($model->changePass($post)){
//                $this->redirect("public/login");
                Yii::$app->session->setFlash('info','密码修改成功');
            }

        }


//        var_dump(Yii::$app->session);

        //验证通过跳转修改密码
//        $model->adminuser = $adminuser;
        return $this->render("mailchangepass",['model'=>$model]);
    }

    /**
     * 管理员列表
     * @return string
     */
    public function actionManagers()
    {
        $this->layout='layout1';

        //分页处理
        $model = Admin::find();
        $count = $model->count();
        //接收配置文件param.php的pageSize
        $pageSize = Yii::$app->params['pageSize']['manage'];

        $pager = new Pagination(['totalCount'=>$count,'pageSize'=>$pageSize]);
        $managers = $model->offset($pager->offset)->limit($pager->limit)->all();

        return $this->render('managers',['managers'=>$managers,'pager'=>$pager]);
    }

    /**
     * 添加管理员
     * @return string
     */
    public function actionReg()
    {
        $this->layout = 'layout1';

        $model = new Admin();

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->reg($post)){
                Yii::$app->session->setFlash('info','添加成功');
            }else{
                Yii::$app->session->setFlash('info','添加失败');
            }
        }

        $model->adminpass = '';
        $model->repass = '';

        return $this->render("reg",['model'=>$model]);
    }

    /**
     * 删除管理员
     */
    public function actionDel()
    {
        $adminid = (int)Yii::$app->request->get('adminid');
        if (empty($adminid)) {
            $this->redirect(['mamage/managers']);
        }
        $model = new Admin();
        if ($model->deleteAll('adminid=:id',[':id'=>$adminid])) {
            Yii::$app->session->setFlash('info','删除成功');
            $this->redirect(['manage/managers']);
        }
    }

    /**
     * 邮件修改密码
     * @return string
     */
    public function actionChangeemail()
    {
        $this->layout = 'layout1';

        $model = Admin::find()->where("adminuser=:user",[':user'=>Yii::$app->session['admin']['adminuser']])->one();

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->changeemail($post)) {
                Yii::$app->session->setFlash('info','修改成功');
            }
        }

        $model->adminpass = '';
        return $this->render('changeemail',['model'=>$model]);
    }

    /**
     * 修改密码
     */
    public function actionChangepass()
    {
        $this->layout = 'layout1';
        $model = Admin::find()->where("adminuser=:user",[':user'=>Yii::$app->session['admin']['adminuser']])->one();
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if($model->changepass($post)) {
                Yii::$app->session->setFlash('info','密码修改成功');
            }
        }

        $model->adminpass = '';
        $model->repass = '';
        return $this->render('changepass',['model'=>$model]);
    }



}