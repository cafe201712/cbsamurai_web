<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
?>
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

    <title>エラー | きゃばサムライ</title>
    <?= $this->Html->meta('icon') ?>
    <?= $this->fetch('meta') ?>
    <?= $this->Html->css(["/assets/css/bootstrap.min",]) ?>
    <?= $this->Html->css([
        'style',
        'ionicons.min',
        'font-awesome.min',
        'app',
    ]) ?>
    <?= $this->fetch('css') ?>
</head>

<body>
<?= $this->element('navbar'); ?>

<div class="container clearfix">
    <?= $this->Flash->render() ?>
    <?= $this->fetch('content') ?>
</div>

<?php if ($this->fetch('footer')): ?>
    <?= $this->fetch('footer') ?>
<?php else: ?>
    <?= $this->element('footer'); ?>
<?php endif;?>

<?= $this->Html->script([
    "/assets/js/jquery.min.js",
    "/assets/js/bootstrap.min.js",
    "/js/script.js"
]) ?>
<?= $this->fetch('script') ?>
</body>
</html>
