<?php
$this->extend('default');
?>

<?php $this->start('css') ?>
<style>
#page-header {
    /*
    background-image: url('<?= $this->Url->image('何か背景画像を指定-横幅が広いのが良い.jpg') ?>');
    */
    background-image: url('https://placehold.jp/800x200.png');
    background-position: center center;
    background-repeat: repeat-x;
}
</style>
<?php $this->end(); ?>

<?php $this->start('page-header'); ?>
<div id="page-header">
    <div class="container">
        <h1 class="page-title"><?= $this->fetch('title') ?></h1>
    </div>
</div>
<?php $this->end(); ?>

<div class="row">
    <div class="col-md-9 col-xs-12">
        <?= $this->fetch('content') ?>
    </div>

    <div class="col-md-3 static">
        <h3>お知らせ</h3>

        <div class="spacer30">
            <?= $this->cell('News::released', [10])->render(); ?>
        </div>
    </div>
</div>
