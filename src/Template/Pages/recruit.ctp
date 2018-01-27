<?php
$this->setLayout('page');

$this->assign('page_id', 'pages-recruit');
$this->assign('title', '採用情報');
?>

<p class="spacer30">
    現在、採用は行っておりませんが、我こそはと思う方は
    <?= $this->Html->link('コンタクトページ', ['controller' => 'contact', 'action' => 'index']); ?> からご連絡ください。
</p>
