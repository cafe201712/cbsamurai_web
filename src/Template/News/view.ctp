<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\News $news
  */

$this->assign('page_id', 'news-view');
$this->assign('title', h($news->title));
?>

<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <h2><?= h($news->title) ?></h2>

        <div class="spacer30">
            <?= $this->Markdown->parse(h($news->description)); ?>
            <?= $this->Markdown->parse(h($news->content)); ?>
        </div>

        <div class="clearfix">
            <p class="pull-right">
                <?= $news->release_date ?>
            </p>
        </div>

        <hr>
        <?= $this->Html->link('戻る', $this->request->referer(), ['class' => 'btn btn-default']); ?>
    </div>
    <div class="col-md-2"></div>
</div>
