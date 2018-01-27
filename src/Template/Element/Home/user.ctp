<div>
    <div class="pull-left">
        <?= $this->Html->link(
            $this->Html->image($user->thumbnailPath, ['class' => 'thumbnail trim-150']),
            "/messages/$user->id?page=last",
            ['escapeTitle' => false]
        ); ?>
    </div>
    <div class="user-desc">
        <h3 class="spacer10">
            <?= $this->Html->link(
                $user->nickname,
                "/messages/$user->id?page=last"
            ); ?>
        </h3>
        <div class="spacer15">
            <?php if ($user->isCast()): ?>
                <p>
                    <?= h($user->shop->pref) ?> <?= h($user->shop->area) ?><br>
                    <?= h($user->shop->name) ?>
                </p>
            <?php endif; ?>

            <a href="<?= $this->Url->build("/messages/$user->id?page=last") ?>" class="btn btn-default btn-sm">
                メッセージ
                <?= $this->element('Home/unread_label', ['count' => count($user->sent_messages)]); ?>
            </a>

            <?php if ($login_user->isUser()): ?>
                <?= $this->Html->link('プロフィール',
                    ['controller' => 'Casts', 'action' => 'view', $user->id],
                    ['class' => 'btn btn-default btn-sm']);
                ?>
            <?php else: ?>
                <a href="<?= $this->Url->build(['controller' => 'Guests', 'action' => 'view', $user->id]) ?>" class="btn btn-default btn-sm">
                    プロフィール <?= $this->element('Home/tickets_label', ['format' => '%d', 'num_of_tickets' => $like->num_of_tickets]) ?>
                </a>
            <?php endif; ?>

            <?php if ($login_user->isUser() && $select_button): ?>
                <?= $this->Form->postLink('永久指名',
                    ['controller' => 'Casts', 'action' => 'select', $user->id],
                    ['class' => 'btn btn-default btn-sm', 'confirm' => '本当に永久指名してよろしいですか？']
                ); ?>
            <?php endif; ?>
        </div>
    </div>
</div>
