<?= $this->Form->create(null); ?>
<div class="send-message">
    <div class="form-group">
        <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="キーワード" autofocus
                   value="<?= $this->request->getQuery('q'); ?>">
            <span class="input-group-btn">
                    <button type="submit" class="btn btn-default">
                      <span class="glyphicon glyphicon-search" aria-hidden="true"></span> 検索
                    </button>
                </span>
        </div>
    </div>
</div>
<?= $this->Form->end() ?>
