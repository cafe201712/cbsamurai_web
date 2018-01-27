<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\News $news
  */

$this->layout = 'leftbar';

$this->assign('page_id', 'admin-news-view');
$this->assign('title', 'ニュース表示');
?>

<?php $this->start('sidebar'); ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <?= __('Actions') ?>
    </div>

    <ul class="list-group">
        <li class="list-group-item">
            <?= $this->Html->link('ニュース編集', ['action' => 'edit', $news->id]) ?>
        </li>
        <li class="list-group-item">
            <?= $this->Form->postLink('ニュース削除', ['action' => 'delete', $news->id], ['confirm' => __('Are you sure you want to delete # {0}?', $news->id)]) ?>
        </li>
        <li class="list-group-item">
            <?= $this->Html->link('ニュース一覧', ['action' => 'index']) ?>
        </li>
        <li class="list-group-item">
            <?= $this->Html->link('新規ニュース', ['action' => 'add']) ?>
        </li>
    </ul>
</div>
<?php $this->end(); ?>

<h2><?= h($news->title); ?></h2>

<table class="table table-striped view spacer30">
    <tr>
        <th scope="row">ID</th>
        <td><?= h($news->id) ?></td>
    </tr>
    <tr>
        <th scope="row">タイトル</th>
        <td><?= h($news->title) ?></td>
    </tr>
    <tr>
        <th scope="row">概要</th>
        <td>
            <?= $this->Markdown->parse(h($news->description)); ?>
        </td>
    </tr>
    <tr>
        <th scope="row">本文</th>
        <td>
            <?= $this->Markdown->parse(h($news->content)); ?>
        </td>
    </tr>
    <tr>
        <th scope="row">公開日</th>
        <td><?= $news->release_date ?></td>
    </tr>
    <tr>
        <th scope="row">更新日</th>
        <td><?= $news->modified ?></td>
    </tr>
    <tr>
        <th scope="row">作成日</th>
        <td><?= $news->created ?></td>
    </tr>
</table>
