<?php
use App\Model\Entity\User;

$roles = User::ROLES;
?>

<h3>プロフィール</h3>

<table class="table table-striped">
    <tr>
        <th><?= __d('CakeDC/Users', 'Id') ?></th>
        <td><?= h($user->id) ?></td>
    </tr>
    <tr>
        <th><?= __d('CakeDC/Users', 'Email') ?></th>
        <td><?= h($user->email) ?></td>
    </tr>
    <tr>
        <th>ニックネーム</th>
        <td><?= h($user->nickname) ?></td>
    </tr>
    <tr>
        <th><?= __d('CakeDC/Users', 'Role') ?></th>
        <td>
            <?= $this->element('Users/role_icon', ['role' => $user->role]); ?>
            <?= $roles[h($user->role)] ?>
        </td>
    </tr>
    <tr>
        <th>状態</th>
        <td><?= $this->element('active_label', ['entity' => $user]); ?></td>
    </tr>
</table>

<table class="table table-striped spacer50">
    <tr>
        <th>自己紹介</th>
        <td><pre class="pre_clear_style"><?= h($user->introduction) ?></pre></td>
    </tr>
    <tr>
        <th>誕生日</th>
        <td><?= h($user->birthday) ?></td>
    </tr>
</table>

