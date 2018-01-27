<div class="row row-eq-height">
    <?php foreach ($likes as $like): ?>
        <div class="col-sm-6 spacer20">
            <?php $user = $login_user->isCast() ? $like->guest : $like->cast ?>
            <?= $this->element('Home/user', ['user' => $user, 'like' => $like, 'select_button' => $select_button]); ?>
        </div>
    <?php endforeach; ?>
</div>
