<?php
use App\Model\Entity\Invitation;

$types = Invitation::TYPES;
?>

<?= $this->Form->create($invitation); ?>
<fieldset>
    <?php
    echo $this->Form->control('name', [
        'label' => '招待状名 *',
        'placeholder' => '招待内容がわかる名称を入力してください。',
        'autofocus' => true,
    ]);
    echo $this->Form->control('type', [
        'label' => 'タイプ *',
        'type' => 'select',
        'options' => $types,
        'default' => "user",
    ]);
	if ($login_user->isSuperUser()) {
		echo $this->cell('Shops::selectbox', [
			$this->Form,	// form
			'shop_id',		// field_name
			'ショップ *',	// label
		])->render();
	}
    echo $this->Form->control('active', [
        'type' => 'checkbox',
        'label' => '有効',
        'default' => true,
    ]);
    ?>
</fieldset>
<?= $this->Form->button(__d('CakeDC/Users', 'Submit')) ?>
<?= $this->Form->end() ?>
