<?php
namespace app\modules\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * 管理员类
 * Class Admin
 * @package app\modules\models
 */
class Admin extends ActiveRecord
{
    /**
     * 新加字段，默认‘记住我’
     * @var bool
     */
    public $rememberMe = true;

    public $repass;

    /**
     * 指定操作的表
     * @return string
     *
     */
    public static function tableName()
    {
        return "{{%admin}}";
    }

    /**
     * 创建前台标签名称
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'adminuser'=>'管理员账号',
            'adminemail'=>'管理员邮箱',
            'adminpass'=>'管理员密码',
            'repass'=>'确认密码',
        ];
    }

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            ['adminuser', 'required', 'message' => '管理员账号不能为空','on'=>['login','seekpass','adminadd','changeemail']],
            ['adminuser', 'unique', 'message' => '管理员已被注册','on'=>['adminadd']],
            ['adminpass', 'required', 'message' => '管理员密码不能为空','on'=>['login','changepass','adminadd','changeemail']],
            ['rememberMe', 'boolean','on'=>['login']],
            ['adminpass', 'validatePass','on'=>['login','changeemail']],
            ['adminemail', 'required','message'=>'电子邮箱能为空','on'=>['seekpass','adminadd','changeemail']],
            ['adminemail','email','message'=>'电子邮箱格式不正确','on'=>['seekpass',' adminadd','changeemail']],
            ['adminemail','unique','message'=>'电子邮箱已被注册','on'=>['adminadd','changeemail']],
            ['adminemail','validateEmail','on'=>['seekpass']],
            ['repass','required','message'=>'确认密码不能为空','on'=>['changepass','adminadd']],
            ['repass','compare','compareAttribute'=>'adminpass','message'=>'两次密码输入不一致','on'=>['changepass','adminadd']],
            ['adminuser,adminpass,repass','safe']
        ];
    }


    /**
     * 账户密码验证
     * 注：如果前三项验证rules有错误就不执行最后一条查询数据库，减少数据库压力
     */
    public function validatePass()
    {
        //验证通过才查询
        if (!$this->hasErrors()) {
            $data = self::find()->where('adminuser=:user and adminpass=:pass', [':user' => $this->adminuser, ':pass' => md5($this->adminpass)])->one();
            if (is_null($data)) {
                $this->addError("adminpass", "用户名或密码错误");
            }
        }
    }

    /**
     * 验证登录
     * @param $data
     * @return bool
     */
    public function login($data)
    {
        //指定场景
        $this->scenario = 'login';
        //执行验证和session写入
        if ($this->load($data) && $this->validate()) {
            $lifetime = $this->rememberMe ? 24 * 3600 : 0;
            $session = Yii::$app->session;
            //设置保存sessionid的cookie的有效期
            session_set_cookie_params($lifetime);
            $session['admin'] = [
                'adminuser' => $this->adminuser,
                'isLogin' => 1
            ];

            //更新登录时间
            $this->updateAll(['logintime'=>time(),'loginip'=>ip2long(Yii::$app->request->userIP)],'adminuser=:user',[':user'=>$this->adminuser]);
            return (bool)$session['admin']['isLogin'];
        }
        return false;
    }


    /**
     * 对用户输入的邮箱进行验证
     */
    public function validateEmail()
    {
        if(!$this->hasErrors()){
            $data = self::find()->where("adminuser = :user and adminemail = :email",[':user'=>$this->adminuser,':email'=>$this->adminemail])->one();
            if (is_null($data)) {
                $this->addError("adminemail",'管理员电子邮箱不匹配');
            }
        }
    }

    /**
     * 邮箱找回密码
     * @param $data
     * @return bool
     */
    public function seekPass($data)
    {
        //指定场景
        $this->scenario = 'seekpass';

        if ($this->load($data) && $this->validate())
        {
            $time = time();
            $token = $this->createToken($data['Admin']['adminuser'],$time);
            $mailer = Yii::$app->mailer->compose('seekpass',['adminuser'=>$data['Admin']['adminuser'],'time'=>$time,'token'=>$token]);
            $mailer->setFrom("m15262723161_2@163.com");
            $mailer->setTo($data['Admin']['adminemail']);
            $mailer->setSubject("sky商城-找回密码");
            if ($mailer->send())
            {
                return true;
            }
        }
        return false;
    }

    /**
     * 创建token
     */
    public function createToken($adminuser,$time)
    {
        return md5(md5($adminuser).base64_encode(Yii::$app->request->userIP).md5($time));
    }

    /**
     * 修改密码
     * @param $data
     * @return bool
     */
    public function changePass($data)
    {
        $this->scenario = "changepass";

        if($this->load($data) && $this->validate()) {

            return (bool)$this->updateAll(['adminpass'=>md5($this->adminpass)],'adminuser=:user',[':user'=>$this->adminuser]);
        }
        return false;
    }

    /**
     * 密码修改成功
     * @param $data
     * @return bool
     */
    public function reg($data)
    {
        $this->scenario = 'adminadd';

        if ($this->load($data) && $this->validate()) {
            $this->adminpass = md5($this->adminpass);

            //save方法第一个参数给了false表示不进行验证
            if ($this->save(false)){
                return true;
            }
            return false;
        }
        return false;
    }

    /**
     * 修改邮箱
     * @param $data
     * @return bool
     */
    public function changeemail($data)
    {
        $this->scenario = 'changeemail';
        if ($this->load($data) && $this->validate()) {
            return (bool)$this->updateAll(['adminemail'=>$this->adminemail],'adminuser=:user',[':user'=>$this->adminuser]);
        }
        return false;
    }


}