<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Shop[]|\Cake\Collection\CollectionInterface $shops
  */
use Cake\Core\Configure;

$this->layout = 'leftbar';

$this->assign('page_id', 'admin-shops-index');
$this->assign('title', 'ショップ一覧');

$shop_name_len = Configure::read('AppLocal.DisplayShopNameLength', 40);
?>

<?php $this->start('sidebar'); ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <?= __('Actions') ?>
        </div>

        <ul class="list-group">
            <li class="list-group-item">
                <?= $this->Html->link('新規ショップ', ['action' => 'add']) ?>
            </li>
        </ul>
    </div>
<?php $this->end(); ?>

<h2><?= $this->fetch('title') ?></h2>

<div class="spacer30">
    <?= $this->element('search_form'); ?>
</div>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id', 'ID') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name', '店名') ?></th>
                <th scope="col" class="pref"><?= $this->Paginator->sort('pref', '都道府県') ?></th>
                <th scope="col"><?= $this->Paginator->sort('area', 'エリア') ?></th>
                <th scope="col" class="actions">操作</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($shops as $shop): ?>
            <tr>
                <td><?= h($shop->id) ?></td>
                <td><?= $this->Html->link(mb_strimwidth($shop->name, 0, $shop_name_len, '...'), ['action' => 'view', $shop->id]) ?></td>
                <td><?= h($shop->pref) ?></td>
                <td><?= h($shop->area) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $shop->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $shop->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $shop->id], ['confirm' => __('Are you sure you want to delete # {0}?', $shop->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="text-center">
<?= $this->Paginator->numbers([
    'prev' => '< 前',
    'next' => '次 >',
]); ?>

<p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
</div>
