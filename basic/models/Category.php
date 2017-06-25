<?php
namespace app\models;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class Category extends ActiveRecord
{

//    public $createtime;

    public static function tableName()
    {
        return '{{%category}}';
    }

    public function attributeLabels()
    {
        return [
            'parentid' => '上级分类',
            'title' => '分类名称'
        ];
    }

    public function rules()
    {
        return [
            ['parentid', 'required', 'message' => '上级分类不能为空'],
            ['title', 'required', 'message' => '分类名称不能为空'],
            ['createtime', 'safe']
        ];
    }

    /**
     * 分类添加
     * @param $data
     * @return bool
     */
    public function add($data)
    {
//        $this->scenario = 'cateadd';
        $data['Category']['createtime'] = time();
        if ($this->load($data) && $this->save()) {
//            $this->createtime = time();
            return true;

        }
        return false;
    }


    /**
     * 取出所有数据转成数组
     * @return array|ActiveRecord[]
     */
    public function getData()
    {
        $catas = self::find()->all();
        //因获取的数据为对象，要转成数组
        $catas = ArrayHelper::toArray($catas);
        return $catas;
    }

    public function getTree($list, $pid = 0, $level = 0)
    {
        static $tree = array();
        foreach ($list as $row) {
            if ($row['parentid'] == $pid) {
                $row['level'] = $level;
                $row['title'] = str_repeat('|------', $level) . $row['title'];
                $tree[] = $row;
                $this->getTree($list, $row['cateid'], $level + 1);
            }
        }
        return $tree;
    }


    public function getOptions()
    {
        $data = $this->getData();
        $tree = $this->getTree($data);

        $options = ['请添加顶级分类'];
        foreach ($tree as $cate) {
            $options[$cate['cateid']]=$cate['title'];
        }

        return $options;
    }


}