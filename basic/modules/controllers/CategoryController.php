<?php
namespace app\modules\controllers;

use app\models\Category;
use PHPUnit\Framework\Exception;
use yii\data\Pagination;
use yii\web\Controller;
use Yii;

class CategoryController extends Controller
{
    /**
     * 分裂列表
     * @return string
     */
    public function actionList()
    {
        $this->layout = 'layout1';
        $model = new Category();
//        $pagesize = Yii::$app->params['pageSize']['category'];
//        $count = $model->count();
//        $pager = new Pagination(['pageSize'=>$pagesize,'totleCount'=>$count]);
        $cates = $model->getOptions();
        unset($cates[0]);
        return $this->render('cates', ['cates' => $cates]);
    }

    /**
     * 分类添加
     * @return string
     */
    public function actionAdd()
    {
        $this->layout = 'layout1';

        $model = new Category();

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->add($post)) {
                Yii::$app->session->setFlash('info', '添加成功');
            }
        }

        $list = $model->getOptions();
        return $this->render('add', ['model' => $model, 'list' => $list]);
    }


    /**
     * 分类修改
     * 注意：1.父级分类不能是自己本身2.父级分类不能是自己的子级
     * @return string
     */
    public function actionMod()
    {
        $this->layout = 'layout1';
        $cateid = Yii::$app->request->get('cateid');

        $model = Category::find()->where("cateid = :id", [':id' => $cateid])->one();

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();

            //所选分类不能是自己本身
            if ($cateid == $post['Category']['parentid']){
                Yii::$app->session->setFlash('info', '所选父级分类不能是自己本身');
                return $this->redirect(Yii::$app->request->referrer);
            }

            //父级分类不能是自己的子级
            $childids = [];
            $data = $model->getData();
            $tree = $model->getTree($data,$cateid);
            $childids = array_column($tree,'cateid');
            if (in_array((string)$post['Category']['parentid'],$childids)) {
                Yii::$app->session->setFlash('info', '所选父级分类不能是自己的子级');
                return $this->redirect(Yii::$app->request->referrer);
            }

            if ($model->load($post) && $model->save()) {
                Yii::$app->session->setFlash('info', '修改成功');
            }
        }

        $list = $model->getOptions();
        return $this->render('mod', ['model' => $model, 'list' => $list]);
    }

    /**
     * 删除分类
     * 注意：1.有子级不能删除
     * @throws \Exception
     */
    public function actionDel()
    {
        try{
            $cateid = (int)Yii::$app->request->get('cateid');
            if (empty($cateid)) {
                throw new \Exception('参数错误');
            }
            $data = Category::find()->where("parentid=:pid",[':pid'=>$cateid]) ->one();
            if ($data) {
                throw new \Exception("该分类下有子类不能删除");
            }
            if (!Category::deleteAll('cateid=:id',[':id'=>$cateid])){
                throw new \Exception("删除失败");

            }
        }catch (\Exception $e) {
            Yii::$app->session->setFlash('info',$e->getMessage());
        }

        return $this->redirect(['category/list']);
    }


}
