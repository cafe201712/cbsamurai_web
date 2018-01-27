<?php

if (isset($login_user) and $login_user->isUser() ) {
    $class = $class ?? 'btn btn-default btn-sm';

    if ($isLiked) {
        echo "<button class=\"${class}\" disabled>いいね済</button>";
    } else {
        echo $this->Form->postLink('いいね',
            ['controller' => 'casts', 'action' => 'like', $cast->id],
            ['class' => $class, 'confirm' => '本当に「いいね」してよろしいですか？']
        );
    }
}
