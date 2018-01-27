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

$this->layout = 'leftbar';

$this->assign('page_id', 'admin-users-edit');
$this->assign('title', 'ユーザー編集');
?>

<?php $this->start('sidebar'); ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <?= __d('CakeDC/Users', 'Actions') ?>
    </div>

    <ul class="list-group">
        <li class="list-group-item">
            <?php
            echo $this->Form->postLink(
                __d('CakeDC/Users', 'Delete'),
                ['action' => 'delete', $user->id],
                ['confirm' => __d('CakeDC/Users', 'Are you sure you want to delete # {0}?', $user->id)]
            );
            ?>
        </li>
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

