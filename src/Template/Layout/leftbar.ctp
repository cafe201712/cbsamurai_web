<?php
$this->extend('default');
?>

<div class="row">
    <div class="col-md-3">
        <?= $this->fetch('sidebar') ?>
    </div>
    <div class="col-md-9">
        <?= $this->fetch('content') ?>
    </div>
</div>

