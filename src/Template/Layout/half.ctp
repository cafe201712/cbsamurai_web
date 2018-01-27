<?php
$this->extend('default');
?>

<?= $this->fetch('contents-header'); ?>

<div class="row spacer30">
    <div class="col-md-6">
        <?= $this->fetch('left-side') ?>
    </div>
    <div class="col-md-6">
        <?= $this->fetch('right-side') ?>
    </div>
</div>

<?= $this->fetch('contents-footer'); ?>
