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

$this->assign('page_id', 'profile-view');
$this->assign('title', 'プロフィール');
?>

<?php $this->start('script'); ?>
    <?= $this->element('qrcode_script') ?>
<?php $this->end(); ?>

<?php $this->start('contents-header'); ?>
    <h2><?= $this->fetch('title') ?></h2>
<?php $this->end(); ?>

<?php $this->start('left-side'); ?>
    <?= $this->Html->image($profile->photoPath, [
        'class' => 'thumbnail center-block',
        'url' => ['action' => 'edit']
    ]); ?>

    <?= $this->element('grid_button', [
        'buttons' => [
            ['label' => '戻る', 'url' => $this->request->referer()],
            ['label' => '編集', 'url' => $this->Url->build(['action' => 'edit'])],
        ],
    ]) ?>
    <br>
<?php $this->end(); ?>

<?php $this->start('right-side'); ?>
<div id="profile">
    <table class="table table-striped">
        <tr>
            <th>ニックネーム</th>
            <td><?= h($profile->nickname) ?></td>
        </tr>
        <tr>
            <th><?= __d('CakeDC/Users', 'Email') ?></th>
            <td><?= h($profile->email) ?></td>
        </tr>
        <tr>
            <th>自己紹介</th>
            <td><pre class="pre_clear_style"><?= $this->Decorate->notInput(h($profile->introduction)) ?></pre></td>
        </tr>
        <tr>
            <th>誕生日</th>
            <td><?= $this->Decorate->notInput(h($profile->birthday)) ?></td>
        </tr>
    </table>
</div>
<?php $this->end(); ?>

<?php $this->start('contents-footer'); ?>
<?php if (isset($qrcode)): ?>
    <hr>

    <h2 class="spacer20">招待状</h2>

    <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
            <p class="text-center">
                招待する方のスマートフォンで読み取ってください。
            </p>
            <?= $this->element('qrcode', ['qrcode' => $qrcode, 'invitation' => $invitation]); ?>
        </div>
    </div>
<?php endif; ?>
<?php $this->end(); ?>

