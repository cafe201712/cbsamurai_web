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

$this->layout = 'half';

$this->assign('page_id', 'casts-view');
$this->assign('title', 'キャバ嬢表示');
?>

<?php $this->start('contents-header'); ?>
    <h2><?= h($cast->nickname) ?></h2>
<?php $this->end(); ?>

<?php $this->start('left-side'); ?>
    <?= $this->Html->image($cast->photoPath, ["class" => "thumbnail center-block"]); ?>

    <?= $this->element('grid_button', [
        'buttons' => [
            ['label' => '戻る', 'url' => $this->request->referer()],
            ['html' => $this->element('Casts/like_button', [
                'cast' => $cast,
                'isLiked' => $isLiked,
                'class' => 'btn btn-success btn-block',
            ])],
            ['html' => $this->element('Casts/select_button', [
                'cast' => $cast,
                'isLiked' => $isLiked,
                'isSelected' => $isSelected,
                'class' => 'btn btn-success btn-block',
            ])],
        ],
    ]) ?>
<?php $this->end(); ?>

<?php $this->start('right-side'); ?>
    <div id="profile">
        <h3>プロフィール</h3>
        <table class="table table-striped">
            <tr>
                <th>自己紹介</th>
                <td><pre class="pre_clear_style"><?= h($cast->introduction) ?></pre></td>
            </tr>
            <tr>
                <th>誕生日</th>
                <td><?= h($cast->birthday) ?></td>
            </tr>
        </table>
    </div>
    <hr>
    <div id="shop-info">
        <h3>お店情報</h3>
        <table class="table table-striped">
            <tr>
                <th scope="row">店名</th>
                <td><?= h($cast->shop->name) ?></td>
            </tr>
            <tr>
                <th scope="row">お店情報</th>
                <td><pre class="pre_clear_style"><?= h($cast->shop->description) ?></pre></td>
            </tr>
            <tr>
                <th scope="row">住所</th>
                <td><?= h($cast->shop->address) ?></td>
            </tr>
            <tr>
                <th scope="row">TEL</th>
                <td><?= h($cast->shop->tel) ?></td>
            </tr>
            <tr>
                <th scope="row">FAX</th>
                <td><?= h($cast->shop->fax) ?></td>
            </tr>
        </table>
    </div>
<?php $this->end(); ?>
