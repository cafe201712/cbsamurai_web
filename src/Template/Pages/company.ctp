<?php
$this->setLayout('page');

$this->assign('page_id', 'pages-company');
$this->assign('title', '会社概要');
?>

<div class="spacer30">
    <h3 class="text-center">会社概要</h3>
    <dl class="dl-horizontal description spacer20">
        <dt>会社名</dt><dd>株式会社Vessel and Caliber</dd>
        <dt>住所</dt><dd>東京都新宿区西新宿１丁目２０－３西新宿高木ビル８階</dd>
        <dt>設立</dt><dd>2017年11月1日</dd>
        <dt>資本金</dt><dd>300万円</dd>
        <dt>事業概要</dt><dd>ウェブサービスの構築・運用</dd>
        <dt>連絡先</dt><dd><?= $this->Html->link("http://www.vessel-and-caliber.com", "#") ?></dd>
    </dl>
</div>

<div class="spacer30">
    <h3 class="text-center">会社沿革</h3>
    <dl class="dl-horizontal description spacer20">
        <dt>2017/8/1</dt><dd>ウェブサービス構築開始</dd>
        <dt>2017/9/1</dt><dd>クラウドファンディングにて資金調達</dd>
        <dt>2017/10/1</dt><dd>運営事務所を西新宿に開く</dd>
        <dt>2017/10/10</dt><dd>テストマーケティング開始</dd>
        <dt>2017/11/1</dt><dd>会社設立</dd>
        <dt>2017/11/2</dt><dd>ベータ版開始</dd>
    </dl>
</div>

<div class="spacer30">
    <h3 class="text-center">特定商取引法に関する事項</h3>
    <dl class="dl-horizontal description spacer20">
        <dt>事業者名</dt><dd>株式会社Vessel and Caliber</dd>
        <dt>運営責任者</dt><dd>鈴木智恵理</dd>
        <dt>開始時期</dt><dd>2017年10月1日</dd>
        <dt>営業時間</dt><dd>24時間　ただし電話窓口は10時から18時</dd>
        <dt>サイトURL</dt><dd>https://www.cbsamurai.jp</dd>
        <dt>問い合わせ用アドレス</dt><dd>info@cbsamurai.jp</dd>
        <dt>サイトポリシー</dt><dd>https://www.cbsamurai.jp</dd>
        <dt>料金</dt><dd>商品ページに記載</dd>
        <dt>支払い方法</dt><dd>クレジットカード・銀行振込</dd>
        <dt>支払い期日</dt><dd>商品ページ記載</dd>
        <dt>利用料以外の費用</dt><dd>送料、消費税</dd>
        <dt>返品・返金</dt><dd>基本的に返品・返金は応じません。</dd>
        <dt>免責事項</dt><dd>サイトポリシー記載の通り</dd>
        <dt>利用規約</dt><dd><?= $this->Html->link("https://www.cbsamurai.jp/pages/terms/", "/pages/terms/") ?></a></dd>
    </dl>
</div>

