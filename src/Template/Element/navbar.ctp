<nav class="navbar navbar-default navbar-fixed-top menu">
    <!--<div class="container-fluid">-->
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <?= $this->element('logo_link', ['class' => 'navbar-brand', 'logo_file' => 'logo_black.png']); ?>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <?php if (empty($login_user)): ?>
                    <li><?= $this->Html->link("トップ", "/") ?></a></li>
                <?php else: ?>
                    <?php if ($login_user->isUser() || $login_user->isCast()): ?>
                        <li><a href="<?= $this->Url->build("/home") ?>">
                            ホーム <?= $this->cell('Messages::unread', [ null, $login_user->id])->render(); ?>
                        </a></li>
                    <?php endif; ?>
                <?php endif; ?>
                <li><?= $this->Html->link("キャバ嬢", "/casts") ?></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <?php if (isset($login_user)): ?>
                    <?php if ($login_user->isSuperUser()): ?>
                        <li><?= $this->Html->link("ニュース", "/admin/news") ?></li>
                        <li><?= $this->Html->link("ショップ", "/admin/shops") ?></li>
                    <?php endif; ?>
                    <?php if ($login_user->isManager() || $login_user->isSuperUser()): ?>
                        <li><?= $this->Html->link("ユーザー", "/admin/users") ?></a></li>
                    <?php endif; ?>
                    <?php if (!$login_user->isUser()): ?>
                        <li><?= $this->Html->link("招待状", "/admin/invitations") ?></a></li>
                    <?php endif; ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?= $login_user->nickname ?><span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><?= $this->Html->link("プロフィール", "/profile") ?></a></li>
                            <li><?= $this->Html->link("パスワード変更", "/change-password") ?></li>
                            <li role="separator" class="divider"></li>
                            <li><?= $this->Html->link("ログアウト", "/logout") ?></a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li><?= $this->Html->link("ユーザー登録", "/register") ?></li>
                    <li><?= $this->Html->link("ログイン", "/login") ?></li>
                <?php endif; ?>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container -->
</nav>
