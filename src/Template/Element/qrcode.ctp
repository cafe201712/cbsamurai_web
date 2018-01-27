<div class="row text-center">
    <?= $qrcode ?>

    <form class="form-horizontal">
        <div class="form-group" style="margin: 0;">
            <div class="input-group" style="margin: 0 30px;">
                <input type="text" id="copy-target" class="form-control" value="<?= $invitation->url ?>" readonly>
                <span class="input-group-btn">
                    <button id="copy-btn" class="btn btn-default" data-clipboard-target="#copy-target">
                        <i class="fa fa-clipboard" aria-hidden="true"></i> Copy
                    </button>
                </span>
            </div>
        </div>
    </form>

    <div class="spacer20">
        <?= $this->Form->postLink('画像ダウンロード', [
            'controller' => 'invitations',
            'action' => 'download',
            'prefix' => 'admin',
            $invitation->id
        ], ['class' => 'btn btn-default']) ?>
    </div>
</div>
