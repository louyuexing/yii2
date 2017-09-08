<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?=Yii::$app->session->get('user')?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
<!--        <form action="#" method="get" class="sidebar-form">-->
<!--            <div class="input-group">-->
<!--                <input type="text" name="q" class="form-control" placeholder="Search..."/>-->
<!--              <span class="input-group-btn">-->
<!--                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>-->
<!--                </button>-->
<!--              </span>-->
<!--            </div>-->
<!--        </form>//搜索-->
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => 'MENU', 'options' => ['class' => 'header']],
                    ['label' => '文章管理', 'icon' => 'file-code-o', 'url' => ['article/index']],
                    ['label' => '活动管理', 'icon' => 'dashboard', 'url' => ['active/index']],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    [
                        'label' => '顶级',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => ':)一级', 'icon' => 'file-code-o', 'url' => ['/gii'],],
                            ['label' => ':)一级', 'icon' => 'dashboard', 'url' => ['/debug'],],
                            [
                                'label' => ':)一级',
                                'icon' => 'circle-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => ':)二级', 'icon' => 'circle-o', 'url' => '#',],
                                    [
                                        'label' => ':)二级',
                                        'icon' => 'circle-o',
                                        'url' => '#',
                                        'items' => [
                                            ['label' => ':三级', 'icon' => 'circle-o', 'url' => '#',],
                                            ['label' => ':)三级', 'icon' => 'circle-o', 'url' => '#',],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
