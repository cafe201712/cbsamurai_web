<?php
$this->assign('page_id', 'pages-contact');
$this->assign('title', 'お問い合わせ');
?>

<?php $this->start('page-header'); ?>
<div class="google-maps">
    <div id="map" class="map contact-map"></div>
</div>
<?php $this->end(); ?>

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="contact-us">
            <div class="row">
                <div class="col-md-8 col-sm-7">
                    <h4 class="grey">お問い合わせ</h4>

                    <?= $this->Flash->render() ?>

                    <?= $this->Form->create($contact, ['novalidate' => true]); ?>
                        <?= $this->Form->control('name', [
                            'label' => false,
                            'placeholder' => 'お名前'
                        ]); ?>
                        <?= $this->Form->control('email', [
                            'label' => false,
                            'placeholder' => 'メールアドレス'
                        ]); ?>
                        <?= $this->Form->control('tel', [
                            'label' => false,
                            'placeholder' => '電話番号（9999-9999-9999）'
                        ]); ?>
                        <?= $this->Form->control('subject', [
                            'label' => false,
                            'placeholder' => '件名'
                        ]); ?>
                        <?= $this->Form->control('message', [
                            'type' => 'textarea',
                            'label' => false,
                            'placeholder' => '内容'
                        ]); ?>

                        <?= $this->Form->submit('送信', ['class' => 'btn-primary']); ?>
                    <?= $this->Form->end(); ?>
                </div>

                <div class="col-md-4 col-sm-5">
                    <h4 class="grey">連絡先</h4>
                    <div class="reach">
                        <span class="phone-icon"><i class="icon ion-android-call"></i></span>
                        <p>03-(5308)-0226</p>
                    </div>
                    <div class="reach">
                        <span class="phone-icon"><i class="icon ion-email"></i></span>
                        <p>info@cbsamurai.jp</p>
                    </div>
                    <div class="reach">
                        <span class="phone-icon"><i class="icon ion-ios-location"></i></span>
                        <p>〒160-0023 東京都新宿区西新宿1-20-3 西新宿高木ビル8F</p>
                    </div>

                    <ul class="list-inline social-icons center-block">
                        <li>
                            <a href="https://www.facebook.com/cbsamurai" target="_blank">
                                <i class="icon ion-social-facebook"></i>
                            </a>
                        </li>
                        <li>
                            <a href="https://twitter.com/cbsamurai_info" target="_blank">
                                <i class="icon ion-social-twitter"></i>
                            </a>
                        </li>
                    </ul>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.contuct-us -->
    </div><!-- /.col -->
</div><!-- /.row -->

<?php $this->start('script'); ?>
<script>
    function initMap() {
        var uluru = {lat: 35.688022, lng: 139.696380};
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 18,
            center: uluru
        });
        var marker = new google.maps.Marker({
            position: uluru,
            map: map
        });
    }
</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCK9OrYrxayHs2FDCHWELXXKWm8u5jwVqI&callback=initMap"></script>
<?php $this->end(); ?>

