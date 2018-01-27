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
use Cake\Core\Configure;

$this->layout = 'login_register';

$this->assign('page_id', 'admin-users-register');
$this->assign('title', 'ユーザー登録');
$this->set('activeLink', 'register');
?>

<?php $this->start('register'); ?>
    <?= $this->Flash->render() ?>
    <h2>
        <?= (isset($invitation) && $invitation->isTypeCast()) ? 'キャバ嬢登録' : '今すぐ登録を!!'; ?>
    </h2>
    <p><?= $this->Html->link('既にアカウントはお持ちですか？', ['action' => 'login']); ?></p>

    <!--Register Form-->
    <?= $this->Form->create($user, [
        'novalidate' => true,
        'id' => 'registration_form',
        'class'=> 'form-inline',
    ]); ?>
    <fieldset>
        <?= $this->Form->control('email', [
            'label' => false,
            'required' => true,
            'placeholder' => 'メールアドレス',
        ]) ?>
        <?= $this->Form->control('password', [
            'label' => false,
            'required' => true,
            'placeholder' => 'パスワード（8 文字以上）',
        ]) ?>
        <?= $this->Form->control('password_confirm', [
            'type' => 'password',
            'label' => false,
            'required' => true,
            'placeholder' => 'パスワード（確認用）',
        ]) ?>
        <?= $this->Form->control('nickname', [
            'label' => false,
            'required' => true,
            'placeholder' => 'ニックネーム（他の人に表示される名前）',
        ]) ?>
        <?php
        if (Configure::read('Users.Tos.required')) {
            echo $this->Form->control('tos', [
                'type' => 'checkbox',
                'label' => " " . __d('CakeDC/Users','Accept TOS conditions?'),
                'required' => true
            ]);
        }
        if (Configure::read('Users.reCaptcha.registration')) {
            echo $this->User->addReCaptcha();
        }
        ?>
        <?= $this->Form->button(__d('CakeDC/Users', 'Submit'), [
            'class' => "btn btn-cb-primary btn-block spacer20",
        ]); ?>
    </fieldset>
    <?= $this->Form->end(); ?>

    <div class="spacer20">
        <?= $this->Html->link('登録確認メールを再送', ['action' => 'resendValidationEmail']); ?>
    </div>
<?php $this->end('end'); ?>
