<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Message[]|\Cake\Collection\CollectionInterface $messages
  */
$this->assign('page_id', 'messages-index');
$this->assign('title', 'メッセージ');
?>

<?php if (count($messages) === 0): ?>
    <div class="alert alert-info">
        <p class="lead">
            まだ、メッセージがありません。<br>
            <?php if ($login_user->isUser()): ?>
                <?= $from_user->nickname ?>にメッセージを送ってみましょう。
            <?php else: ?>
                <?= $from_user->nickname ?>様にメッセージを送ってみましょう。
            <?php endif; ?>
        </p>
    </div>
<?php endif; ?>

<div class="row chat-room">
    <div class="col-md-8 col-md-offset-2">
        <h2><?= $from_user->nickname ?> さんとのメッセージ</h2>

        <div class="chat-body spacer20">
            <ul class="chat-message">
                <?php foreach ($messages as $message): ?>
                    <?php
                    if ($message->isFrom($from_user->id)) {
                        $pull = 'left';
                        $controller = $from_user->isCast() ? 'casts' : 'guests';
                        $url = $this->Url->build(['controller' => $controller, 'action' => 'view', $from_user->id]);
                    } else {
                        $pull = 'right';
                        $url = $this->Url->build(['controller' => 'profile', 'action' => 'view']);
                    }
                    ?>
                    <li class="<?= $pull ?>">
                        <?php if ($message->isFrom($from_user->id)): ?>
                            <a href="<?= $url ?>">
                                <img src="<?= $from_user->thumbnailPath ?>" alt="<?= $from_user->nickname ?>" class="profile-photo-sm pull-<?= $pull ?> trim-message-icon">
                            </a>
                        <?php endif; ?>
                        <div class="chat-item">
                            <p><?= h($message->body) ?></p>
                            <div class="text-right">
                                <small class="text-muted">
                                    <?php if ($message->isTo($login_user->id) and empty($message->read_at)): ?>
                                        <span class="label label-success">New</span>
                                    <?php endif; ?>
                                    <?= $message->created->timeAgoInWords() ?>
                                </small>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <?= $this->Form->create($new_message) ?>
        <div class="send-message">
            <div class="form-group <?= $new_message->getError('body') ? 'has-error' : '' ?>">
                <div class="input-group">
                    <input type="text" name="body" class="form-control" placeholder="メッセージ" required autofocus>
                    <span class="input-group-btn">
                        <input class="btn btn-default" type="submit" value="送信">
                    </span>
                </div>
                <div class="help-block"><?= $new_message->getError('body') ? current($new_message->getError('body')) : '' ?></div>
            </div>
        </div>
        <?= $this->Form->end() ?>

        <?php if (isset($like)): ?>
            <div class="clearfix spacer10">
                <?= $this->element('Home/tickets_label', [
                    'format' => 'チケット残： %d 枚',
                    'num_of_tickets' => $like->num_of_tickets,
                    'class' => 'pull-right',
                ]) ?>
            </div>
        <?php endif; ?>

        <div class="text-center spacer20">
            <?= $this->Paginator->numbers([
                'prev' => '< 前',
                'next' => '次 >',
            ]); ?>

            <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
        </div>
    </div>
</div>

<hr>
<div class="text-center">
    <?= $this->Html->link('戻る',
        ['controller' => 'Home', 'action' => 'index'],
        ['class' => 'btn btn-default']
    ); ?>
</div>

