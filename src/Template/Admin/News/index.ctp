<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\News[]|\Cake\Collection\CollectionInterface $news
  */

$this->layout = 'leftbar';

$this->assign('page_id', 'admin-news-index');
$this->assign('title', 'ニュース一覧');
?>

<?php $this->start('sidebar'); ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <?= __('Actions') ?>
    </div>

    <ul class="list-group">
        <li class="list-group-item">
            <?= $this->Html->link('新規ニュース', ['action' => 'add']) ?>
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
            <th scope="col"><?= $this->Paginator->sort('title', 'タイトル') ?></th>
            <th scope="col" class="date"><?= $this->Paginator->sort('release_date', '公開日') ?></th>
            <th scope="col" class="date"><?= $this->Paginator->sort('created', '作成日') ?></th>
            <th scope="col" class="actions">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($news as $post): ?>
            <tr>
                <td><?= h($post->id) ?></td>
                <td><?= $this->Html->link($post->title, ['action' => 'view', $post->id]) ?></td>
                <td><?= $post->release_date ?></td>
                <td><?= $post->createdDate ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $post->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $post->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $post->id], ['confirm' => __('Are you sure you want to delete # {0}?', $post->id)]) ?>
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

