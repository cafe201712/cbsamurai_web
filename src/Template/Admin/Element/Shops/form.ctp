<?php
use Cake\Core\Configure;
$pref = Configure::read('AppLocal.Pref');

echo $this->Form->control('name', ['label' => '店名', 'autofocus' => true]);
echo $this->Form->control('description', [
    'label' => '詳細説明',
    'placeholder' => 'お客様に表示する店舗の情報。サービス内容、料金、最寄り駅や営業日/時間等',
]);
echo $this->Form->control('zip', [
    'label' => '郵便番号',
    'placeholder' => '999-9999',
]);
echo $this->Form->control('pref', [
    'label' => '都道府県',
    'type' => 'select',
    'options' => array_combine($pref, $pref),
    'default' => '東京都',
]);
echo $this->Form->control('area', [
    'label' => 'エリア',
    'placeholder' => '検索や課金単価の差別化に使う地域名。都道府県＋エリア名でユニークにすること',
]);
echo $this->Form->control('address1', ['label' => '住所１', 'placeholder' => '市区町村と番地']);
echo $this->Form->control('address2', ['label' => '住所２', 'placeholder' => 'ビル名等']);
echo $this->Form->control('tel', [
    'label' => 'TEL',
    'placeholder' => '9999-9999-9999',
]);
echo $this->Form->control('fax', [
    'label' => 'FAX',
    'placeholder' => '9999-9999-9999',
]);
