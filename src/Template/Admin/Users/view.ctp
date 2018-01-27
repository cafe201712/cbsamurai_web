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

$this->layout = 'leftbar';

$this->assign('page_id', 'admin-users-view');
$this->assign('title', 'ユーザー表示');
?>

<?php $this->start('sidebar'); ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <?= __d('CakeDC/Users', 'Actions') ?>
    </div>

    <ul class="list-group">
        <li class="list-group-item">
            <?= $this->Html->link(__d('CakeDC/Users', 'Edit User'), ['action' => 'edit', $user->id]) ?>
        </li>
        <li class="list-group-item">
            <?= $this->Form->postLink(
                __d('CakeDC/Users', 'Delete User'),
                ['action' => 'delete', $user->id],
                ['confirm' => __d('CakeDC/Users', 'Are you sure you want to delete # {0}?', $user->id)]
            ) ?>
        </li>
        <li class="list-group-item">
            <?= $this->Html->link(__d('CakeDC/Users', 'List Users'), ['action' => 'index']) ?>
        </li>
        <li class="list-group-item">
            <?= $this->Html->link(__d('CakeDC/Users', 'New User'), ['action' => 'add']) ?>
        </li>
    </ul>
</div>
<?php $this->end(); ?>

<h2><?= h($user->nickname) ?></h2>

<?= $this->Html->image($user->photoPath, ["class" => "thumbnail spacer30"]); ?>

<div class="spacer30">
    <?= $this->element('Users/user', ['user' => $user]); ?>

    <table class="table table-striped view spacer50">
        <tr>
            <th><?= __d('CakeDC/Users', 'Activation Date') ?></th>
            <td><?= h($user->activation_date) ?></td>
        </tr>
        <tr>
            <th><?= __d('CakeDC/Users', 'Tos Date') ?></th>
            <td><?= h($user->tos_date) ?></td>
        </tr>
        <tr>
            <th><?= __d('CakeDC/Users', 'Created') ?></th>
            <td><?= h($user->created) ?></td>
        </tr>
        <tr>
            <th><?= __d('CakeDC/Users', 'Modified') ?></th>
            <td><?= h($user->modified) ?></td>
        </tr>
    </table>
</div>
