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

$this->layout = 'leftbar';

$this->assign('page_id', 'admin-users-add');
$this->assign('title', 'ユーザー登録');
?>

<?php $this->start('sidebar'); ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <?= __d('CakeDC/Users', 'Actions') ?>
    </div>

    <ul class="list-group">
        <li class="list-group-item">
            <?= $this->Html->link(__d('CakeDC/Users', 'List Users'), ['action' => 'index']) ?>
        </li>
    </ul>
</div>
<?php $this->end(); ?>

<h2><?= $this->fetch('title') ?></h2>

<div class="spacer30">
    <?= $this->element('Users/form', ['user' => $user]); ?>
</div>

