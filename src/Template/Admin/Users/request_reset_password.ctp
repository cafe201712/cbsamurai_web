<?php
$this->assign('page_id', 'admin-users-request_reset_password');
$this->assign('title', 'パスワード変更リクエスト');
?>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h2><?= $this->fetch('title') ?></h2>

        <div class="users form spacer20">
            <?= $this->Form->create('User') ?>
                <?= $this->Form->control('reference', [
                    'label' => 'メールアドレス',
                    'placeholder' => 'パスワードを変更する方のメールアドレスを入力してください。',
                    'autofocus' => true,
                ]) ?>
                <?= $this->Form->button(__d('CakeDC/Users', 'Submit')); ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
