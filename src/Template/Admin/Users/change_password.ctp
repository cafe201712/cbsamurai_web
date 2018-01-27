<?php
$this->assign('page_id', 'admin-users-change_password');
$this->assign('title', 'パスワード変更');
?>

<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <h2><?= $this->fetch('title') ?></h2>

        <div class="users form spacer30">
            <?= $this->Form->create($user) ?>
            <fieldset>
                <?php if ($validatePassword) : ?>
                    <?= $this->Form->control('current_password', [
                        'type' => 'password',
                        'required' => true,
                        'autofocus' => true,
                        'label' => __d('CakeDC/Users', 'Current password')]);
                    ?>
                <?php endif; ?>
                <?= $this->Form->control('password', [
                    'type' => 'password',
                    'required' => true,
                    'label' => __d('CakeDC/Users', 'New password')]);
                ?>
                <?= $this->Form->control('password_confirm', [
                    'type' => 'password',
                    'required' => true,
                    'label' => __d('CakeDC/Users', 'Confirm password')]);
                ?>
            </fieldset>
            <?= $this->Form->button(__d('CakeDC/Users', 'Submit')); ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
    <div class="col-md-3"></div>
</div>

