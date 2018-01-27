<footer id="footer">
    <div class="container">
        <div class="row">
            <div class="footer-wrapper">
                <div class="col-md-3 col-sm-6">
                    <?= $this->element('logo_link', ['logo_file' => 'logo_white.png']); ?>
                    <div class="spacer20">
                        <ul class="list-inline social-icons">
                            <li><a href="https://www.facebook.com/cbsamurai/" target="_blank"><i class="icon ion-social-facebook"></i></a></li>
                            <li><a href="https://twitter.com/cbsamurai_info" target="_blank"><i class="icon ion-social-twitter"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <h5>Contents</h5>
                    <ul class="footer-links">
                        <?php if (isset($login_user)): ?>
                            <!-- After Login　For Men(NC) -->
                            <li><?= $this->Html->link("ホーム","/home")?></li>
                            <li><?= $this->Html->link("キャバ嬢一覧", "/casts")?></li>
                            <li><?= $this->Html->link("プロフィール", "/profile")?></li>
                            <li><?= $this->Html->link("ログアウト", "/logout")?></li>
                            <li><?= $this->Html->link("パスワード変更", "/change-password")?></li>
                        <?php else: ?>
                            <!-- Before Login -->
                            <li><?= $this->Html->link("新規登録", "/register")?></li>
                            <li><?= $this->Html->link("ログイン", "/login")?></li>
                        <?php endif; ?>
                        <li><?= $this->Html->link("ヘルプ", "/pages/help") ?></li>
                    </ul>
                </div>
                <div class="col-md-3 col-sm-6">
                    <h5>Information</h5>
                    <ul class="footer-links">
                        <li><?= $this->Html->link("会社概要", "/pages/company") ?></li>
                        <li><?= $this->Html->link("採用情報", "/pages/recruit") ?></li>
                        <li><?= $this->Html->link("当サイトについて", "/pages/about") ?></li>
                        <li><?= $this->Html->link("サービス内容", "/pages/service") ?></li>
                        <li><?= $this->Html->link("利用規約", "/pages/terms") ?></li>
                        <li><?= $this->Html->link("個人情報保護方針", "/pages/privacy") ?></li>
                        <li><?= $this->Html->link("お問い合わせ・ご要望", "/contact") ?></li>
                    </ul>
                </div>
                <div class="col-md-3 col-sm-6">
                    <h5>Contact Us</h5>
                    <ul class="contact">
                        <li><i class="icon ion-ios-telephone-outline"></i>03-5308-0226</li>
                        <li><i class="icon ion-ios-email-outline"></i>info@cbsamurai.jp</li>
                        <li><i class="icon ion-ios-location-outline"></i>東京都新宿区西新宿1-20-3<br><span>&emsp;&emsp; </span>西新宿高木ビル8F</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <?= $this->element('footer_bar'); ?>
</footer>
