<?php
use App\Model\Entity\User;

$roles = User::ROLES;
unset($roles['superuser']);  // superuser は登録出来ないよう、外す
?>

<?= $this->Form->create($user, ['type' => 'file']); ?>
<fieldset>
    <?php
    if (!$user->isNew()) {
        echo $this->Html->image($user->photoPath, ["class" => "thumbnail"]);
        echo $this->Form->control('photo', [
            'label' => '写真アップロード',
            'type' => 'file',
            'class' => "spacer5",
        ]);
    }

    echo $this->Form->control('email', ['label' => __d('CakeDC/Users', 'Email') . ' *']);
    if (empty($user->id)) {
        echo $this->Form->control('password', [
            'label' => __d('CakeDC/Users', 'Password') . ' *',
            'placeholder' => '8 文字以上入力してください。',
        ]);
    }
    if ($login_user->isSuperUser()) {
        echo $this->Form->control('role', [
            'label' => 'ユーザータイプ *',
            'type' => 'select',
            'options' => $roles,
            'default' => "cast",
        ]);
        echo $this->cell('Shops::selectbox', [
            $this->Form,      // form
            'shop_id',        // field_name
            '所属ショップ *',   // label
        ])->render();
    }

    echo $this->Form->control('nickname', [
        'label' => 'ニックネーム *',
        'placeholder' => 'システム内で表示される、名前です。',
    ]);
    echo $this->Form->control('introduction', ['label' => '自己紹介', 'type' => 'textarea']);
    echo $this->Form->control('birthday', [
        'label' => '誕生日',
        'empty' => ['year' => '年', 'month' => '月', 'day' => '日'],
        'minYear' => 1950,
        'maxYear' => date('Y') - 18,
        'orderYear' => 'asc',
    ]);
    echo $this->Form->control('active', [
        'type' => 'checkbox',
        'label' => __d('CakeDC/Users', 'Active'),
        'default' => true,
    ]);
    ?>
</fieldset>
<?= $this->Form->button(__d('CakeDC/Users', 'Submit')) ?>
<?= $this->Form->end() ?>
