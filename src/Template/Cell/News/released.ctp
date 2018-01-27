<div id="news-list">
    <ul style="padding-left: 0;">
        <?php foreach ($news as $post): ?>
            <li class="spacer30">
                <a href="<?= $this->Url->build(['controller' => 'News', 'action' => 'view', $post->id]); ?>">
                    <h4><?= h($post->title); ?></h4>
                </a>
                <?= $this->Markdown->parse(h($post->description)); ?>
                <small>(<?= $post->release_date ?>)</small>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
