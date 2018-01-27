<?php
$this->assign('page_id', 'admin-users-resend_validation_email');
$this->assign('title', 'ユーザー登録確認メール再送');
?>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h2><?= $this->fetch('title') ?></h2>

        <div class="users form spacer20">
            <?= $this->Form->create('User') ?>
                <?= $this->Form->control('email', [
                    'label' => 'メールアドレス',
                    'autofocus' => true,
                ]) ?>
                <?= $this->Form->button(__d('CakeDC/Users', 'Submit')); ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
