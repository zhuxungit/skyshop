<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * 用户表
 * Class User
 * @package app\modules\models
 */
class User extends ActiveRecord
{
    public $repass;
    public $rememberMe = true;

    /**
     * 获取表名
     * @return string
     */
    public static function tableName()
    {
        return "{{%user}}";
    }

    public function attributeLabels()
    {
        return [
            'username'=>'用户名',
            'userpass'=>'用户密码',
            'repass'=>'确认密码',
            'useremail'=>'用户邮箱',
        ];
    }

    public function rules()
    {
        return [
            ['username','required','message'=>'用户名不能为空','on'=>['useradd','login']],
            ['username','existsUser','on'=>['login']],
            ['userpass','required','message'=>'密码不能为空','on'=>['useradd','login']],
            ['userpass','validatePass','on'=>['login']],
            ['useremail','required','message'=>'用户邮箱不能为空','on'=>['useradd','regbymail']],
            ['useremail','unique','message'=>'该邮箱已被注册','on'=>['useradd','regbymail']],
            ['useremail','email','message'=>'用户邮箱格式不正确','on'=>['useradd','regbymail']],
        ];
    }

    /**
     * 验证密码是否存在
     */
    public function validatePass()
    {
        //前面的验证没有错误才会执行
        if (!$this->hasErrors()) {
            $data = self::find()->where('username=:user and userpass=:pass',[':user'=>$this->username,':pass'=>md5($this->userpass)])->one();
            if (is_null($data)) {
                $this->addError('userpass','用户名或者密码错误');

            }
        }
    }

    /**
     * 验证登录的用户名是否存在
     */
    public function existsUser()
    {
        if (!$this->hasErrors()) {
            $data = self::find()->where('username=:user',[':user'=>$this->username])->one();
            if (is_null($data)) {
                $this->addError('username','用户名不存在');
            }
        }
    }


    /**
     * 注册新用户
     */
    public function reg($data,$scetype='useradd')
    {
        $this->scenario = $scetype;

        if ($this->load($data) && $this->validate()) {
            $this->userpass = md5($this->userpass);
            $this->createtime = time();

            if ($this->save(false)) {
                return true;
            }
            return false;
        }
        return false;
    }

    public function getProfile()
    {
        //一对一的关联hasOne,一对多的关联hasMany，
        //第一个参数为要关联的子表模型的类名
        //第二个参数为子表的userid关联主表的userid
        return $this->hasOne(Profile::className(),['userid'=>'userid']);
    }

    /**
     * 通过邮箱注册
     * @param $data
     * @return bool
     */
    public function regByMail($data)
    {
        $this->scenario = 'regbymail';
        $data['User']['username'] = 'sky_'.uniqid();
        $data['User']['userpass'] = uniqid();
        if ($this->load($data) && $this->validate()) {
            $mailer = Yii::$app->mailer->compose('createuser',['username'=>$data['User']['username'],'userpass'=>$data['User']['userpass']]);
            $mailer->setFrom('m15262723161_2@163.com');
            $mailer->setTo($data['User']['useremail']);
            $mailer->setSubject('sky商城-新建账户');
            if($mailer->send() && $this->reg($data,'regbymail')){
                return true;
            }
        }
        return false;
    }


    /**
     * 用户登录
     */
    public function login($data)
    {
        $this->scenario = 'login';
        if ($this->load($data) && $this->validate()) {
            $lifetime = $this->rememberMe?24*3600:0;
            $session = Yii::$app->session;
            session_set_cookie_params($lifetime);
            $session['username'] = $this->username;
            $session['isLogin'] = 1;

            return (bool)$session['isLogin'];
        }
        return false;
    }




}