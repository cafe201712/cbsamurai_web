<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Invitation $invitation
  */
use App\Model\Entity\Invitation;

$this->layout = 'leftbar';

$this->assign('page_id', 'admin-invitations-view');
$this->assign('title', '招待状表示');

$types = Invitation::TYPES;
?>

<?php $this->start('script'); ?>
    <?= $this->element('qrcode_script') ?>
<?php $this->end(); ?>

<?php $this->start('sidebar'); ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <?= __('Actions') ?>
        </div>

        <ul class="list-group">
            <li class="list-group-item">
                <?= $this->Html->link('招待状編集', ['action' => 'edit', $invitation->id]) ?>
            </li>
            <li class="list-group-item">
                <?= $this->Form->postLink('招待状削除', ['action' => 'delete', $invitation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $invitation->name)]) ?>
            </li>
            <li class="list-group-item">
                <?= $this->Html->link('招待状一覧', ['action' => 'index']) ?>
            </li>
            <li class="list-group-item">
                <?= $this->Html->link('新規招待状', ['action' => 'add']) ?>
            </li>
        </ul>
    </div>
<?php $this->end(); ?>

<h2><?= h($invitation->name) ?></h2>

<?php if (isset($qrcode)): ?>
<div class="row">
    <div class="col-sm-8 col-sm-offset-2">
        <div class="text-center">
            <?= $this->element('qrcode', ['qrcode' => $qrcode, 'invitation' => $invitation]); ?>
        </div>
    </div>
</div>
<?php else: ?>
    <div class="alert alert-danger spacer30">
        無効になっている招待状なので、QR コードは表示しません。
    </div>
<?php endif; ?>

<div class="spacer50">
    <table class="table table-striped view">
        <tr>
            <th>Id</th>
            <td><?= h($invitation->id) ?></td>
        </tr>
        <tr>
            <th>ショップ</th>
            <td><?= h($invitation->shop->name) ?></td>
        </tr>
        <tr>
            <th>招待状名</th>
            <td><?= h($invitation->name) ?></td>
        </tr>
        <tr>
            <th>タイプ</th>
            <td>
                <?= $this->element('Users/role_icon', ['role' => $invitation->type]); ?>
                <?= $types[h($invitation->type)] ?>
            </td>
        </tr>
        <tr>
            <th>発行者</th>
            <td><?= h($invitation->user->nickname) ?></td>
        </tr>
        <tr>
            <th>作成日</th>
            <td><?= h($invitation->createdDate) ?></td>
        </tr>
        <tr>
            <th>状態</th>
            <td><?= $this->element('active_label', ['entity' => $invitation]); ?></td>
        </tr>
    </table>
</div>
