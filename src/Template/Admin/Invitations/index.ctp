<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Invitation[]|\Cake\Collection\CollectionInterface $invitations
  */
use App\Model\Entity\Invitation;
use Cake\Core\Configure;

$this->layout = 'leftbar';

$this->assign('page_id', 'admin-invitations-index');
$this->assign('title', '招待状一覧');

$shop_name_len = Configure::read('AppLocal.DisplayShopNameLength', 40);
$types = Invitation::TYPES;
?>

<?php $this->start('sidebar'); ?>
    <div class="panel panel-default">
        <div class="panel-heading"><?= __('Actions') ?></div>

        <ul class="list-group">
            <li class="list-group-item">
                <?= $this->Html->link('新規招待状', ['action' => 'add']) ?>
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
            <th><?= $this->Paginator->sort('id', 'Id') ?></th>
            <th><?= $this->Paginator->sort('name', '招待状名') ?></th>
            <th class="role"><?= $this->Paginator->sort('type', 'タイプ') ?></th>
            <?php if ($login_user->isSuperUser()): ?>
                <th><?= $this->Paginator->sort('Shops.name', 'ショップ') ?></th>
                <th><?= $this->Paginator->sort('Users.name', '発行者') ?></th>
            <?php endif; ?>
            <th class="date"><?= $this->Paginator->sort('created', '作成日') ?></th>
            <th><?= $this->Paginator->sort('active', '状態') ?></th>
            <th class="actions">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($invitations as $invitation) : ?>
            <tr>
                <td><?= $this->Html->link(mb_strimwidth($invitation->id, 0, 6, '...'), ['action' => 'view', $invitation->id]) ?></td>
                <td><?= $this->Html->link($invitation->name, ['action' => 'view', $invitation->id]) ?></td>
                <td>
                    <?= $this->element('Users/role_icon', ['role' => $invitation->type]); ?>
                    <?= $types[h($invitation->type)] ?>
                </td>
                <?php if ($login_user->isSuperUser()): ?>
                    <td>
                        <?= $this->Html->link(
                            mb_strimwidth(h($invitation->shop->name), 0 , $shop_name_len, '...'),
                            ['controller' => 'Shops', 'action' => 'view', $invitation->shop->id]
                        ) ?>
                    </td>
                    <td><?= $this->Html->link($invitation->user->nickname, ['controller' => 'Users', 'action' => 'view', $invitation->user->id]) ?></td>
                <?php endif; ?>
                <td><?= $invitation->createdDate ?></td>
                <td><?= $this->element('active_label', ['entity' => $invitation]); ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $invitation->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $invitation->id]) ?>
                    <?= $this->Form->postLink(__('Delete'),
                        ['action' => 'delete', $invitation->id],
                        ['confirm' => __('Are you sure you want to delete # {0}?', $invitation->name)])
                    ?>
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
