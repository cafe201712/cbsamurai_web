<?php
$this->setLayout('base');

$this->assign('page_id', 'pages-top');
$this->assign('title', 'top');

$carousel_images = [
    '/img/t1.png',
    '/img/t2.png',
    '/img/t3.png',
];

$cb_images = [
    '/img/p1.png',
    '/img/p2.png',
    '/img/p3.png',
    '/img/p4.png',
    '/img/p5.png',
    '/img/p6.png',
    '/img/p7.png',
    '/img/p8.png',
];
?>

<?= $this->element('navbar'); ?>
<?= $this->element('carousel', ['images' => $carousel_images]); ?>

<div class="container">
    <div class="row row-eq-height spacer30">
        <?php foreach ($cb_images as $cb_image): ?>
        <div class="col-xs-6 col-sm-3">
            <div class="thumbnail"  style="background:#DDDDDD;">
                <a href="<?= $this->Url->build('/register'); ?>">
                    <img src="<?= $cb_image ?>" />
                </a>
                <div class="caption">
                    <?= $this->Html->link('　いいね　', '/register', ['class' => 'btn btn-success btn-block']); ?>
                </div>
            </div>
        </div><!-- col -->
        <?php endforeach; ?>
    </div>
</div>

<div class="spacer10">
    <?= $this->element('footer_bar'); ?>
</div>

