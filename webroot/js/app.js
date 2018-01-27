$(function () {
    // ２重 Submit の防止
    $('form').submit(function () {
        $(this).find('button, input[type=submit]').attr('disabled', true);
    });

    // select2
    $('.select2').select2({
        theme: "bootstrap"
    });

    // アップロードするファイルのサイズチェック
    $('input[type=file]').on('change', function () {
        var $limit = 1024 * 1024 * 3; // 3 MByte
        var $size = this.files[0].size;

        if ($size > $limit) {
            alert('ファイルのサイズが大きすぎます。');
            this.value = "";
        }
    });
});