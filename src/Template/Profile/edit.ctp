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

$this->assign('page_id', 'profile-edit');
$this->assign('title', 'プロフィール編集');
?>

<h2><?= $this->fetch('title') ?></h2>

<div class="row spacer30">
    <div class="col-md-6">
        <?= $this->Html->image($profile->photoPath, ["class" => "thumbnail center-block"]); ?>

        <?= $this->element('grid_button', [
            'buttons' => [
                ['label' => '戻る', 'url' => $this->Url->build(['action' => 'view'])],
            ],
        ]) ?>
    </div>

    <div class="col-md-6">
        <?= $this->Form->create($profile, ['type' => 'file']); ?>
            <fieldset>
                <?php
                echo $this->Form->control('photo', [
                    'label' => '写真アップロード',
                    'type' => 'file',
                    'class' => "spacer5",
                ]);
                echo $this->Form->control('nickname', [
                    'label' => 'ニックネーム *',
                    'placeholder' => 'システム内で表示される、名前です。',
                    'autofocus' => true,
                ]);
                echo $this->Form->control('email', ['label' => __d('CakeDC/Users', 'Email') . ' *']);
                echo $this->Form->control('introduction', ['label' => '自己紹介', 'type' => 'textarea']);
                echo $this->Form->control('birthday', [
                    'label' => '誕生日',
                    'empty' => ['year' => '年', 'month' => '月', 'day' => '日'],
                    'minYear' => 1950,
                    'maxYear' => date('Y'),
                    'orderYear' => 'asc',
                ]);
                ?>
            </fieldset>
            <?= $this->Form->button('登録', ['class' => 'btn-primary btn-block']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
