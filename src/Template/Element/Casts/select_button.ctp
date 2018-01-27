<?php

if (isset($login_user) and $login_user->isUser() ) {
    $class = $class ?? 'btn btn-default btn-sm';

    // 「いいね」されていない時は、永久指名関連のボタンは表示しない
    if ($isLiked) {
        if ($isSelected) {
            echo "<button class=\"${class}\" disabled>永久指名済</button>";
        } else {
            echo $this->Form->postLink('永久指名',
                ['controller' => 'casts', 'action' => 'select', $cast->id],
                ['class' => $class, 'confirm' => '本当に永久指名してよろしいですか？']
            );
        }
    }
}
