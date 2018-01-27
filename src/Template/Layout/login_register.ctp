<?php
$this->extend('base');
?>

<?= $this->element('navbar'); ?>

<div id="page-contents">
    <div class="container wrapper">
        <div class="row">
            <div class="col-sm-5">
                <div class="intro-texts">
                    <h1 class="text-white">きゃばサムライへ！</h1>

                    <p>
                        きゃばサムライでは、全国の有名キャバ嬢から地方の隠れキャバ嬢まで、あなたが本当に求めている相手を見つけることができます。
                        週末のお楽しみに、出張の疲れをいやすために、または仲間の歓迎会に、さまざまなシーンでお使いいただけるキャバ嬢発見サイトにぜひ登録してみてください。
                    </p>
                    <p>登録は無料です。登録フォームからすぐアクセスしてください。</p>

                    <a class="btn btn-primary" href="/pages/about" role="button">さらに詳しく</a>
                </div>
            </div>

            <div class="col-sm-6 col-sm-offset-1">
                <div class="reg-form-container">
                    <!-- Register/Login Tabs-->
                    <div class="reg-options">
                        <ul class="nav nav-tabs">
                            <li class="<?= $activeLink === 'register' ? 'active' : ''; ?>"><?= $this->Html->link('Register', ['action' => 'register']); ?></a></li>
                            <li class="<?= $activeLink === 'login' ? 'active' : ''; ?>"><?= $this->Html->link('Login', ['action' => 'login']); ?></li>
                        </ul>
                    </div>

                    <div class="tab-content">
                        <!--Register-->
                        <div class="tab-pane active" id="register">
                            <?= $this->fetch('register'); ?>
                        </div>

                        <!--Login-->
                        <div class="tab-pane" id="login">
                            <?= $this->fetch('login'); ?>
                        </div>
                    </div>
                </div><!-- /.reg-form-container -->
            </div>
        </div><!-- /.row -->
    </div><!-- /.container -->
</div>

<?= $this->element('footer_bar'); ?>
