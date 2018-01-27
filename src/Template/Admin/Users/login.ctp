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

$this->assign('page_id', 'admin-users-login');
$this->assign('title', 'ログイン');
$this->set('activeLink', 'login');
?>

<?php $this->start('register'); ?>
    <?= $this->Flash->render() ?>

    <h2><?= $this->fetch('title') ?></h2>

    <p class="text-muted">メールアドレスとパスワードを入力してください</p>

    <!--Login Form-->
    <?= $this->Form->create(null, [
        'novalidate' => false,
        'id' => 'registration_form',
        'class' => 'form-inline',
    ]); ?>
    <fieldset>
        <?= $this->Form->control('email', [
            'label' => false,
            'required' => true,
            'autofocus' => true,
            'placeholder' => 'メールアドレス',
        ]) ?>
        <?= $this->Form->control('password', [
            'label' => false,
            'required' => true,
            'placeholder' => 'パスワード',
        ]) ?>
        <?php
        if (Configure::read('Users.reCaptcha.login')) {
            echo $this->User->addReCaptcha();
        }
        if (Configure::read('Users.RememberMe.active')) {
            echo $this->Form->control(Configure::read('Users.Key.Data.rememberMe'), [
                'type' => 'checkbox',
                'label' => ' ' . __d('CakeDC/Users', 'Remember me'),
                'checked' => Configure::read('Users.RememberMe.checked')
            ]);
        }
        ?>
        <?= $this->Form->button(__d('CakeDC/Users', 'Login'),[
            'class'=>'btn btn-cb-primary btn-block spacer20'
        ]); ?>
    </fieldset>
    <?= $this->Form->end() ?>

    <div class="spacer20">
        <?php
        $registrationActive = Configure::read('Users.Registration.active');
        if ($registrationActive) {
            echo $this->Html->link(__d('CakeDC/Users', 'Register'), ['action' => 'register']);
        }
        if (Configure::read('Users.Email.required')) {
            if ($registrationActive) {
                echo ' | ';
            }
            echo $this->Html->link('パスワードを忘れた', ['action' => 'requestResetPassword']);
        }
        ?>
    </div>
<?php $this->end('end'); ?>
