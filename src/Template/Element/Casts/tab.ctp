<div class="spacer30">
    <ul class="nav nav-tabs">
        <li role="presentation" class="<?= $active === 'grid' ? 'active' : '' ?>">
            <?= $this->Html->link('グリッド表示', ['action' => 'index', '?' => $this->request->getQuery()]); ?>
        </li>
        <li role="presentation" class="<?= $active === 'list' ? 'active' : '' ?>">
            <?= $this->Html->link('リスト表示', ['action' => 'list', '?' => $this->request->getQuery()]); ?>
        </li>
    </ul>
</div>
