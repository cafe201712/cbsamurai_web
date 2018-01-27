<?php
echo $this->Form->control('title', ['label' => 'タイトル', 'autofocus' => true]);
echo $this->Form->control('description', ['label' => '概要']);
echo $this->Form->control('content', ['label' => '本文']);
echo $this->Form->control('release_date', [
    'label' => '公開日',
    'orderYear' => 'asc',
]);
