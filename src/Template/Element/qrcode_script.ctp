<!-- QRコードのクリップボードへのコピープラグイン初期化 -->
<?= $this->Html->script([
    "/assets/js/clipboard.min",
]) ?>
<script>
    $(function () {
        var clipboard = new Clipboard('#copy-btn');
    });
</script>
