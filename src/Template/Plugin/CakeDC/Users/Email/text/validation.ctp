<?php
/**
 * Copyright 2010 - 2017, Cake Development Corporation (https://www.cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010 - 2017, Cake Development Corporation (https://www.cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
$activationUrl = [
    '_full' => true,
// Controller/Admin/UsersController でユーザー登録処理を継承した為、"'plugin' => 'CakeDB/Users'" をコメントアウト
//    'plugin' => 'CakeDC/Users',
    'controller' => 'Users',
    'action' => 'validateEmail',
    isset($token) ? $token : ''
];
?>

<?= isset($nickname) ? "こんにちは、${nickname} さん。" : "こんにちは。" ?>

　きゃばサムライへ仮登録していただきありがとうございました。
本登録のために以下のURLをクリックしてください。

<?= __d(
    'CakeDC/Users', '{0}',
    $this->Url->build($activationUrl))
?>


　本リンクは配信後、1時間有効です。有効期間を過ぎた場合は
仮登録画面から再送信の手続きを行ってください。

■■■■■■■■■■■■■■■■■■■■
美人キャバ嬢とメッセージが無料でやり取りできる！
　きゃばサムライ　<?=  $this->Url->build('/',true); ?>

　運営元： 株式会社Bellezza（ https://www.bellezza.co.jp ）
■■■■■■■■■■■■■■■■■■■■ 
