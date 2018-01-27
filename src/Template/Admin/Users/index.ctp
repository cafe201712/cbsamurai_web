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

use App\Model\Entity\User;
use Cake\Core\Configure;

$this->layout = 'leftbar';

$this->assign('page_id', 'admin-users-index');
$this->assign('title', 'ユーザー一覧');

$shop_name_len = Configure::read('AppLocal.DisplayShopNameLength', 40);
$roles = User::ROLES;
?>

<?php $this->start('sidebar'); ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <?= __d('CakeDC/Users', 'Actions') ?>
    </div>

    <ul class="list-group">
        <li class="list-group-item">
            <?= $this->Html->link('新規ユーザー', ['action' => 'add']) ?>
        </li>
    </ul>
</div>
<?php $this->end(); ?>

<h2><?= $this->fetch('title') ?></h2>

<div class="spacer30">
    <?= $this->element('search_form'); ?>
</div>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <th><?= $this->Paginator->sort('id', __d('CakeDC/Users', 'Id')) ?></th>
            <th></th>
            <th><?= $this->Paginator->sort('nickname', 'ニックネーム') ?></th>
            <th><?= $this->Paginator->sort('Shops.name', '所属ショップ') ?></th>
            <th class="role"><?= $this->Paginator->sort('role', 'ユーザータイプ') ?></th>
            <th><?= $this->Paginator->sort('active', '状態') ?></th>
            <th class="actions"><?= __d('CakeDC/Users', 'Actions') ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user) : ?>
            <tr>
                <td><?= $user->id ?></td>
                <td><?= $this->Html->image($user->thumbnailPath, ["class" => "trim-20"]); ?></td>
                <td><?= $this->Html->link($user->nickname, ['action' => 'view', $user->id]) ?></td>
                <td>
                    <?php if (isset($user->shop)) {
                        echo $this->Html->link(
                            mb_strimwidth(h($user->shop->name), 0, $shop_name_len, '...'),
                            ['controller' => 'Shops', 'action' => 'view', $user->shop->id]
                        );
                    } ?>
                </td>
                <td>
                    <?= $this->element('Users/role_icon', ['role' => $user->role]); ?>
                    <?= $roles[h($user->role)] ?>
                </td>
                <td><?= $this->element('active_label', ['entity' => $user]); ?></td>
                <td class="actions">
                    <?= $this->Html->link(__d('CakeDC/Users', 'View'), ['action' => 'view', $user->id]) ?>
                    <?= $this->Html->link(__d('CakeDC/Users', 'Edit'), ['action' => 'edit', $user->id]) ?>
                    <?= $this->Form->postLink(__d('CakeDC/Users', 'Delete'), ['action' => 'delete', $user->id], ['confirm' => __d('CakeDC/Users', 'Are you sure you want to delete # {0}?', $user->id)]) ?>
                </td>
            </tr>

        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="text-center">
    <?= $this->Paginator->numbers([
        'prev' => '< 前',
        'next' => '次 >',
    ]); ?>

    <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
</div>


