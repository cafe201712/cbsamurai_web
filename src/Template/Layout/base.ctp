<!DOCTYPE html>
<html lang="ja">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <?= $this->Html->charset() ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="キャバ嬢,キャバクラ,無料,メッセージ" />
    <meta name="description" content="無料でキャバ嬢とメッセージがやり取りできるサービスです！" />
    <meta name="robots" content="index, follow" />

    <!--Google Font-->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,400i,700,700i" rel="stylesheet">
    <!--Favicon-->
    <link rel="shortcut icon" type="image/png" href="images/fav.png"/>

    <title>
        <?php if ($this->fetch('title') === 'top'): ?>
            きゃばサムライ
        <?php else: ?>
            <?= $this->fetch('title') . " | きゃばサムライ"?>
        <?php endif;?>
    </title>
    <?= $this->Html->meta('icon') ?>
    <?= $this->fetch('meta') ?>

    <?= $this->Html->css([
        "/assets/css/bootstrap.min",
        "/assets/css/select2.min",
        "/assets/css/select2-bootstrap.min",
        'style',
        'ionicons.min',
        'font-awesome.min',
        'app',
    ]) ?>
    <?= $this->fetch('css') ?>
</head>

<body id="<?= $this->fetch('page_id') ?>">
    <?= $this->fetch('content') ?>

    <?= $this->Html->script([
        "/assets/js/jquery.min",
        "/assets/js/bootstrap.min",
        "/assets/js/select2.min",
        "/js/script.js",
        "/js/app.js",
    ]) ?>
    <?= $this->fetch('script') ?>
</body>
</html>
