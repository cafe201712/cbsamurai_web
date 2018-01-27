<?php
$this->layout = 'rightbar';

$this->assign('page_id', 'home-index');
$this->assign('title', 'ホーム');
?>

<?php $this->start('sidebar'); ?>
<div class="hidden-sm spacer20">
    <h3>お知らせ</h3>
    <div class="spacer30">
        <?= $this->cell('News::released', [10])->render(); ?>
    </div>
</div>
<?php $this->end(); ?>

<?php if (count($selections) > 0): ?>
    <h3>永久指名一覧 <span class="badge"><?= count($selections) ?></span></h3>
    <?= $this->element('Home/user-list', ['likes' => $selections, 'select_button' => false]); ?>
    <hr>
<?php endif; ?>

<h3>いいね一覧 <span class="badge"><?= count($likes) ?></span></h3>
<?= $this->element('Home/nolike_alert'); ?>
<?= $this->element('Home/user-list', ['likes' => $likes, 'select_button' => true]); ?>
