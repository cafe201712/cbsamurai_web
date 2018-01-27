<div class="row">
    <?php foreach ($buttons as $button): ?>
        <div class="col-md-4 spacer10">
            <?php
            if (isset($button['html'])) {
                echo $button['html'];
            } else {
                $options = ['class' => 'btn btn-default btn-block'];
                $options = array_merge($options, $buttons['options'] ?? []);

                echo $this->Html->link($button['label'], $button['url'], $options);
            }
            ?>
        </div>
    <?php endforeach; ?>
</div>
