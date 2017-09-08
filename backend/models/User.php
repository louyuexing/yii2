<?php
namespace backend\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface {


    public $password;
    public $repassword;
    public $rememberMe;
    public $code;

    const SCENARIO_LOGIN='login';
    const SCENARIO_REGISTER='register';

    public static function tableName()
    {
        return 'user';
    }

    public function scenarios()
    {
        return [
             'login'=>['username','password',],//在该场景下的属性进行验证，其他场景和没有on的都不会验证
             'register'=>['username','password','code','repassword']//在该场景下的属性进行验证，其他场景和没有on的都不会验证
        ];
    }


    public function rules()
    {
        return [
            [['username','password','code'],'required','on'=>['login','register']],
            [['username','password'],'string','length' => [3,16],'on'=>['login','register']],
            ['username','unique','on'=>'register'],
            ['rememberMe','boolean','on'=>'login'],
            ['code','captcha','captchaAction'=>'index/captcha','message'  =>'验证码错误','on'=>['login','register']],
            ['repassword', 'required','on'=>'register'], // 必须要加上这一句
            ['repassword', 'compare', 'compareAttribute' => 'password', 'operator' => '===','on'=>'register']
        ];
    }

    public function attributeLabels()
    {
        return [
            'username'=>'用户名',
            'password'=>'密码',
            'repassword'=>'确认密码',
            'rememberMe'=>'记住本次登录',
            'code'=>'验证码'
        ];
    }

    public function validate_username_password($rememberMe){
        $user=User::findOne(['username'=>$this->username]);
        if($user==null){
            $this->addError('username','用户名或密码错误');
            return false;
        }else{
            if(\Yii::$app->security->validatePassword($this->password,$user->password_hash)){
                $duration=$rememberMe*1?24*3600:0;
                \Yii::$app->user->login($user,$duration);
                return true;
            }else{
                $this->addError('username','用户名或密码错误');
                return false;
            }

        }
    }



    public function beforeSave($insert)
    {
        if($insert){
            $this->create_time=time();
            $this->password_hash=\Yii::$app->security->generatePasswordHash($this->password);
        }
        return true;
    }

    /**
     * Finds an identity by the given ID.
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        return self::findOne(['id'=>$id]);
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|int an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        // TODO: Implement getId() method.
        return $this->id;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
        return $this->auth_key;

    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }
}