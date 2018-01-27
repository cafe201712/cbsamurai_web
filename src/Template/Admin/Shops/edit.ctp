<?php
/**
  * @var \App\View\AppView $this
  */

$this->layout = 'leftbar';

$this->assign('page_id', 'admin-shops-edit');
$this->assign('title', 'ショップ編集');
?>

<?php $this->start('sidebar'); ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <?= __('Actions') ?>
    </div>

    <ul class="list-group">
        <li class="list-group-item">
            <?= $this->Form->postLink('ショップ削除', ['action' => 'delete', $shop->id], ['confirm' => __('Are you sure you want to delete # {0}?', $shop->id)]) ?>
        </li>
        <li class="list-group-item">
            <?= $this->Html->link('ショップ一覧', ['action' => 'index']) ?>
        </li>
    </ul>
</div>
<?php $this->end(); ?>

<h2><?= $this->fetch('title') ?></h2>

<div class="spacer30">
    <?= $this->Form->create($shop); ?>
        <?= $this->element('Shops/form'); ?>
        <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
