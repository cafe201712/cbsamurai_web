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

$this->assign('page_id', 'casts-index');
$this->assign('title', 'キャバ嬢一覧');

$count = count($casts);
?>

<h2><?= $this->fetch('title') ?></h2>

<div class="spacer30">
    <?= $this->element('search_form'); ?>
</div>

<?= $this->element('Casts/tab', ['active' => 'grid']); ?>

<div class="row row-eq-height spacer10">
    <?php foreach ($casts as $key => $cast): ?>
    <div class="col-xs-6 col-sm-3">
        <div class="thumbnail">
            <?= $this->Html->link(
                $this->Html->image($cast->thumbnailPath),
                ['action' => 'view', $cast->id],
                ['escapeTitle' => false]
            ); ?>
            <div class="caption">
                <h3>
                    <?= $this->Html->link(
                        h($cast->nickname),
                        ['action' => 'view', $cast->id]
                    ); ?>
                </h3>
                <p><?= h($cast->shop->pref) ?> <?= h($cast->shop->area) ?></p>
                <p><?= h($cast->shop->name) ?></p>

                <?= $this->Html->link('プロフィール', ['action' => 'view', $cast->id], ['class' => 'btn btn-default btn-sm']); ?>
                <?= $this->element('Casts/like_button', ['cast' => $cast, 'isLiked' => false]); ?>
            </div>
        </div>
    </div><!-- col -->
    <?php endforeach; ?>
</div><!-- row -->

<div class="text-center">
    <?= $this->Paginator->numbers([
        'prev' => '< 前',
        'next' => '次 >',
    ]); ?>

    <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
</div>


