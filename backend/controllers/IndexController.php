<?php
namespace backend\controllers;


use backend\models\User;

use yii\web\Controller;
use yii\web\Request;

class IndexController extends Controller {

    public $layout  ='main';

    public function actionIndex(){

        if(\Yii::$app->user->isGuest){
             return $this->redirect(['index/login']);
        }else{
            return $this->render('index');

        }

    }

    public function actionLogin(){

        $request= new Request();
        $model=new User();
        $this->layout='main-login';
        $model->setScenario(User::SCENARIO_LOGIN);
        if($request->isPost){
            if($model->load($request->post()) && $model->validate()){
                $rememberMe=$_REQUEST['User']['rememberMe'];
                $user=$_REQUEST['User']['username'];
                if($model->validate_username_password( $rememberMe)){
                    $session=\Yii::$app->session;
                    $session->open();
                    $session->set('user',$user);
                    $this->layout='main';
                    return $this->render('index',['user'=>$user]);
                }
                  $model->addError('username','用户名或密码错误');
                return $this->render('login',['model'=>$model]);
            }else{
                return $this->render('login',['model'=>$model]);
            }
        }
        return $this->render('login',['model'=>$model]);


    }

    public function actionRegister(){
        $model=new User();//场景调用
        $model->setScenario('register');
        $request=new Request();
        if($request->isPost){
           $model->load($request->post());
            if($model->validate()){
                if($model->save(false)){
                     \Yii::$app->getSession()->setFlash('success','注册成功');
                     return $this->redirect(['index/login']);
                 }
                \Yii::$app->getSession()->setFlash('error','注册 失败');
                return $this->render('register',['model'=>$model]);
            }

           \Yii::$app->getSession()->setFlash('error','注册 失败');
          return $this->render('register',['model'=>$model]);
        }

        return $this->render('register',['model'=>$model]);
    }

    public function actionLoginOut(){
        \Yii::$app->user->logout(true);
        return $this->redirect(['index/login']);

    }




    public function actions()
    {
        return [
            'captcha'=>[
                'class'=>'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'minLength'=>4,//验证码最小长度
                'maxLength'=>4,//最大长度
            ]
        ];
    }







}