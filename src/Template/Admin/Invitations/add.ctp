<?php
/**
  * @var \App\View\AppView $this
  */

$this->layout = 'leftbar';

$this->assign('page_id', 'admin-invitations-add');
$this->assign('title', '招待状登録');
?>

<?php $this->start('sidebar'); ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <?= __('Actions') ?>
    </div>

    <ul class="list-group">
        <li class="list-group-item">
            <?= $this->Html->link('招待状一覧', ['action' => 'index']) ?>
        </li>
    </ul>
</div>
<?php $this->end(); ?>

<h2><?= $this->fetch('title') ?></h2>

<div class="spacer30">
    <?= $this->element('Invitations/form', ['invitation' => $invitation]); ?>
</div>
