<?php if (count($likes) + count($selections) === 0): ?>
    <div class="alert alert-info spacer20">
        <?php if ($login_user->isCast()): ?>
            <p class="lead">
                まだ、「いいね」してくれたお客様がいません。<br>
                積極的に営業して、「いいね」を集めましょう。
            </p>
        <?php else: ?>
            <p class="lead">
                まだ、「いいね」したキャバ嬢がいません。<br>
                キャバ嬢のページからお気に入りの子に「いいね」して、<br>
                メッセージ交換をしましょう。
            </p>
        <?php endif; ?>
    </div>
<?php endif; ?>
