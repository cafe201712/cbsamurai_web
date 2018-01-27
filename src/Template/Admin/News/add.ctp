<?php
/**
  * @var \App\View\AppView $this
  */

$this->layout = 'leftbar';

$this->assign('page_id', 'admin-news-add');
$this->assign('title', 'ニュース登録');
?>

<?php $this->start('sidebar'); ?>
<div class="panel panel-default">
    <div class="panel-heading">操作</div>

    <ul class="list-group">
        <li class="list-group-item">
            <?= $this->Html->link('ニュース一覧', ['action' => 'index']) ?>
        </li>
    </ul>
</div>
<?php $this->end(); ?>

<h2><?= $this->fetch('title') ?></h2>

<div class="spacer30">
    <?= $this->Form->create($news); ?>
        <?= $this->element('News/form'); ?>
        <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
