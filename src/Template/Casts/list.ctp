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

$this->assign('page_id', 'casts-list');
$this->assign('title', 'キャバ嬢一覧');
?>

<h2><?= $this->fetch('title') ?></h2>

<div class="spacer30">
    <?= $this->element('search_form'); ?>
</div>

<?= $this->element('Casts/tab', ['active' => 'list']); ?>

<div class="row row-eq-height spacer10">
    <?php foreach ($casts as $cast): ?>
    <div class="col-xs-12 col-sm-6 spacer10">
        <div class="media">
            <div class="media-left">
                <?= $this->Html->link(
                    $this->Html->image($cast->thumbnailPath, ['class' => 'thumbnail trim-150']),
                    ['action' => 'view', $cast->id],
                    ['escapeTitle' => false]
                ); ?>
            </div>
            <div class="media-body">
                <h3 class="media-heading spacer10">
                    <?= $this->Html->link(
                        h($cast->nickname),
                        ['action' => 'view', $cast->id]
                    ); ?>
                </h3>
                <div class="spacer15">
                    <p><?= h($cast->shop->pref) ?> <?= h($cast->shop->area) ?></p>
                    <p><?= h($cast->shop->name) ?></p>

                    <?= $this->Html->link('プロフィール', ['action' => 'view', $cast->id], ['class' => 'btn btn-default btn-sm']); ?>
                    <?= $this->element('Casts/like_button', ['cast' => $cast, 'isLiked' => false]); ?>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<div class="text-center spacer20">
    <?= $this->Paginator->numbers([
        'prev' => '< 前',
        'next' => '次 >',
    ]); ?>

    <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
</div>
