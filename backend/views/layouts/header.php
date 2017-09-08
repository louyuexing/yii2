<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
$session=\Yii::$app->session;
$session->open();
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">菜单</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation" style="background: black">

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">IzoIao</a>
            </div>
            <ul class="nav navbar-nav navbar-right" style="background: #b3cebf">
                <?php
                if(Yii::$app->user->isGuest){
                    echo '<li>';
                    echo  Html::a('<span class="glyphicon glyphicon-user"></span> 注册',['index/register']);
                    echo '</li>';
                    echo '<li>';
                    echo  Html::a('<span class="glyphicon glyphicon-log-in"></span> 登录',['index/login']);
                    echo '</li>';
                }else{
                    $user=$session->get('user');
                    echo '<li>';
                    echo  Html::a("<span class='glyphicon glyphicon-user'></span> 欢迎$user",['index/login-out']);
                    echo '</li>';
                    echo '<li>';
                    echo  Html::a('<span class="glyphicon glyphicon-log-out"></span> 退出',['index/login-out']);
                    echo '</li>';
                    $session->close();
                }
                ?>
            </ul>
        </div>
    </nav>

</header>
