<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Shop $shop
  */

$this->layout = 'leftbar';

$this->assign('page_id', 'admin-shops-view');
$this->assign('title', 'ショップ表示');
?>

<?php $this->start('sidebar'); ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <?= __('Actions') ?>
        </div>

        <ul class="list-group">
            <li class="list-group-item">
                <?= $this->Html->link('ショップ編集', ['action' => 'edit', $shop->id]) ?>
            </li>
            <li class="list-group-item">
                <?= $this->Form->postLink('ショップ削除', ['action' => 'delete', $shop->id], ['confirm' => __('Are you sure you want to delete # {0}?', $shop->id)]) ?>
            </li>
            <li class="list-group-item">
                <?= $this->Html->link('ショップ一覧', ['action' => 'index']) ?>
            </li>
            <li class="list-group-item">
                <?= $this->Html->link('新規ショップ', ['action' => 'add']) ?>
            </li>
        </ul>
    </div>
<?php $this->end(); ?>

<h2><?= h($shop->name) ?></h2>

<table class="table table-striped view spacer30">
    <tr>
        <th scope="row">ID</th>
        <td><?= h($shop->id) ?></td>
    </tr>
    <tr>
        <th scope="row">店名</th>
        <td><?= h($shop->name) ?></td>
    </tr>
    <tr>
        <th scope="row">詳細説明</th>
        <td><pre class="pre_clear_style"><?= h($shop->description) ?></pre></td>
    </tr>
    <tr>
        <th scope="row">郵便番号</th>
        <td><?= h($shop->zip) ?></td>
    </tr>
    <tr>
        <th scope="row">都道府県</th>
        <td><?= h($shop->pref) ?></td>
    </tr>
    <tr>
        <th scope="row">エリア</th>
        <td><?= h($shop->area) ?></td>
    </tr>
    <tr>
        <th scope="row">住所１</th>
        <td><?= h($shop->address1) ?></td>
    </tr>
    <tr>
        <th scope="row">住所２</th>
        <td><?= h($shop->address2) ?></td>
    </tr>
    <tr>
        <th scope="row">TEL</th>
        <td><?= h($shop->tel) ?></td>
    </tr>
    <tr>
        <th scope="row">FAX</th>
        <td><?= h($shop->fax) ?></td>
    </tr>
</table>
