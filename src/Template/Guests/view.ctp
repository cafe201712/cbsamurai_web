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

$this->assign('page_id', 'guests-view');
$this->assign('title', 'お客様表示');
?>

<?php $this->start('contents-header'); ?>
    <h2><?= h($guest->nickname) ?></h2>
<?php $this->end(); ?>

<?php $this->start('left-side'); ?>
    <?= $this->Html->image($guest->photoPath, ["class" => "thumbnail center-block"]); ?>

    <?= $this->element('grid_button', [
        'buttons' => [
            ['label' => '戻る', 'url' => $this->request->referer()],
            ['html' => $this->element('Guests/add_tickets_button', [
                'like' => $like,
                'class' => 'btn btn-default btn-block',
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
                <td><pre class="pre_clear_style"><?= h($guest->introduction) ?></pre></td>
            </tr>
            <tr>
                <th>誕生日</th>
                <td><?= h($guest->birthday) ?></td>
            </tr>
            <tr>
                <th>チケット枚数</th>
                <td><?= $like->num_of_tickets ?> 枚</td>
            </tr>
        </table>
    </div>
<?php $this->end(); ?>
