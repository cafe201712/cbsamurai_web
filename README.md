# CBSAMURAI

きゃばサムライは、キャバ嬢との新しいコミュニケーションサービスです。

* キャバ嬢とメッセージのやりとりを楽しめるサービス。
* キャバ嬢とのメッセージが盛り上がることで、来店につなげる集客ツール。

## 要求事項

* PHP 7.0 以上
* MySQL 5 以上
* git, composer, npm, bower がインストール済であること。

## インストール

```
git clone https://github.com/cafe201712/cbsamurai_web
cd cbsamurai

composer install
npm install
bower install
gulp
```

## 環境設定

#### データベースを作成

* アプリが使用する DB を作成する。
* 照合順序は `utf8mb4_general_ci` とする。

#### .env ファイルを作成し、各自の環境に合わせて内容を変更

```
cp config/.env.default config/.env
vi config/.env
```

#### DB マイグレーション

```
bin/cake migrations migrate
```

#### DB 初期データ投入（DBを最初に作成した時のみ行う）

admin ユーザーの追加

```
bin/cake migrations seed --seed InitialSeed
```

## 動作確認

```
bin/cake server -H 0.0.0.0
```

http://localhost:8765 を表示する。
