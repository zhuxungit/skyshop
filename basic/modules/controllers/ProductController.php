<?php
namespace app\modules\controllers;
use Yii;
use app\models\Category;
use app\models\Product;
use yii\data\Pagination;
use yii\web\Controller;
use crazyfd\qiniu\Qiniu;

class ProductController extends Controller
{
    /**
     * 商品列表显示
     */
    public function actionList()
    {
        $this->layout='layout1';

        //实现分页数据读取
        $model = Product::Find()->joinWith('category');
        $count = $model->count();
        $pageSize = Yii::$app->params['pageSize']['product'];
        $pager = new Pagination(['totalCount'=>$count,'pageSize'=>$pageSize]);
        $products = $model->offset($pager->offset)->limit($pager->limit)->all();

        return $this->render('products',['products'=>$products,'pager'=>$pager]);
    }

    /**
     * 商品添加
     */
    public function actionAdd()
    {
        $this->layout='layout1';


        //获取商品分类
        $catemodel = new Category();
        $list = $catemodel->getOptions();
        unset($list[0]);
        $model = new Product();
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();

            $pics = $this->upload();

//            var_dump($pics);die;

            if (!$pics) {
                $model->addError('cover','封面图片不能为空');
            }else{
             $post['Product']['cover']=$pics['cover'];
             $post['Product']['pics'] = $pics['pics'];
            }

            if ($pics && $model->add($post)) {
                Yii::$app->session->setFlash('info','添加成功');
            }else{
                Yii::$app->session->setFlash('info','添加失败');
            }
        }


        return $this->render('add',['model'=>$model,'opts'=>$list]);
    }

    /**
     * 上传
     */
    private function upload()
    {
        if ($_FILES['Product']['error']['cover']>0) {
            return false;
        }

        $qiniu = new Qiniu(Product::AK,Product::SK,Product::DOMAIN,Product::BUCKET);
        //七牛云通过$key定位图片
        $key = uniqid();
        $qiniu->uploadFile($_FILES['Product']['tmp_name']['cover'],$key);
        $cover = $qiniu->getLink($key);
        $pics = [];
        foreach ($_FILES['Product']['tmp_name']['pics'] as $k=>$file){
            if ($_FILES['Product']['error']['pics'][$k]>0) {
                continue;
            }
            $key = uniqid();
            $qiniu->uploadFile($file,$key);
            $pics[$key] = $qiniu->getLink($key);
        }

        return ['cover'=>$cover,'pics'=>json_encode($pics)];

    }

}