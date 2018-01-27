<?php
$this->extend('base');
?>

<?= $this->element('navbar'); ?>
<?= $this->fetch('page-header') ?>

<div id="page-contents">
    <div class="container clearfix">
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
    </div>
</div>

<?= $this->element('footer') ?>
